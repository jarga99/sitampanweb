<?php

namespace App\Http\Controllers;

use App\Exports\Perkebunan_Export;
use App\Models\ProduktivitasTanam;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class UserTanamPerkebunanController extends Controller
{
    public function index()
    {
        $data['title'] = 'Tanam Perkebunan';
        return view('user/tanam/user_tanam_perkebunan',$data);
    }

    public function data()
    {
        // cari tamaman yang jenis tanam sama tanam horti
        $tanaman = Tanaman::where('jenis_tanam', 3)->pluck('id_tanaman');
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
                return ($produktivitas_tanam->luas_lahan).' ha';
            })
            ->addColumn('created_at', function($produktivitas_tanam) {
                return \Carbon\Carbon::parse($produktivitas_tanam->created_at)->format('d-m-Y');
            })
            // ->addColumn('aksi', function ($produktivitas_tanam) {
            //     return '
            //     <div class="btn-group">
            //     <button type="button" onclick="editForm('. $produktivitas_tanam->id_produktivitas_tanam . ');" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></button>
            //     <button type="button" onclick="deleteData(`' . route('tanam.delete_perkebunan', ['id' => $produktivitas_tanam->id_produktivitas_tanam]) . '`)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
            //     </div>
            // ';
            // return "Ok";
            // })
            // ->rawColumns(['aksi', 'select_all'])
            ->make(true);
    }
    public function pdf_perkebunan(Request $request)
    {
        $tanaman = Tanaman::where('jenis_panen', 3)->pluck('id_tanaman');
        if($request->form_awal && $request->form_akhir) {
            $produktivitas_tanam = ProduktivitasTanam::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas_tanam = ProduktivitasTanam::whereIn('tanaman_id', $tanaman)->get();
        }

        $pdf = Pdf::loadView('tanam.pdf_perkebunan', compact('produktivitas_tanam'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function excel_perkebunan(Request $request)
    {
        return (new Perkebunan_Export)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('tanam_perkebunan.xlsx');
    }
}
