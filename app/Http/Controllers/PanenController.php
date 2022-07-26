<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Produktivitas;
use App\Models\Tanaman;
use Illuminate\Http\Request;

class PanenController extends Controller
{
    // Pajale
    public function pajale_index()
    {
        $data['title'] = 'Panen Pajale';
        return view('panen/pajale', $data);
    }

    // ============================== All Config Horti ==================================

    // Horti Index
    public function horti_index()
    {
        $data['title'] = 'Panen Horti';
        return view('panen/horti', $data);
    }

    // Horti Data
    public function horti_data()
    {
        $produktivitas = Produktivitas::with('mst_kecamatan', 'mst_desa', 'mst_tanaman')->orderBy('id_produktivitas','desc')->get();
        return datatables()
        ->of($produktivitas)
        ->addIndexColumn()
        ->addColumn('select_all', function($produktivitas){
            return '<input type="checkbox" name="id_produktivitas[]" value="'. $produktivitas->id_produktivitas .'">';
        })
        ->addColumn('id_kecamatan', function($produktivitas){
            return ($produktivitas->mst_kecamatan->nama_kecamtan) ;
        })
        ->addColumn('id_desa', function ($produktivitas){
            return ($produktivitas->mst_desa->nama_desa);
        })
        ->addColumn('id_tanaman', function($produktivitas){
            return ($produktivitas->mst_tanaman->nama_tanaman);
        })
        ->addColumn('luas_lahan', function($produktivitas){
            return ($produktivitas->tb_produktivitas->luas_lahan);
        })
        ->addColumn('kadar', function($produktivitas){
            return ($produktivitas->tb_produktivitas->kadar);
        })
        ->addColumn('produksi', function($produktivitas){
            return ($produktivitas->tb_produktivitas->produksi);
        })
        ->addColumn('provitas', function($produktivitas){
            return ($produktivitas->tb_produktivitas->provitas);
        })
        ->addColumn('harga', function($produktivitas){
            return ($produktivitas->tb_produktivitas->harga);
        })
        ->addColumn('aksi', function ($produktivitas) {
            return '
                <button type="button" onclick="editForm(`' . route('horti.update', $produktivitas->id) . '`)" class="btn btn-info"><i class="fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`' . route('horti.destroy', $produktivitas->id) . '`)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
            ';
        })
        ->rawColumns(['aksi', 'select_all'])
            ->make(true);
    }

    // Horti Store
    public function horti_store(Request $request){
        $produktivitas = Produktivitas::latest()->first() ?? new Produktivitas();
        $kecamatan = Kecamatan::latest()->first() ?? new Kecamatan();
        $desa = Desa::latest()->first() ?? new Desa();
        $tanaman = Tanaman::latest()->first() ?? new Tanaman();

        // new
        $id_produktivitas = (int)$produktivitas->id_produktivitas + 1;
        $produktivitas = Produktivitas::create([
            'id_produktivitas' => $id_produktivitas,
        ]);

        $nama_kecamatan = (int)$kecamatan->nama_kecamatan + 1;
        $kecamatan = Kecamatan::select([
            'id_kecamatan' => $kecamatan,
            'nama_kecamatan' => $nama_kecamatan,
        ]);

        $nama_desa = (int)$desa->nama_desa + 1;
        $kecamatan = Desa::select([
            'id_desa' => $desa,
            'id_kecamatan' => $request->kecamatan->id_kecamatan,
            'nama_desa' => $nama_desa,
        ]);

        $nama_tanaman = (int)$kecamatan->nama_tanaman + 1;
        $tanaman = Tanaman::select([
            'id_tanaman' => $tanaman,
            'nama_tanaman' => $nama_tanaman,
        ]);

        $luas_lahan = (int)$produktivitas->luas_lahan;
        $produktivitas = Produktivitas::create([
            'id_produktivitas' => $produktivitas,
            'luas_lahan' => $luas_lahan,
        ]);

        $kadar = (int)$produktivitas->kadar;
        $produktivitas = Produktivitas::create([
            'id_produktivitas' => $produktivitas,
            'kadar' => $kadar,
        ]);

        $produksi = (int)$produktivitas->produksi;
        $produktivitas = Produktivitas::create([
            'id_produktivitas' => $produktivitas,
            'produksi' => $produksi,
        ]);

        $provitas = (int)$produktivitas->provitas;
        $produktivitas = Produktivitas::create([
            'id_produktivitas' => $produktivitas,
            'provitas' => $provitas,
        ]);

        $harga = (int)$produktivitas->harga;
        $produktivitas = Produktivitas::create([
            'id_produktivitas' => $produktivitas,
            'harga' => $harga,
        ]);

        Produktivitas::create([
            'id_produktivitas' => $produktivitas->id_produktivitas,
            'id_kecamatan' => $kecamatan->id_produktivitas,
            'id_desa' => $desa->id_produktivitas,
            'id_tanaman' => $tanaman->id_produktivitas,
        ]);

        return response()->json('Data berhasil simpan', 200);

    }


    // Horti DeletetSelected
    public function horti_deleteSelected(Request $request){
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
}
