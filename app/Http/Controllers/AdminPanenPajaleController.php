<?php

namespace App\Http\Controllers;

use App\Exports\PajaleAdminExport;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Produktivitas;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminPanenPajaleController extends Controller
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

        $data['title'] = 'Panen Pajale';
        $data['kecamatans'] = Kecamatan::all();
        $data['desas'] = Desa::all();
        $data['tanamans'] = Tanaman::where('jenis_panen', 1)->get();
        $data['is_kecamatan'] = Auth::user()->kecamatan_id ?? "";
        return view('admin/panen/admin_panen_pajale', $data, compact('tanggalAwal', 'tanggalAkhir'));
    }
    public function data(Request $request)
    {
        // cari tamaman yang jenis tanam sama panen Pajale
        $tanaman = Tanaman::where('jenis_panen', 1)->pluck('id_tanaman');
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
                return "Rp. " .($produktivitas->harga);
            })
            ->addColumn('created_by', function ($produktivitas) {
                return $produktivitas->user->nama ?? '-';
            })
            ->addColumn('updated_at', function ($produktivitas) {
                return \Carbon\Carbon::parse($produktivitas->updated_at)->format('d-m-Y');
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

    public function pdf_panen_pajale(Request $request)
    {
        $tanaman = Tanaman::where('jenis_panen', 1)->pluck('id_tanaman');
        $user = auth()->user()->id_user;
        if ($request->form_awal && $request->form_akhir) {
            $produktivitas = Produktivitas::where('created_by', $user)->whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas = Produktivitas::where('created_by', $user)->whereIn('tanaman_id', $tanaman)->get();
        }
        $total = DB::select(DB::raw("
        SELECT
            tb_user.id_user AS id_user,
            id_produktivitas,
            tb_produktivitas.updated_at AS updated_at,
            SUM(luas_lahan) AS luas_lahan,
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
                SELECT ROUND(SUM(luas_lahan) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 1 AND created_by = id_user
            ) as total_luas_lahan,(
                SELECT ROUND(AVG(kadar) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 1 AND created_by = id_user
            ) as avg_kadar,(
                SELECT ROUND(SUM(produksi) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 1 AND created_by = id_user
            ) AS total_produksi,(
                SELECT ROUND(AVG(provitas) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 1 AND created_by = id_user
            ) AS avg_provitas,(
                SELECT ROUND(AVG(harga) , 2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_panen = 1 AND created_by = id_user
            ) AS avg_harga
        FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
        INNER JOIN mst_kecamatan ON id_kecamatan = kecamatan_id
        INNER JOIN mst_desa ON id_desa = desa_id
        INNER JOIN tb_user ON tb_user.id_user = created_by
        WHERE jenis_panen = 1
        AND tb_produktivitas.updated_at >= (now() -interval 5 year) AND created_by = $user
        GROUP BY id_produktivitas
    "));


        $pdf = Pdf::loadView('admin.panen.pdf_panen_pajale', compact('produktivitas','total'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function excel_pajale(Request $request)
    {
        return (new PajaleAdminExport)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('panen_pajale.xlsx');
    }
}
