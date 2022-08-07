<?php

namespace App\Http\Controllers;
use App\Exports\Pajale_Export;
use App\Models\ProduktivitasTanam;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class UserTanamPajaleController extends Controller
{
    public function index()
    {
        $data['title'] = 'Tanam Pajale';
        return view('user/tanam/user_tanam_pajale',$data);
    }

    public function data()
    {
        // cari tamaman yang jenis tanam sama tanam horti
        $tanaman = Tanaman::where('jenis_tanam', 1)->pluck('id_tanaman');
        // ambil data berdasarkan tanaman id dalam array
        $produktivitas_tanam = ProduktivitasTanam::with('mst_kecamatan', 'mst_desa', 'mst_tanaman')->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas_tanam', 'desc')->get();
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
                return ($produktivitas_tanam->luas_lahan ?? '0');
            })
            ->addColumn('kadar', function ($produktivitas_tanam) {
                return ($produktivitas_tanam->kadar ?? '0');
            })
            ->addColumn('produksi', function ($produktivitas_tanam) {
                return ($produktivitas_tanam->produksi ?? '0');
            })
            ->addColumn('provitas', function ($produktivitas_tanam) {
                return ($produktivitas_tanam->provitas ?? '0');
            })
            ->addColumn('harga', function ($produktivitas_tanam) {
                return ($produktivitas_tanam->harga ?? '0');
            })
            ->addColumn('created_at', function($produktivitas_tanam) {
                return \Carbon\Carbon::parse($produktivitas_tanam->created_at)->format('d-m-Y');
            })
            ->addColumn('aksi', function ($produktivitas_tanam) {
                return '
                <button type="button" onclick="editForm('. $produktivitas_tanam->id_produktivitas_tanam . ');" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`' . route('tanam.delete_pajale', ['id' => $produktivitas_tanam->id_produktivitas_tanam]) . '`)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
            ';
            return "Ok";
            })
            ->rawColumns(['aksi', 'select_all'])
            ->make(true);
    }
    public function pdf_pajale(Request $request)
    {
        $tanaman = Tanaman::where('jenis_panen', 1)->pluck('id_tanaman');
        if($request->form_awal && $request->form_akhir) {
            $produktivitas_tanam = ProduktivitasTanam::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas_tanam = ProduktivitasTanam::whereIn('tanaman_id', $tanaman)->get();
        }

        $pdf = Pdf::loadView('tanam.pdf_pajale', compact('produktivitas_tanam'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function excel_pajale(Request $request)
    {
        return (new Pajale_Export)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('tanam_pajale.xlsx');
    }
}
