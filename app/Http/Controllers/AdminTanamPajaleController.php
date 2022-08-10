<?php

namespace App\Http\Controllers;

use App\Exports\Pajale_Export;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\ProduktivitasTanam;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdminTanamPajaleController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Tanam Pajale';
        $data['kecamatans'] = Kecamatan::all();
        $data['desas'] = Desa::all();
        $data['tanamans'] = Tanaman::where('jenis_tanam', 1)->get();
        return view('admin/tanam/admin_tanam_pajale', $data);
    }
    public function data()
    {
        // cari tamaman yang jenis tanam sama tanam Pajale
        $tanaman = Tanaman::where('jenis_tanam', 1)->pluck('id_tanaman');
        // $user = auth()->user()->id_user;
        // ambil data berdasarkan tanaman id dalam array
        $produktivitas_tanam = ProduktivitasTanam::with('user','mst_kecamatan', 'mst_desa', 'mst_tanaman')->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas_tanam', 'desc')->get();
        return datatables()
            ->of($produktivitas_tanam)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produktivitas_tanam) {
                return '<input type="checkbox" name="id_produktivitas_tanam[]" value="' . $produktivitas_tanam->id_produktivitas . '">';
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
                return ($produktivitas_tanam->luas_lahan ?? '0'). " ha" ;
            })
            ->addColumn('kadar', function ($produktivitas_tanam) {
                return ($produktivitas_tanam->kadar ?? '0') . " %";
            })
            ->addColumn('produksi', function ($produktivitas_tanam) {
                return ($produktivitas_tanam->produksi ?? '0') . " ton";
            })
            ->addColumn('provitas', function ($produktivitas_tanam) {
                return ($produktivitas_tanam->provitas ?? '0'). " ku/ha";
            })
            ->addColumn('harga', function ($produktivitas_tanam) {
                return "Rp. ". format_uang($produktivitas_tanam->harga). ",00";
            })
            ->addColumn('created_by', function ($produktivitas_tanam) {
                return $produktivitas_tanam->user->nama ?? '-';
            })
            ->addColumn('created_at', function($produktivitas_tanam) {
                return \Carbon\Carbon::parse($produktivitas_tanam->created_at)->format('d-m-Y');
            })
            // ->addColumn('aksi', function ($produktivitas_tanam) {
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
       ProduktivitasTanam::create([
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
        $tanaman = Tanaman::where('jenis_tanam', 1)->pluck('id_tanaman');
        if($request->form_awal && $request->form_akhir) {
            $produktivitas_tanam = ProduktivitasTanam::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas_tanam = ProduktivitasTanam::whereIn('tanaman_id', $tanaman)->get();
        }

        $pdf = Pdf::loadView('tanam.pdf_pajale', compact('produktivitas_tanam'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function excel_pajale(Request $request)
    {
        return (new Pajale_Export)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('tanam_pajale.xlsx');
    }
}
