<?php

namespace App\Http\Controllers;

use App\Exports\Perkebunan_Export;
use App\Models\ProduktivitasTanam;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeadTanamPerkebunanController extends Controller
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
        $data['title'] = 'Tanam Perkebunan';
        return view('head/tanam/head_tanam_perkebunan', $data,  compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function data(Request $request)
    {
        // cari tamaman yang jenis tanam sama tanam horti
        $tanaman = Tanaman::where('jenis_tanam', 3)->pluck('id_tanaman');
        // ambil data berdasarkan tanaman id dalam array
        $produktivitas_tanam = ProduktivitasTanam::with('mst_kecamatan', 'mst_desa', 'mst_tanaman')->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas_tanam', 'desc');
        if ($request->tanggal_awal != null && $request->tanggal_akhir != null) {
            $produktivitas_tanam = $produktivitas_tanam->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        $produktivitas_tanam = $produktivitas_tanam->get();

        return datatables()
            ->of($produktivitas_tanam)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produktivitas_tanam) {
                return '<input type="checkbox" name="id_produktivitas_tanam[]" value="' . $produktivitas_tanam->id_produktivitas_tanam . '">';
            })
            ->addColumn('id_kecamatan', function ($produktivitas_tanam) {
                return '<option value"' . $produktivitas_tanam->mst_kecamatan->nama_kecamatan . '">';
            })
            ->addColumn('id_desa', function ($produktivitas_tanam) {
                return '<option value"' . $produktivitas_tanam->mst_desa->nama_desa . '">';
            })
            ->addColumn('id_tanaman', function ($produktivitas_tanam) {
                return '<option value"' . $produktivitas_tanam->mst_tanaman->nama_tanaman . '">';
            })
            ->addColumn('luas_lahan', function ($produktivitas_tanam) {
                return ($produktivitas_tanam->luas_lahan) . ' ha';
            })
            ->addColumn('updated_at', function ($produktivitas_tanam) {
                return \Carbon\Carbon::parse($produktivitas_tanam->updated_at)->format('d-m-Y');
            })
            ->addColumn('created_by', function ($produktivitas) {
                return ($produktivitas->user->nama);
            })

            ->make(true);
    }
    public function pdf_tanam_perkebunan(Request $request)
    {
        $tanaman = Tanaman::where('jenis_panen', 3)->pluck('id_tanaman');
        if ($request->form_awal && $request->form_akhir) {
            $produktivitas_tanam = ProduktivitasTanam::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas_tanam = ProduktivitasTanam::whereIn('tanaman_id', $tanaman)->get();
        }
        $total = DB::select(DB::raw("
        SELECT
            id_produktivitas_tanam,
            tb_produktivitas_tanam.updated_at AS updated_at,
            SUM(luas_lahan) AS luas_lahan,
            nama_kecamatan,
            nama_desa,
            nama_tanaman,
            tb_user.nama,
            luas_lahan,
            (
                SELECT ROUND(SUM(luas_lahan) , 2) FROM tb_produktivitas_tanam INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 3
            ) as total_luas_lahan
        FROM tb_produktivitas_tanam INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
        INNER JOIN mst_kecamatan ON id_kecamatan = kecamatan_id
        INNER JOIN mst_desa ON id_desa = desa_id
        INNER JOIN tb_user ON tb_user.id_user = created_by
        WHERE jenis_panen = 3
        AND tb_produktivitas_tanam.updated_at >= (now() -interval 5 year)
        GROUP BY id_produktivitas_tanam
    "));


        $pdf = Pdf::loadView('head.tanam.pdf_tanam_perkebunan', compact('produktivitas_tanam','total'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function excel_perkebunan(Request $request)
    {
        return (new Perkebunan_Export)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('tanam_perkebunan.xlsx');
    }
}
