<?php

namespace App\Http\Controllers;

use App\Exports\HortiExport;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Produktivitas;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanenHortiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Back End Index
    public function index(Request $request)
    {
        // function filter tanggal
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }
        // $total = Produktivitas::query()->select(['updated_at','sum(luas_lahan)'])->where('updated_at','>=','now() -interval 5 year')->groupBy('updated_at');
        $total = DB::select(DB::raw("SELECT updated_at, SUM(luas_lahan) FROM tb_produktivitas WHERE updated_at >= (now() -interval 5 year) GROUP BY updated_at"));
        // dump($total);
        // var_dump($total);
        $kadar = Produktivitas::query()->select(['updated_at','sum(kadar)'])->where('updated_at','>=','now() -interval 5 year')->groupBy('updated_at');
        $produksi = Produktivitas::query()->select(['updated_at','sum(produksi)'])->where('updated_at','>=','now() -interval 5 year')->groupBy('updated_at');
        $provitas = Produktivitas::query()->select(['updated_at','sum(provitas)'])->where('updated_at','>=','now() -interval 5 year')->groupBy('updated_at');
        $harga = Produktivitas::query()->select(['updated_at','sum(harga)'])->where('updated_at','>=','now() -interval 5 year')->groupBy('updated_at');

        $data['title'] = 'Panen Horti';
        $data['kecamatans'] = Kecamatan::all();
        $data['desas'] = Desa::all();
        $data['tanamans'] = Tanaman::where('jenis_panen', 2)->get();
        return view('panen/panen_horti', $data, compact('tanggalAwal', 'tanggalAkhir','total','kadar','produksi','provitas','harga'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function data(Request $request)
    {


        // cari tamaman yang jenis tanam sama panen horti
        $tanaman = Tanaman::where('jenis_panen', 2)->pluck('id_tanaman');
        // $user = auth()->user()->id_user;
        // ambil data berdasarkan tanaman id dalam array
        $produktivitas = Produktivitas::with('user','mst_kecamatan', 'mst_desa', 'mst_tanaman')->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas', 'desc');
        if($request->tanggal_awal != null && $request->tanggal_akhir != null) {
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
                return ($produktivitas->luas_lahan). ' ha' ;
            })
            ->addColumn('kadar', function ($produktivitas) {
                return ($produktivitas->kadar) . ' %';
            })
            ->addColumn('produksi', function ($produktivitas) {
                return ($produktivitas->produksi) . ' ton';
            })
            ->addColumn('provitas', function ($produktivitas) {
                return ($produktivitas->provitas) . ' ku/ha';
            })
            ->addColumn('harga', function ($produktivitas) {
                return 'Rp. '. format_uang($produktivitas->harga).',00';
            })
            ->addColumn('created_by', function ($produktivitas) {
                return ($produktivitas->user->nama);
            })
            ->addColumn('created_at', function($produktivitas) {
                return \Carbon\Carbon::parse($produktivitas->created_at)->format('d-m-Y');
            })
            ->addColumn('aksi', function ($produktivitas) {
                return '
                <div class="btn-group">
                <button type="button" onclick="editForm('. $produktivitas->id_produktivitas . ');" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`' . route('panen.delete_horti', ['id' => $produktivitas->id_produktivitas]) . '`)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                </div>
            ';
            return "Ok";
            })
            ->rawColumns(['aksi', 'select_all'])
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $produktivitas = Produktivitas::where('id_produktivitas', $request->id_produktivitas)->first();
        return response()->json($produktivitas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_produktivitas)
    {
        Produktivitas::where('id_produktivitas', $id_produktivitas)->update([
            'kecamatan_id' => $request->id_kecamatan,
            'desa_id' => $request->id_desa,
            'tanaman_id' => $request->id_tanaman,
            'kadar' => $request->kadar,
            'produksi' => $request->produksi,
            'provitas' => $request->provitas,
            'harga' => $request->harga,
            'luas_lahan' => $request->luas_lahan,
            'created_by' => 1
        ]);

        return response()->json('Data berhasil update', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id_produktivitas)
    {
        Produktivitas::where('id_produktivitas', $id_produktivitas)->delete();
        return response()->json('Data berhasil hapus', 200);
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

    // public function deleteSelected(Request $request)
    // {
    //     foreach ($request->id_produktivitas as $id_produktivitas) {
    //         $delSelected = Produktivitas::find($id_produktivitas);

    //         Produktivitas::where('id_produktivitas', $delSelected->$id_produktivitas)->delete();

    //         // Produktivitas::where('id_produktivitas', $delSelected->id_produktivitas)->delete();
    //         // Kecamatan::where('id_kecamatan', $delSelected->kecamatan_id)->delete();
    //         // Desa::where('id_desa', $delSelected->desa_id)->delete();
    //         // Tanaman::where('id_tanaman', $delSelected->tanaman_id)->delete();

    //         $delSelected->delete();
    //     }
    //     return response(null, 204);
    // }
}
