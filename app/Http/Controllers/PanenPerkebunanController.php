<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Produktivitas;
use App\Models\Tanaman;
use Illuminate\Http\Request;

class PanenPerkebunanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Panen Perkebunan';
        return view('panen/perkebunan', $data);
    }

    public function user_index()
    {
        $data['title'] = 'Panen Perkebunan';
        return view('user/panen/perkebunan', $data);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
