<?php

namespace App\Http\Controllers;

use App\Exports\HortiExport;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Produktivitas;
use App\Models\Tanaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PanenController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Pajale
    public function pajale_index()
    {
        $data['title'] = 'Panen Pajale';
        return view('panen/pajale', $data);
    }

    // ============================== All Config Horti ==================================
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Horti Index
    public function horti_index()
    {
        $data['title'] = 'Panen Horti';
        $data['kecamatans'] = Kecamatan::all();
        $data['desas'] = Desa::all();
        $data['tanamans'] = Tanaman::all();
        return view('panen/horti', $data);
    }

    // Horti Data
    public function horti_data()
    {
        // $produktivitas = Produktivitas::with('mst_kecamatan', 'mst_desa', 'mst_tanaman')->orderBy('id_produktivitas', 'desc')->get();
        // cari tanaman yg jenis tanam sama panen horti
        $tanaman = Tanaman::where('jenis_tanam', 2)->where('jenis_panen', 2)->pluck('id_tanaman');
        // ambil data berdasrkan tanaman id dalam array
        $produktivitas = Produktivitas::with('user', 'mst_kecamatan', 'mst_desa', 'mst_tanaman')->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas', 'desc')->get();

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
                return $produktivitas->luas_lahan ?? '0';
            })
            ->addColumn('kadar', function ($produktivitas) {
                return $produktivitas->kadar ?? '0';
            })
            // ->addColumn('produksi', function ($produktivitas) {
            //     return $produktivitas->produksi ?? '0';
            // })
            ->addColumn('provitas', function ($produktivitas) {
                return $produktivitas->provitas ?? '0';
            })
            ->addColumn('harga', function ($produktivitas) {
                return "Rp. ". number_format($produktivitas->harga) ?? '0';
            })
            ->addColumn('created_by', function($produktivitas) {
                return $produktivitas->user->nama ?? '-';
            })
            ->addColumn('created_at', function($produktivitas) {
                return \Carbon\Carbon::parse($produktivitas->created_at)->format('d-m-Y');
            })
            ->addColumn('aksi', function ($produktivitas) {
                return '
                <button type="button" onclick="editForm('. $produktivitas->id_produktivitas . ');" class="btn btn-info"><i class="fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`' . route('panen.delete_horti', ['id' => $produktivitas->id_produktivitas]) . '`)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
            ';
            return "ok";
            })
            ->rawColumns(['aksi', 'select_all'])
            ->make(true);
    }

    // Horti Store
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function horti_store(Request $request)
    {
        // $produktivitas = Produktivitas::latest()->first() ?? new Produktivitas();
        // $kecamatan = Kecamatan::latest()->first() ?? new Kecamatan();
        // $desa = Desa::latest()->first() ?? new Desa();
        // $tanaman = Tanaman::latest()->first() ?? new Tanaman();

        // // new
        // $id_produktivitas = (int)$produktivitas->id_produktivitas + 1;
        // $produktivitas = Produktivitas::create([
        //     'id_produktivitas' => $id_produktivitas,
        // ]);

        // $nama_kecamatan = (int)$kecamatan->nama_kecamatan + 1;
        // $kecamatan = Kecamatan::select([
        //     'id_kecamatan' => $kecamatan,
        //     'nama_kecamatan' => $nama_kecamatan,
        // ]);

        // $nama_desa = (int)$desa->nama_desa + 1;
        // $kecamatan = Desa::select([
        //     'id_desa' => $desa,
        //     'id_kecamatan' => $request->kecamatan->id_kecamatan,
        //     'nama_desa' => $nama_desa,
        // ]);

        // $nama_tanaman = (int)$kecamatan->nama_tanaman + 1;
        // $tanaman = Tanaman::select([
        //     'id_tanaman' => $tanaman,
        //     'nama_tanaman' => $nama_tanaman,
        // ]);

        // $luas_lahan = (int)$produktivitas->luas_lahan;
        // $produktivitas = Produktivitas::create([
        //     'id_produktivitas' => $produktivitas,
        //     'luas_lahan' => $luas_lahan,
        // ]);

        // $kadar = (int)$produktivitas->kadar;
        // $produktivitas = Produktivitas::create([
        //     'id_produktivitas' => $produktivitas,
        //     'kadar' => $kadar,
        // ]);

        // $produksi = (int)$produktivitas->produksi;
        // $produktivitas = Produktivitas::create([
        //     'id_produktivitas' => $produktivitas,
        //     'produksi' => $produksi,
        // ]);

        // $provitas = (int)$produktivitas->provitas;
        // $produktivitas = Produktivitas::create([
        //     'id_produktivitas' => $produktivitas,
        //     'provitas' => $provitas,
        // ]);

        // $harga = (int)$produktivitas->harga;
        // $produktivitas = Produktivitas::create([
        //     'id_produktivitas' => $produktivitas,
        //     'harga' => $harga,
        // ]);

        // Produktivitas::create([
        //     'id_produktivitas' => $produktivitas->id_produktivitas,
        //     'id_kecamatan' => $kecamatan->id_produktivitas,
        //     'id_desa' => $desa->id_produktivitas,
        //     'id_tanaman' => $tanaman->id_produktivitas,
        // ]);

        Produktivitas::create([
            'kecamatan_id' => $request->id_kecamatan,
            'desa_id' => $request->id_desa,
            'tanaman_id' => $request->id_tanaman,
            'kadar' => $request->kadar,
            'provitas' => $request->provitas,
            'harga' => $request->harga,
            'luas_lahan' => $request->luas_lahan,
            'created_by' => 1
        ]);

        return response()->json('Data berhasil simpan', 200);
    }

    public function edit_horti(Request $request)
    {
        $produktivitas = Produktivitas::where('id_produktivitas', $request->id_produktivitas)->first();
        return response()->json($produktivitas);
    }

    public function update_horti(Request $request, $id_produktivitas)
    {
        Produktivitas::where('id_produktivitas', $id_produktivitas)->update([
            'kecamatan_id' => $request->id_kecamatan,
            'desa_id' => $request->id_desa,
            'tanaman_id' => $request->id_tanaman,
            'kadar' => $request->kadar,
            'provitas' => $request->provitas,
            'harga' => $request->harga,
            'luas_lahan' => $request->luas_lahan,
            'created_by' => 1
        ]);

        return response()->json('Data berhasil update', 200);
    }

    public function delete_horti(Request $request, $id_produktivitas)
    {
        Produktivitas::where('id_produktivitas', $id_produktivitas)->delete();
        return response()->json('Data berhasil hapus', 200);
    }

    public function pdf_horti(Request $request)
    {
        $tanaman = Tanaman::where('jenis_tanam', 2)->where('jenis_panen', 2)->pluck('id_tanaman');
        if($request->form_awal && $request->form_akhir) {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->whereBetween('created_at', [$request->form_awal, $request->form_akhir])->get();
        } else {
            $produktivitas = Produktivitas::whereIn('tanaman_id', $tanaman)->get();
        }

        $pdf = Pdf::loadView('panen.pdf_horti', compact('produktivitas'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function excel_horti(Request $request)
    {
        return (new HortiExport)->setDari($request->form_awal)->setSampai($request->form_akhir)->download('panen_horti.xlsx');
    }


    // Horti DeletetSelected
    public function horti_deleteSelected(Request $request)
    {
        foreach ($request->id_produktivitas as $id) {
            $delSelected = Produktivitas::find($id);

            Produktivitas::where('id_produktivitas', $delSelected->id_produktivitas)->delete();
            Kecamatan::where('id_kecamatan', $delSelected->kecamatan_id)->delete();
            Desa::where('id_desa', $delSelected->desa_id)->delete();
            Tanaman::where('id_tanaman', $delSelected->tanaman_id)->delete();
        }
    }

    // ============================== End Config Horti ==================================

    // Perkebunan
   public function perkebunan_index()
   {
       $data['title'] = 'Panen Perkebunan';
       return view('panen/perkebunan', $data);
   }

    // For Front END
    public function user_pajale_index()
    {
        $data['title'] = 'Panen Pajale';
        return view('user/panen/pajale', $data);
    }

    // Horti
    public function user_horti_index()
    {
        $data['title'] = 'Panen Horti';
        return view('user/panen/horti', $data);
    }

    // Perkebunan
    public function user_perkebunan_index()
    {
        $data['title'] = 'Panen Perkebunan';
        return view('user/panen/perkebunan', $data);
    }
}
