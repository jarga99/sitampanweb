<?php

namespace App\Http\Controllers;

use App\Exports\PajaleExport;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Produktivitas;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdminPanenPajaleController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Panen Pajale';
        $data['kecamatans'] = Kecamatan::all();
        $data['desas'] = Desa::all();
        $data['tanamans'] = Tanaman::where('jenis_panen', 1)->get();
        return view('admin/panen/admin_panen_pajale', $data);
    }
    public function data()
    {
        // cari tamaman yang jenis tanam sama panen Pajale
        $tanaman = Tanaman::where('jenis_panen', 1)->pluck('id_tanaman');
        // $user = auth()->user()->id_user;
        // ambil data berdasarkan tanaman id dalam array
        $produktivitas = Produktivitas::with('user','mst_kecamatan', 'mst_desa', 'mst_tanaman')->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas', 'desc')->get();
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
                return ($produktivitas->luas_lahan ?? '0'). " ha" ;
            })
            ->addColumn('kadar', function ($produktivitas) {
                return ($produktivitas->kadar ?? '0') . " %";
            })
            ->addColumn('produksi', function ($produktivitas) {
                return ($produktivitas->produksi ?? '0') . " ton";
            })
            ->addColumn('provitas', function ($produktivitas) {
                return ($produktivitas->provitas ?? '0'). " ku/ha";
            })
            ->addColumn('harga', function ($produktivitas) {
                return "Rp. ". format_uang($produktivitas->harga). ",00";
            })
            ->addColumn('created_by', function ($produktivitas) {
                return $produktivitas->user->nama ?? '-';
            })
            ->addColumn('created_at', function($produktivitas) {
                return \Carbon\Carbon::parse($produktivitas->created_at)->format('d-m-Y');
            })
            // ->addColumn('aksi', function ($produktivitas) {
            //     return '            // ->rawColumns(['aksi', 'select_all'])
            // ';
            // return "Ok";
            // })
            // ->rawColumns(['aksi', 'select_all'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       Produktivitas::create([
        'kecamatan_id' => $request->id_kecamatan,
        'desa_id' => $request->id_desa,
        'tanaman_id' => $request->id_tanaman,
        'kadar' => $request->kadar,
        'produksi' => $request->produksi,
        'provitas' => $request->provitas,
        'harga' => $request->harga,
        'luas_lahan' => $request->luas_lahan,
        'created_by' => auth()->user()->id_user
       ]);
       return response()->json('Data berhasil disimpan', 200);
    }

    public function pdf_pajale(Request $request)
    {
        $tanaman = Tanaman::where('jenis_panen', 1)->pluck('id_tanaman');
        if($request->form_awal && $request->form_akhir) {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->get();
        }

        $pdf = Pdf::loadView('panen.pdf_pajale', compact('produktivitas'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function excel_pajale(Request $request)
    {
        return (new PajaleExport)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('panen_pajale.xlsx');
    }
}
