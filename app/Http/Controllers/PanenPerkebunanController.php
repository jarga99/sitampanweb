<?php

namespace App\Http\Controllers;

use App\Exports\PerkebunanExport;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Produktivitas;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanenPerkebunanController extends Controller
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

        $data['title'] = 'Panen Perkebunan';
        $data['kecamatans'] = Kecamatan::all();
        $data['desas'] = Desa::all();
        $data['tanamans'] = Tanaman::where('jenis_panen', 3)->get();
        return view('panen/panen_perkebunan', $data, compact('tanggalAwal', 'tanggalAkhir'));
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
        // cari tamaman yang jenis tanam sama panen perkebunan
        $tanaman = Tanaman::where('jenis_panen', 3)->pluck('id_tanaman');
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
            ->addColumn('tm', function ($produktivitas) {
                return ($produktivitas->tm). ' ha' ;
            })
            ->addColumn('tbm', function ($produktivitas) {
                return ($produktivitas->tbm). ' ha' ;
            })
            ->addColumn('ttm', function ($produktivitas) {
                return ($produktivitas->ttm). ' ha' ;
            })
            ->addColumn('luas_lahan', function ($produktivitas) {
                return ($produktivitas->luas_lahan).' ha';
            })
            ->addColumn('kadar', function ($produktivitas) {
                return ($produktivitas->kadar). ' %';
            })
            ->addColumn('produksi', function ($produktivitas) {
                return ($produktivitas->produksi). ' ton';
            })
            ->addColumn('provitas', function ($produktivitas) {
                return ($produktivitas->provitas). ' ton';
            })
            ->addColumn('harga', function ($produktivitas) {
                return 'Rp. '.($produktivitas->harga);
            })
            ->addColumn('created_by', function ($produktivitas) {
                return ($produktivitas->user->nama);
            })
            ->addColumn('updated_at', function($produktivitas) {
                return \Carbon\Carbon::parse($produktivitas->updated_at)->format('d-m-Y');
            })
            ->addColumn('aksi', function ($produktivitas) {
                return '
                <div class="btn-group">
                <button type="button" onclick="editForm('. $produktivitas->id_produktivitas . ');" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`' . route('panen.delete_perkebunan', ['id' => $produktivitas->id_produktivitas]) . '`)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
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
            'tm' => $request->tm,
            'tbm' => $request->tbm,
            'ttm' => $request->ttm,
            'luas_lahan' => $request->luas_lahan,
            'kadar' => $request->kadar,
            'provitas' => $request->provitas,
            'produksi' => $request->luas_lahan * $request->provitas,
            'harga' => $request->harga,
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
            'tm' => $request->tm,
            'tbm' => $request->tbm,
            'ttm' => $request->ttm,
            'luas_lahan' => $request->luas_lahan,
            'kadar' => $request->kadar,
            'provitas' => $request->provitas,
            'produksi' => $request->luas_lahan * $request->provitas,
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
    public function pdf_panen_perkebunan(Request $request)
    {
        $tanaman = Tanaman::where('jenis_panen', 3)->pluck('id_tanaman');
        if($request->form_awal && $request->form_akhir) {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->get();
        }
        $total = DB::select(DB::raw("
        SELECT
            id_produktivitas,
            tb_produktivitas.updated_at AS updated_at,
            SUM(tm) AS tm,
            tbm,
            ttm,
            ROUND(kadar , 2) AS kadar,
            produksi,
            harga,
            nama_kecamatan,
            nama_desa,
            nama_tanaman,
            provitas,
            tb_user.nama,
            luas_lahan,
            (
                SELECT SUM(tm) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 3
            ) as total_tm,(
                SELECT SUM(tbm) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 3
            ) as total_tbm,(
                SELECT SUM(ttm) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 3
            ) as total_ttm,(
                SELECT SUM(luas_lahan) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 3
            ) as total_luas_lahan,(
                SELECT ROUND(AVG(kadar) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 3
            ) as avg_kadar,(
                SELECT SUM(produksi) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 3
            ) AS total_produksi,(
                SELECT ROUND(AVG(provitas) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 3
            ) AS avg_provitas,(
                SELECT ROUND(AVG(harga) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 3
            ) AS avg_harga
        FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
        INNER JOIN mst_kecamatan ON id_kecamatan = kecamatan_id
        INNER JOIN mst_desa ON id_desa = desa_id
        INNER JOIN tb_user ON tb_user.id_user = created_by
        WHERE jenis_panen = 3
        AND tb_produktivitas.updated_at >= (now() -interval 5 year)
        GROUP BY id_produktivitas
    "));


        $pdf = Pdf::loadView('panen.pdf_panen_perkebunan', compact('produktivitas','total'))->setPaper('a4', 'landscape');


        return $pdf->stream();
    }

    public function excel_perkebunan(Request $request)
    {
        return (new PerkebunanExport)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('panen_perkebunan.xlsx');
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
