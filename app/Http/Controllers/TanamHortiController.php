<?php

namespace App\Http\Controllers;

use App\Exports\Horti_Export;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\ProduktivitasTanam;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TanamHortiController extends Controller
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

        $data['title'] = 'Tanam Horti';
        $data['kecamatans'] = Kecamatan::all();
        $data['desas'] = Desa::all();
        $data['tanamans'] = Tanaman::where('jenis_tanam', 2)->get();
        return view('tanam/tanam_horti',$data, compact('tanggalAwal', 'tanggalAkhir'));
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
        // cari tamaman yang jenis tanam sama tanam horti
        $tanaman = Tanaman::where('jenis_tanam', 2)->pluck('id_tanaman');
        // $user = auth()->user()->id_user;
        // ambil data berdasarkan tanaman id dalam array
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
            ->addColumn('updated_at', function($produktivitas_tanam) {
                return \Carbon\Carbon::parse($produktivitas_tanam->updated_at)->format('d-m-Y');
            })
            ->addColumn('aksi', function ($produktivitas_tanam) {
                return '
                <div class="btn-group">
                <button type="button" onclick="editForm('. $produktivitas_tanam->id_produktivitas_tanam . ');" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`' . route('tanam.delete_horti', ['id' => $produktivitas_tanam->id_produktivitas_tanam]) . '`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
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
            'updated_by' => auth()->user()->id_user,
            'updated_at' => $request->tanggal
        ]);
        return response()->json('Data berhasil update', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id_produktivitas_tanam)
    {
        ProduktivitasTanam::where('id_produktivitas_tanam', $id_produktivitas_tanam)->delete();
        return response()->json('Data berhasil hapus', 200);
    }

    public function pdf_tanam_horti(Request $request)
    {
        $tanaman = Tanaman::where('jenis_tanam', 2)->pluck('id_tanaman');
        if($request->form_awal && $request->form_akhir) {
            $produktivitas_tanam = ProduktivitasTanam::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas_tanam = ProduktivitasTanam::whereIn('tanaman_id', $tanaman)->get();
        }
        $total = DB::select(DB::raw("
        SELECT
            id_produktivitas_tanam,
            tb_produktivitas_tanam.updated_at AS updated_at,
            SUM(luas_lahan) AS luas_lahan,
            nama_kecamatan,
            nama_desa,
            nama_tanaman,
            tb_user.nama,
            luas_lahan,
            (
                SELECT ROUND(SUM(luas_lahan) , 2) FROM tb_produktivitas_tanam INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) as total_luas_lahan
        FROM tb_produktivitas_tanam INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
        INNER JOIN mst_kecamatan ON id_kecamatan = kecamatan_id
        INNER JOIN mst_desa ON id_desa = desa_id
        INNER JOIN tb_user ON tb_user.id_user = created_by
        WHERE jenis_panen = 2
        AND tb_produktivitas_tanam.updated_at >= (now() -interval 5 year)
        GROUP BY id_produktivitas_tanam
    "));

        $pdf = Pdf::loadView('tanam.pdf_tanam_horti', compact('produktivitas_tanam','total'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function excel_horti(Request $request)
    {
        return (new Horti_Export)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('tanam_horti.xlsx');
    }

    // public function deleteSelected(Request $request)
    // {
    //     foreach ($request->id_produktivitas_tanam as $id) {
    //         $delSelected = ProduktivitasTanam::find($id);

    //         ProduktivitasTanam::where('id_produktivitas_tanam', $delSelected->id_produktivitas_tanam)->delete();
    //         Kecamatan::where('id_kecamatan', $delSelected->kecamatan_id)->delete();
    //         Desa::where('id_desa', $delSelected->desa_id)->delete();
    //         Tanaman::where('id_tanaman', $delSelected->tanaman_id)->delete();
    //     }
    // }
}
