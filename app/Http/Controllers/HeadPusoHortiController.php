<?php

namespace App\Http\Controllers;

use App\Exports\_HortiExport;
use App\Exports\HortiExport;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\ProduktivitasPuso;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HeadPusoHortiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $data['kecamatans'] = Kecamatan::all();
        $data['desas'] = Desa::all();
        $data['tanamans'] = Tanaman::where('jenis_puso', 2)->get();
        return view('head/puso/head_puso_horti', $data, compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function data(Request $request)
    {
        // cari tamaman yang jenis tanam sama puso horti
        $tanaman = Tanaman::where('jenis_puso', 2)->pluck('id_tanaman');
        // $user =  auth()->user()->id_user;
        // ambil data berdasarkan tanaman id dalam array
        $produktivitas_puso = ProduktivitasPuso::with('mst_kecamatan', 'mst_desa', 'mst_tanaman')->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas_puso', 'desc');
        if($request->tanggal_awal != null && $request->tanggal_akhir != null) {
            $produktivitas_puso = $produktivitas_puso->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        // $produktivitas_puso = $produktivitas_puso->get();
        return datatables()
            ->of($produktivitas_puso)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produktivitas_puso) {
                return '<input type="checkbox" name="id_produktivitas_puso[]" value="' . $produktivitas_puso->id_produktivitas_puso . '">';
            })
            ->addColumn('id_kecamatan', function ($produktivitas_puso) {
                return '<option value"' . $produktivitas_puso->mst_kecamatan->nama_kecamatan . '">';
            })
            ->addColumn('id_desa', function ($produktivitas_puso) {
                return '<option value"' . $produktivitas_puso->mst_desa->nama_desa . '">';
            })
            ->addColumn('id_tanaman', function ($produktivitas_puso) {
                return '<option value"' . $produktivitas_puso->mst_tanaman->nama_tanaman . '">';
            })
            ->addColumn('lh_habis', function ($produktivitas_puso) {
                return ($produktivitas_puso->lh_habis) . ' ha';
            })
            ->addColumn('lh_blm_habis', function ($produktivitas_puso) {
                return ($produktivitas_puso->lh_blm_habis) . ' ha';
            })
            ->addColumn('kadar', function ($produktivitas_puso) {
                return ($produktivitas_puso->kadar). ' %';
            })
            ->addColumn('habis', function ($produktivitas_puso) {
                return ($produktivitas_puso->habis) . ' ton';
            })
            ->addColumn('blm_habis', function ($produktivitas_puso) {
                return ($produktivitas_puso->blm_habis) . ' ton';
            })
            ->addColumn('provitas', function ($produktivitas_puso) {
                return ($produktivitas_puso->provitas). ' ton';
            })
            ->addColumn('harga', function ($produktivitas_puso) {
                return 'Rp. '.($produktivitas_puso->harga);
            })
            ->addColumn('created_by', function ($produktivitas_puso) {
                return ($produktivitas_puso->user->nama);
            })
            ->addColumn('updated_at', function ($produktivitas_puso) {
                return \Carbon\Carbon::parse($produktivitas_puso->updated_at)->format('d-m-Y');
            })
            ->make(true);
    }

    public function pdf_puso_horti(Request $request)
    {
        // $user =  auth()->user()->id_user;
        $tanaman = Tanaman::where('jenis_puso', 2)->pluck('id_tanaman');
        if($request->form_awal && $request->form_akhir) {
            $produktivitas_puso = ProduktivitasPuso::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas_puso = ProduktivitasPuso::whereIn('tanaman_id', $tanaman)->get();
        }
        $total = DB::select(DB::raw("
        SELECT
            id_produktivitas_puso,
            tb_produktivitas_puso.updated_at AS updated_at,
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
            luas_lahan,
            (
                SELECT ROUND(SUM(lh_habis) , 2) FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) as total_lh_habis,(
                SELECT ROUND(SUM(lh_blm_habis) , 2) FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) as total_lh_blm_habis,(
                SELECT ROUND(AVG(kadar) , 2) FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) as avg_kadar,(
                SELECT ROUND(SUM(habis) , 2) FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) AS total_habis,(
                SELECT ROUND(SUM(blm_habis) , 2) FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) AS total_blm_habis,(
                SELECT ROUND(AVG(provitas) , 2) FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_puso = 2
            ) AS avg_provitas,(
                SELECT ROUND(AVG(harga) , 2) FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_puso = 2
            ) AS avg_harga
        FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
        INNER JOIN mst_kecamatan ON id_kecamatan = kecamatan_id
        INNER JOIN mst_desa ON id_desa = desa_id
        INNER JOIN tb_user ON tb_user.id_user = created_by
        WHERE jenis_puso = 2
        AND tb_produktivitas_puso.updated_at >= (now() -interval 5 year)
        GROUP BY id_produktivitas_puso
    "));
        $pdf = Pdf::loadView('head.puso.pdf_puso_horti', compact('produktivitas_puso','total'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function excel_horti(Request $request)
    {
        return (new _HortiExport)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('puso_horti.xlsx');
    }


}
