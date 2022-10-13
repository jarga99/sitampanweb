<?php

namespace App\Http\Controllers;

use App\Exports\_PajaleAdminExport;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\ProduktivitasPuso;
use App\Models\Tanaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminPusoPajaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $data['tanamans'] = Tanaman::where('jenis_puso', 1)->get();
        $data['is_kecamatan'] = Auth::user()->kecamatan_id ?? "";
        return view('admin/puso/admin_puso_pajale', $data, compact('tanggalAwal', 'tanggalAkhir'));
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
        // cari tamaman yang jenis tanam sama puso pajale
        $tanaman = Tanaman::where('jenis_puso', 1)->pluck('id_tanaman');
        $user =  auth()->user()->id_user;
        // ambil data berdasarkan tanaman id dalam array
        $produktivitas_puso = ProduktivitasPuso::with('user','mst_kecamatan', 'mst_desa', 'mst_tanaman')->where('created_by', $user)->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas_puso', 'desc');
        if($request->tanggal_awal != null && $request->tanggal_akhir != null) {
            $produktivitas_puso = $produktivitas_puso->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        // $produktivitas_puso = $produktivitas_puso->get();
        return datatables()
            ->of($produktivitas_puso)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produktivitas_puso) {
                return '<input type="checkbox" name="id_produktivitas_puso[]" value="' . $produktivitas_puso->id_produktivitas_puso . '">';
            })
            ->addColumn('id_kecamatan', function ($produktivitas_puso) {
                return '<option value"' . $produktivitas_puso->mst_kecamatan->nama_kecamatan . '">';
            })
            ->addColumn('id_desa', function ($produktivitas_puso) {
                return '<option value"' . $produktivitas_puso->mst_desa->nama_desa . '">';
            })
            ->addColumn('id_tanaman', function ($produktivitas_puso) {
                return '<option value"' . $produktivitas_puso->mst_tanaman->nama_tanaman . '">';
            })
            ->addColumn('luas_lahan', function ($produktivitas_puso) {
                return ($produktivitas_puso->luas_lahan) . ' ha';
            })
            ->addColumn('kadar', function ($produktivitas_puso) {
                return ($produktivitas_puso->kadar). ' %';
            })
            ->addColumn('produksi', function ($produktivitas_puso) {
                return ($produktivitas_puso->produksi). ' ton';
            })
            ->addColumn('provitas', function ($produktivitas_puso) {
                return ($produktivitas_puso->provitas). ' ku/ha';
            })
            ->addColumn('harga', function ($produktivitas_puso) {
                return 'Rp. '.($produktivitas_puso->harga);
            })
            ->addColumn('created_by', function ($produktivitas_puso) {
                return ($produktivitas_puso->user->nama);
            })
            ->addColumn('updated_at', function($produktivitas_puso) {
                return \Carbon\Carbon::parse($produktivitas_puso->updated_at)->format('d-m-Y');
            })
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
        ProduktivitasPuso::create([
            'kecamatan_id' => $request->id_kecamatan,
            'desa_id' => $request->id_desa,
            'tanaman_id' => $request->id_tanaman,
            // 'sub_tanaman_id' =>$request->id_sub_tanaman,
            'kadar' => $request->kadar,
            'produksi' => $request->produksi,
            // 'sub_produksi_id' =>$request->id_sub_produksi,
            'provitas' => $request->provitas,
            'harga' => $request->harga,
            'luas_lahan' => $request->luas_lahan,
            'created_by' => auth()->user()->id_user,
           ]);
           return response()->json('Data berhasil disimpan', 200);
    }

    public function pdf_puso_pajale(Request $request)
    {
        $user =  auth()->user()->id_user;
        $tanaman = Tanaman::where('jenis_puso', 1)->pluck('id_tanaman');
        if($request->form_awal && $request->form_akhir) {
            $produktivitas_puso = ProduktivitasPuso::whereIn('tanaman_id', $tanaman)->where('created_by',$user)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas_puso = ProduktivitasPuso::whereIn('tanaman_id', $tanaman)->where('created_by',$user)->get();
        }
        $total = DB::select(DB::raw("
        SELECT
            tb_user.id_user AS id_user,
            id_produktivitas_puso,
            tb_produktivitas_puso.updated_at AS updated_at,
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
                SELECT ROUND(SUM(luas_lahan) , 2) FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_puso = 1 AND created_by = id_user
            ) as total_luas_lahan,(
                SELECT ROUND(AVG(kadar) , 2) FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_puso = 1 AND created_by = id_user
            ) as avg_kadar,(
                SELECT ROUND(SUM(produksi) , 2) FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_puso = 1 AND created_by = id_user
            ) AS total_produksi,(
                SELECT ROUND(AVG(provitas) , 2) FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_puso = 1 AND created_by = id_user
            ) AS avg_provitas,(
                SELECT ROUND(AVG(harga) , 2) FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
                WHERE jenis_puso = 1 AND created_by = id_user
            ) AS avg_harga
        FROM tb_produktivitas_puso INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
        INNER JOIN mst_kecamatan ON id_kecamatan = kecamatan_id
        INNER JOIN mst_desa ON id_desa = desa_id
        INNER JOIN tb_user ON tb_user.id_user = created_by
        WHERE jenis_puso = 1
        AND tb_produktivitas_puso.updated_at >= (now() -interval 5 year) AND created_by = $user
        GROUP BY id_produktivitas_puso
    "));

        $pdf = Pdf::loadView('admin.puso.pdf_puso_pajale', compact('produktivitas_puso','total'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function excel_pajale(Request $request)
    {
        return (new _PajaleAdminExport)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('puso_pajale.xlsx');
    }


}
