<?php

namespace App\Http\Controllers;
use App\Exports\HortiExport;
use App\Models\Produktivitas;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HeadPanenHortiController extends Controller
{
    public function index()
    {
        $data['title'] = 'Panen Horti';
        return view('head/panen/head_panen_horti', $data);
    }
    public function data()
    {
        // cari tamaman yang jenis tanam sama panen horti
        $tanaman = Tanaman::where('jenis_panen', 2)->pluck('id_tanaman');
        // ambil data berdasarkan tanaman id dalam array
        $produktivitas = Produktivitas::with('mst_kecamatan', 'mst_desa', 'mst_tanaman')->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas', 'desc')->get();
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
            ->addColumn('luas_lahan', function ($produktivitas) {
                return ($produktivitas->luas_lahan).' ha';
            })
            ->addColumn('kadar', function ($produktivitas) {
                return ($produktivitas->kadar).' %';
            })
            ->addColumn('produksi', function ($produktivitas) {
                return ($produktivitas->produksi).' ton';
            })
            ->addColumn('provitas', function ($produktivitas) {
                return ($produktivitas->provitas). ' ku/ha';
            })
            ->addColumn('harga', function ($produktivitas) {
                return 'Rp. '. format_uang($produktivitas->harga).',00';
            })
            ->addColumn('created_at', function($produktivitas) {
                return \Carbon\Carbon::parse($produktivitas->created_at)->format('d-m-Y');
            })
            ->addColumn('created_by', function ($produktivitas) {
                return ($produktivitas->user->nama);
            })
            ->make(true);
    }

    public function pdf_horti(Request $request)
    {
        $tanaman = Tanaman::where('jenis_panen', 2)->pluck('id_tanaman');
        if($request->form_awal && $request->form_akhir) {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->get();
        }

        $pdf = Pdf::loadView('panen.pdf_horti', compact('produktivitas'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function excel_horti(Request $request)
    {
        return (new HortiExport)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('panen_horti.xlsx');
    }

}
