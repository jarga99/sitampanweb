<?php

namespace App\Http\Controllers;

use App\Models\Produktivitas;
use App\Models\Tanaman;
use Illuminate\Http\Request;

class DTPanenHortiController extends Controller
{
    public function detail( $id_produktivitas)
    {
        // cari tamaman yang jenis tanam sama panen horti
        $tanaman = Tanaman::where('jenis_panen', 2)->pluck('id_tanaman');
        $detail = Produktivitas::with('user','mst_kecamatan', 'mst_desa', 'mst_tanaman')
        ->whereIn('tanaman_id', $tanaman)->orderBy('id_produktivitas','desc', $id_produktivitas)->first();

         return datatables()
             ->of($detail)
             ->addIndexColumn()
             ->addColumn('select_all', function ($detail) {
                return '<input type="checkbox" name="id_produktivitas[]" value="' . $detail->id_produktivitas . '">';
            })
             ->addColumn('id_kecamatan', function ($detail) {
                 return '<option value"' . $detail->mst_kecamatan->nama_kecamatan . '">';
             })
             ->addColumn('id_desa', function ($detail) {
                 return '<option value"' . $detail->mst_desa->nama_desa . '">';
             })
             ->addColumn('id_tanaman', function ($detail) {
                 return '<option value"' . $detail->mst_tanaman->nama_tanaman . '">';
             })
             ->addColumn('lh_habis', function ($detail) {
                 return ($detail->lh_habis) . ' ha';
             })
             ->addColumn('lh_blm_habis', function ($detail) {
                 return ($detail->lh_blm_habis) . ' ha';
             })
             ->addColumn('kadar', function ($detail) {
                 return ($detail->kadar) . ' %';
             })
             ->addColumn('habis', function ($detail) {
                 return ($detail->habis) . ' ton';
             })
             ->addColumn('blm_habis', function ($detail) {
                 return ($detail->blm_habis) . ' ton';
             })
             ->addColumn('provitas', function ($detail) {
                 return ($detail->provitas) . ' ton';
             })
             ->addColumn('harga', function ($detail) {
                 return 'Rp. '. ($detail->harga);
             })
             ->addColumn('created_by', function ($detail) {
                 return ($detail->user->nama);
             })
             ->addColumn('updated_by', function ($detail) {
                return ($detail->user->nama);
            })
             ->addColumn('created_at', function($detail) {
                return \Carbon\Carbon::parse($detail->updated_at)->format('d-m-Y');
            })
             ->addColumn('updated_at', function($detail) {
                 return \Carbon\Carbon::parse($detail->updated_at)->format('d-m-Y');
            })
             ->make(true);
    }
}
