<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Produktivitas;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TanamPajaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Tanam Pajale';
        $data['kecamatans'] = Kecamatan::all();
        $data['desas'] = Desa::all();
        $data['tanamans'] = Tanaman::all();
        return view('tanam/pajale',$data);
    }

    public function user_index()
    {
        $data['title'] = 'Tanam Pajale';
        return view('user/tanam/pajale',$data);
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

    public function data()
    {
        // cari tamaman yang jenis tanam sama tanam pajale
        $tanaman = Tanaman::where('jenis_tanam', 1)->pluck('id_tanaman');
        // ambil data berdasarkan tanaman id dalam array
        $produktivitas = Produktivitas::with('user','mst_kecamatan', 'mst_desa', 'mst_tanaman')->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas', 'desc')->get();
        return datatables()
            ->of($produktivitas)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produktivitas) {
                return '<input type="checkbox" name="id_produktivitas[]" value="' . $produktivitas->id_produktivitas . '">';
            })
            ->addColumn('id_kecamatan', function ($produktivitas) {
                return '<option value"' . $produktivitas->mst_kecamatan->nama_kecamtan . '">';
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
            ->addColumn('created_by', function ($produktivitas) {
                return ($produktivitas->user->nama ?? '-');
            })
            ->addColumn('created_at', function($produktivitas) {
                return \Carbon\Carbon::parse($produktivitas->created_at)->format('d-m-Y');
            })
            ->addColumn('aksi', function ($produktivitas) {
                return '
                <button type="button" onclick="editForm('. $produktivitas->id_produktivitas . ');" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`' . route('tanam.delete_pajale', ['id' => $produktivitas->id_produktivitas]) . '`)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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
            'created_by' => 1
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
    public function destroy($id_produktivitas)
    {
        Produktivitas::where('id_produktivitas', $id_produktivitas)->delete();
        return response()->json('Data berhasil hapus', 200);
    }
    public function pdf_pajale(Request $request)
    {
        $tanaman = Tanaman::where('jenis_tanam', 1)->pluck('id_tanaman');
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
        return (new PajaleExport)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('tanam_pajale.xlsx');
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produktivitas as $id) {
            $delSelected = Produktivitas::find($id);

            Produktivitas::where('id_produktivitas', $delSelected->id_produktivitas)->delete();
            Kecamatan::where('id_kecamatan', $delSelected->kecamatan_id)->delete();
            Desa::where('id_desa', $delSelected->desa_id)->delete();
            Tanaman::where('id_tanaman', $delSelected->tanaman_id)->delete();
        }
    }
}
