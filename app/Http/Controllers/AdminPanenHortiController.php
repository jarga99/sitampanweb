<?php

namespace App\Http\Controllers;

use App\Exports\HortiExport;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Produktivitas;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\Promise\all;

class AdminPanenHortiController extends Controller
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
        $data['kecamatans'] = Kecamatan::all();
        $data['desas'] = Desa::all();
        $data['tanamans'] = Tanaman::where('jenis_panen', 2)->get();
        $data['is_kecamatan'] = Auth::user()->kecamatan_id ?? "";
        return view('admin/panen/admin_panen_horti', $data, compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function data(Request $request)
    {
        // cari tamaman yang jenis tanam sama panen horti
        $tanaman = Tanaman::where('jenis_panen', 2)->pluck('id_tanaman');
        $user = auth()->user()->id_user;
        // ambil data berdasarkan tanaman id dalam array
        $produktivitas = Produktivitas::with('user', 'mst_kecamatan', 'mst_desa', 'mst_tanaman')->where('created_by',$user)->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas', 'desc');
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
            ->addColumn('luas_lahan', function ($produktivitas) {
                return ($produktivitas->luas_lahan ?? '0') . " ha";
            })
            ->addColumn('kadar', function ($produktivitas) {
                return ($produktivitas->kadar ?? '0') . " %";
            })
            ->addColumn('produksi', function ($produktivitas) {
                return ($produktivitas->produksi ?? '0') . " ton";
            })
            ->addColumn('provitas', function ($produktivitas) {
                return ($produktivitas->provitas ?? '0') . " ku/ha";
            })
            ->addColumn('harga', function ($produktivitas) {
                return "Rp. " . ($produktivitas->harga);
            })
            ->addColumn('created_by', function ($produktivitas) {
                return $produktivitas->user->nama ?? '-';
            })
            ->addColumn('created_at', function ($produktivitas) {
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
            'created_by' => auth()->user()->id_user,
        ]);
        return response()->json('Data berhasil disimpan', 200);
    }

    public function pdf_panen_horti(Request $request)
    {
        $tanaman = Tanaman::where('jenis_panen', 2)->pluck('id_tanaman');
        $user = auth()->user()->id_user;
        if ($request->form_awal && $request->form_akhir) {
            $produktivitas = Produktivitas::where('created_by',$user)->whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas = Produktivitas::where('created_by',$user)->whereIn('tanaman_id', $tanaman)->get();
        }

        $pdf = Pdf::loadView('admin.panen.pdf_panen_horti', compact('produktivitas'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function excel_horti(Request $request)
    {
        return (new HortiExport)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('panen_horti.xlsx');
    }
}
