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

        $data['title'] = 'Panen Horti';
        $data['kecamatans'] = Kecamatan::all();
        $data['desas'] = Desa::all();
        $data['tanamans'] = Tanaman::where('jenis_panen', 2)->get();
        return view('panen/panen_horti', $data, compact('tanggalAwal', 'tanggalAkhir'));
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
            ->addColumn('lh_habis', function ($produktivitas) {
                return ($produktivitas->lh_habis) . ' ha';
            })
            ->addColumn('lh_blm_habis', function ($produktivitas) {
                return ($produktivitas->lh_blm_habis) . ' ha';
            })
            ->addColumn('kadar', function ($produktivitas) {
                return ($produktivitas->kadar) . ' %';
            })
            ->addColumn('habis', function ($produktivitas) {
                return ($produktivitas->habis) . ' ton';
            })
            ->addColumn('blm_habis', function ($produktivitas) {
                return ($produktivitas->blm_habis) . ' ton';
            })
            ->addColumn('provitas', function ($produktivitas) {
                return ($produktivitas->provitas) . ' ku/ha';
            })
            ->addColumn('harga', function ($produktivitas) {
                return 'Rp. '. ($produktivitas->harga);
            })
            ->addColumn('created_by', function ($produktivitas) {
                return ($produktivitas->user->nama);
            })
            ->addColumn('updated_at', function($produktivitas) {
                return \Carbon\Carbon::parse($produktivitas->updated_at)->format('d-m-Y');
            })
            ->addColumn('aksi', function ($produktivitas) {
                // <button type="button" onclick="showDetail(`'. route('panen.detail_horti',['id' => $produktivitas->id_produktivitas]) .'`)" class="btn btn-xs btn-info "><i class="fa fa-eye"></i></button>
                return '
                <div class="btn-group">
                <button type="button" onclick="editForm('. $produktivitas->id_produktivitas . ');" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`' . route('panen.delete_horti', ['id' => $produktivitas->id_produktivitas]) . '`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
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
        'lh_habis' => $request->lh_habis,
        'lh_blm_habis' => $request->lh_blm_habis,
        'kadar' => $request->kadar,
        'habis' => $request->habis,
        'blm_habis' => $request->blm_habis,
        'provitas' => $request->provitas,
        'harga' => $request->harga,
        'created_by' => auth()->user()->id_user,
        'created_at' => $request->tanggal
       ]);
       return response()->json('Data berhasil disimpan', 200);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show( Request $request )
    // {
    //     $produktivitas = Produktivitas::where('id_produktivitas', $request->id_produktivitas)->first();
    //     return response()->json($produktivitas);
    // }

    // public function detail( $id_produktivitas)
    // {
    //     // cari tamaman yang jenis tanam sama panen horti
    //     $tanaman = Tanaman::where('jenis_panen', 2)->pluck('id_tanaman');
    //     $detail = Produktivitas::with('user','mst_kecamatan', 'mst_desa', 'mst_tanaman')
    //     ->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas','desc', $id_produktivitas)->first();

    //      return datatables()
    //          ->of($detail)
    //          ->addIndexColumn()
    //          ->addColumn('select_all', function ($detail) {
    //             return '<input type="checkbox" name="id_produktivitas[]" value="' . $detail->id_produktivitas . '">';
    //         })
    //          ->addColumn('id_kecamatan', function ($detail) {
    //              return '<option value"' . $detail->mst_kecamatan->nama_kecamatan . '">';
    //          })
    //          ->addColumn('id_desa', function ($detail) {
    //              return '<option value"' . $detail->mst_desa->nama_desa . '">';
    //          })
    //          ->addColumn('id_tanaman', function ($detail) {
    //              return '<option value"' . $detail->mst_tanaman->nama_tanaman . '">';
    //          })
    //          ->addColumn('lh_habis', function ($detail) {
    //              return ($detail->lh_habis) . ' ha';
    //          })
    //          ->addColumn('lh_blm_habis', function ($detail) {
    //              return ($detail->lh_blm_habis) . ' ha';
    //          })
    //          ->addColumn('kadar', function ($detail) {
    //              return ($detail->kadar) . ' %';
    //          })
    //          ->addColumn('habis', function ($detail) {
    //              return ($detail->habis) . ' ton';
    //          })
    //          ->addColumn('blm_habis', function ($detail) {
    //              return ($detail->blm_habis) . ' ton';
    //          })
    //          ->addColumn('provitas', function ($detail) {
    //              return ($detail->provitas) . ' ku/ha';
    //          })
    //          ->addColumn('harga', function ($detail) {
    //              return 'Rp. '. ($detail->harga);
    //          })
    //          ->addColumn('created_by', function ($detail) {
    //              return ($detail->user->nama);
    //          })
    //          ->addColumn('updated_by', function ($detail) {
    //             return ($detail->user->nama);
    //         })
    //          ->addColumn('created_at', function($detail) {
    //             return \Carbon\Carbon::parse($detail->updated_at)->format('d-m-Y');
    //         })
    //          ->addColumn('updated_at', function($detail) {
    //              return \Carbon\Carbon::parse($detail->updated_at)->format('d-m-Y');
    //         })
    //          ->make(true);
    // }

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
            // 'kecamatan_id' => $request->id_kecamatan,
            // 'desa_id' => $request->id_desa,
            'tanaman_id' => $request->id_tanaman,
            'lh_habis' => $request->lh_habis,
            'lh_blm_habis' => $request->lh_blm_habis,
            'kadar' => $request->kadar,
            'habis' => $request->habis,
            'blm_habis' => $request->blm_habis,
            'provitas' => $request->provitas,
            'harga' => $request->harga,
            'updated_by' => auth()->user()->id_user,
            'updated_at'  => $request->tanggal
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

    public function pdf_panen_horti(Request $request)
    {
        $tanaman = Tanaman::where('jenis_panen', 2)->pluck('id_tanaman');
        if ($request->form_awal && $request->form_akhir) {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->get();
        }
        $total = DB::select(DB::raw("
        SELECT
            id_produktivitas,
            tb_produktivitas.updated_at AS updated_at,
            SUM(lh_habis) AS lh_habis,
            lh_blm_habis,
            ROUND(kadar , 2) AS kadar,
            habis,
            blm_habis,
            harga,
            nama_kecamatan,
            nama_desa,
            nama_tanaman,
            provitas,
            tb_user.nama,
            lh_habis,
            (
                SELECT ROUND(SUM(lh_habis) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) as total_lh_habis,(
                SELECT ROUND(SUM(lh_blm_habis) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) as total_lh_blm_habis,(
                SELECT ROUND(AVG(kadar) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) as avg_kadar,(
                SELECT ROUND(SUM(habis) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) AS total_habis,(
                SELECT ROUND(SUM(blm_habis) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) AS total_blm_habis,(
                SELECT ROUND(AVG(provitas) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) AS avg_provitas,(
                SELECT ROUND(AVG(harga) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 2
            ) AS avg_harga
        FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
        INNER JOIN mst_kecamatan ON id_kecamatan = kecamatan_id
        INNER JOIN mst_desa ON id_desa = desa_id
        INNER JOIN tb_user ON tb_user.id_user = created_by
        WHERE jenis_panen = 2
        AND tb_produktivitas.updated_at >= (now() -interval 5 year)
        GROUP BY id_produktivitas
    "));

        $pdf = Pdf::loadView('panen.pdf_panen_horti', compact('produktivitas','total'))->setPaper('a4', 'landscape');


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
