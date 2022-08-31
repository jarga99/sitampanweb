<?php

namespace App\Http\Controllers;
use App\Exports\Perkebunan_Export;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\ProduktivitasTanam;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TanamPerkebunanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        $data['title'] = 'Tanam Perkebunan';
        $data['kecamatans'] = Kecamatan::all();
        $data['desas'] = Desa::all();
        $data['tanamans'] = Tanaman::where('jenis_tanam', 3)->get();
        return view('tanam/tanam_perkebunan', $data,  compact('tanggalAwal', 'tanggalAkhir'));
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
        // cari tamaman yang jenis tanam sama tanam perkebunan
        $tanaman = Tanaman::where('jenis_tanam', 3)->pluck('id_tanaman');
        // get id user for created_by
        // $user   = auth()->user()->id_user;
        // ambil data berdasarkan tanaman id dalam array
        // $produktivitas_tanam = ProduktivitasTanam::with('user','mst_kecamatan', 'mst_desa', 'mst_tanaman')->where('created_by', $user)->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas_tanam', 'desc')->get();
        $produktivitas_tanam = ProduktivitasTanam::with('user','mst_kecamatan', 'mst_desa', 'mst_tanaman')->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas_tanam', 'desc');
        if($request->tanggal_awal != null && $request->tanggal_akhir != null) {
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
                return ($produktivitas_tanam->luas_lahan).' ha';
            })
            ->addColumn('created_by', function ($produktivitas_tanam) {
                return ($produktivitas_tanam->user->nama);
            })
            ->addColumn('created_at', function($produktivitas_tanam) {
                return \Carbon\Carbon::parse($produktivitas_tanam->created_at)->format('d-m-Y');
            })
            ->addColumn('aksi', function ($produktivitas_tanam) {
                return '
                <div class="btn-group">
                <button type="button" onclick="editForm('. $produktivitas_tanam->id_produktivitas_tanam . ');" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`' . route('tanam.delete_perkebunan', ['id' => $produktivitas_tanam->id_produktivitas_tanam]) . '`)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
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
        ProduktivitasTanam::create([
            'kecamatan_id' => $request->id_kecamatan,
            'desa_id' => $request->id_desa,
            'tanaman_id' => $request->id_tanaman,
            'luas_lahan' => $request->luas_lahan,
            'created_by' => auth()->user()->id_user,
            'created_at' => $request->tanggal
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
        $produktivitas_tanam = ProduktivitasTanam::where('id_produktivitas_tanam', $request->id_produktivitas_tanam)->first();
        return response()->json($produktivitas_tanam);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_produktivitas_tanam)
    {
        ProduktivitasTanam::where('id_produktivitas_tanam', $id_produktivitas_tanam)->update([
            // 'kecamatan_id' => $request->id_kecamatan,
            // 'desa_id' => $request->id_desa,
            'tanaman_id' => $request->id_tanaman,
            'luas_lahan' => $request->luas_lahan,
            'created_by' => 1,
            'created_at' => $request->tanggal
        ]);

        return response()->json('Data berhasil update', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_produktivitas_tanam)
    {
        ProduktivitasTanam::where('id_produktivitas_tanam', $id_produktivitas_tanam)->delete();
        return response()->json('Data berhasil hapus', 200);
    }

    public function pdf_tanam(Request $request)
    {
        $tanaman = Tanaman::where('jenis_tanam', 3)->pluck('id_tanaman');
        if($request->form_awal && $request->form_akhir) {
            $produktivitas_tanam = ProduktivitasTanam::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas_tanam = ProduktivitasTanam::whereIn('tanaman_id', $tanaman)->get();
        }

        $pdf = Pdf::loadView('tanam.pdf_tanam', compact('produktivitas_tanam'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function excel_perkebunan(Request $request)
    {
        return (new Perkebunan_Export)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('tanam_perkebunan.xlsx');
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produktivitas_tanam as $id) {
            $delSelected = ProduktivitasTanam::find($id);

            ProduktivitasTanam::where('id_produktivitas_tanam', $delSelected->id_produktivitas_tanam)->delete();
            Kecamatan::where('id_kecamatan', $delSelected->kecamatan_id)->delete();
            Desa::where('id_desa', $delSelected->desa_id)->delete();
            Tanaman::where('id_tanaman', $delSelected->tanaman_id)->delete();
        }
    }
}
