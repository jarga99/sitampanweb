<?php

namespace App\Http\Controllers;
use App\Exports\Pajale_Export;
use App\Models\Produktivitas;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class UserTanamPajaleController extends Controller
{
    public function index()
    {
        $data['title'] = 'Tanam Pajale';
        return view('user/tanam/pajale',$data);
    }

    public function data()
    {
        // cari tamaman yang jenis tanam sama tanam horti
        $tanaman = Tanaman::where('jenis_tanam', 1)->pluck('id_tanaman');
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
                return ($produktivitas->luas_lahan ?? '0');
            })
            ->addColumn('kadar', function ($produktivitas) {
                return ($produktivitas->kadar ?? '0');
            })
            ->addColumn('produksi', function ($produktivitas) {
                return ($produktivitas->produksi ?? '0');
            })
            ->addColumn('provitas', function ($produktivitas) {
                return ($produktivitas->provitas ?? '0');
            })
            ->addColumn('harga', function ($produktivitas) {
                return ($produktivitas->harga ?? '0');
            })
            ->addColumn('created_at', function($produktivitas) {
                return \Carbon\Carbon::parse($produktivitas->created_at)->format('d-m-Y');
            })
            ->addColumn('aksi', function ($produktivitas) {
                return '
                <button type="button" onclick="editForm('. $produktivitas->id_produktivitas . ');" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`' . route('tanam.delete_pajale', ['id' => $produktivitas->id_produktivitas]) . '`)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
            ';
            return "Ok";
            })
            ->rawColumns(['aksi', 'select_all'])
            ->make(true);
    }
    public function pdf_pajale(Request $request)
    {
        $tanaman = Tanaman::where('jenis_panen', 2)->pluck('id_tanaman');
        if($request->form_awal && $request->form_akhir) {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->get();
        }

        $pdf = Pdf::loadView('tanam.pdf_pajale', compact('produktivitas'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function excel_pajale(Request $request)
    {
        return (new Pajale_Export)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('tanam_pajale.xlsx');
    }
}
