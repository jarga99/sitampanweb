<?php

namespace App\Http\Controllers;
use App\Exports\HortiExport;
use App\Models\Produktivitas;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeadPanenHortiController extends Controller
{
    public function index(Request $request)
    {
         // function filter tanggal
         $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
         $tanggalAkhir = date('Y-m-d');

         if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
             $tanggalAwal = $request->tanggal_awal;
             $tanggalAkhir = $request->tanggal_akhir;
         }

        $data['title'] = 'Panen Horti';
        return view('head/panen/head_panen_horti', $data, compact('tanggalAwal', 'tanggalAkhir'));
    }
    public function data(Request $request)
    {
        // cari tamaman yang jenis tanam sama panen horti
        $tanaman = Tanaman::where('jenis_panen', 2)->pluck('id_tanaman');
        // ambil data berdasarkan tanaman id dalam array
        $produktivitas = Produktivitas::with('mst_kecamatan', 'mst_desa', 'mst_tanaman')->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas', 'desc');
        if ($request->tanggal_awal != null && $request->tanggal_akhir != null) {
            $produktivitas = $produktivitas->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        $produktivitas = $produktivitas->get();

        return datatables()
            ->of($produktivitas)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produktivitas) {
                return '<input type="checkbox" name="id_produktivitas[]" value="' . $produktivitas->id_produktivitas . '">';
            })
            ->addColumn('id_kecamatan', function ($produktivitas) {
                return '<option value"' . $produktivitas->mst_kecamatan->nama_kecamatan . '">';
            })
            ->addColumn('id_desa', function ($produktivitas) {
                return '<option value"' . $produktivitas->mst_desa->nama_desa . '">';
            })
            ->addColumn('id_tanaman', function ($produktivitas) {
                return '<option value"' . $produktivitas->mst_tanaman->nama_tanaman . '">';
            })
            ->addColumn('lh_habis', function ($produktivitas) {
                return ($produktivitas->lh_habis) . ' ha';
            })
            ->addColumn('lh_blm_habis', function ($produktivitas) {
                return ($produktivitas->lh_blm_habis) . ' ha';
            })
            ->addColumn('kadar', function ($produktivitas) {
                return ($produktivitas->kadar).' %';
            })
            ->addColumn('habis', function ($produktivitas) {
                return ($produktivitas->habis) . ' ton';
            })
            ->addColumn('blm_habis', function ($produktivitas) {
                return ($produktivitas->blm_habis) . ' ton';
            })
            ->addColumn('provitas', function ($produktivitas) {
                return ($produktivitas->provitas). ' ton';
            })
            ->addColumn('harga', function ($produktivitas) {
                return 'Rp. '.($produktivitas->harga);
            })
            ->addColumn('updated_at', function($produktivitas) {
                return \Carbon\Carbon::parse($produktivitas->updated_at)->format('d-m-Y');
            })
            ->addColumn('created_by', function ($produktivitas) {
                return ($produktivitas->user->nama);
            })
            ->make(true);
    }

    public function pdf_panen_horti(Request $request)
    {
        $tanaman = Tanaman::where('jenis_panen', 2)->pluck('id_tanaman');
        if($request->form_awal && $request->form_akhir) {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->get();
        }
        $total = DB::select(DB::raw("
        SELECT
            id_produktivitas,
            tb_produktivitas.updated_at AS updated_at,
            SUM(lh_habis) AS lh_habis,
            lh_blm_habis,
            ROUND(kadar , 2) AS kadar,
            habis,
            blm_habis,
            harga,
            nama_kecamatan,
            nama_desa,
            nama_tanaman,
            provitas,
            tb_user.nama,
            lh_habis,
            (
                SELECT ROUND(SUM(lh_habis) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) as total_lh_habis,(
                SELECT ROUND(SUM(lh_blm_habis) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) as total_lh_blm_habis,(
                SELECT ROUND(AVG(kadar) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) as avg_kadar,(
                SELECT ROUND(SUM(habis) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) AS total_habis,(
                SELECT ROUND(SUM(blm_habis) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) AS total_blm_habis,(
                SELECT ROUND(AVG(provitas) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) AS avg_provitas,(
                SELECT ROUND(AVG(harga) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) AS avg_harga
        FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
        INNER JOIN mst_kecamatan ON id_kecamatan = kecamatan_id
        INNER JOIN mst_desa ON id_desa = desa_id
        INNER JOIN tb_user ON tb_user.id_user = created_by
        WHERE jenis_panen = 2
        AND tb_produktivitas.updated_at >= (now() -interval 5 year)
        GROUP BY id_produktivitas
    "));

        $pdf = Pdf::loadView('head.panen.pdf_panen_horti', compact('produktivitas','total'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function excel_horti(Request $request)
    {
        return (new HortiExport)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('panen_horti.xlsx');
    }

}
