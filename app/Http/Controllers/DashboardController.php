<?php

namespace App\Http\Controllers;

use App\Models\Produktivitas;
use App\Models\ProduktivitasPuso;
use App\Models\ProduktivitasTanam;
use App\Models\Tanaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $created_at = date('Y-m-d');
        $updated_at = date('Y-m-d');


        $count_data = array();

        while (strtotime($created_at)<= strtotime($updated_at)){
            $count_data[] = (int) substr($created_at,8,2);
            $user = auth()->user()->id_user;
            // pajale
            $tanam_pajale = Tanaman::where('jenis_tanam',1)->pluck('id_tanaman')->toArray();
            $count_tanam_pajale = ProduktivitasTanam::with('mst_tanaman')->whereIn('tanaman_id', $tanam_pajale)->orderBy('id_produktivitas_tanam', 'desc')->count();
            $count_admin_tanam_pajale = ProduktivitasTanam::with('mst_tanaman')->where('created_by',$user)->whereIn('tanaman_id', $tanam_pajale)->orderBy('id_produktivitas_tanam', 'desc')->count();
            $panen_pajale = Tanaman::where('jenis_panen',1)->pluck('id_tanaman')->toArray();
            $count_panen_pajale = Produktivitas::with('mst_tanaman')->whereIn('tanaman_id', $panen_pajale)->orderBy('id_produktivitas', 'desc')->count();
            $count_admin_panen_pajale = Produktivitas::with('mst_tanaman')->where('created_by',$user)->whereIn('tanaman_id', $panen_pajale)->orderBy('id_produktivitas', 'desc')->count();
            $puso_pajale = Tanaman::where('jenis_panen',1)->pluck('id_tanaman')->toArray();
            $count_puso_pajale = ProduktivitasPuso::with('mst_tanaman')->whereIn('tanaman_id', $puso_pajale)->orderBy('id_produktivitas_puso', 'desc')->count();
            $count_admin_puso_pajale = ProduktivitasPuso::with('mst_tanaman')->where('created_by',$user)->whereIn('tanaman_id', $puso_pajale)->orderBy('id_produktivitas_puso', 'desc')->count();

            // horti
            $tanam_horti = Tanaman::where('jenis_tanam',2)->pluck('id_tanaman')->toArray();
            $count_tanam_horti = ProduktivitasTanam::with('mst_tanaman')->whereIn('tanaman_id', $tanam_horti)->orderBy('id_produktivitas_tanam', 'desc')->count();
            $count_admin_tanam_horti = ProduktivitasTanam::with('mst_tanaman')->where('created_by',$user)->whereIn('tanaman_id', $tanam_horti)->orderBy('id_produktivitas_tanam', 'desc')->count();
            $panen_horti = Tanaman::where('jenis_panen',2)->pluck('id_tanaman')->toArray();
            $count_panen_horti = Produktivitas::with('mst_tanaman')->whereIn('tanaman_id', $panen_horti)->orderBy('id_produktivitas', 'desc')->count();
            $count_admin_panen_horti = Produktivitas::with('mst_tanaman')->where('created_by',$user)->whereIn('tanaman_id', $panen_horti)->orderBy('id_produktivitas', 'desc')->count();
            $puso_horti = Tanaman::where('jenis_panen',2)->pluck('id_tanaman')->toArray();
            $count_puso_horti = ProduktivitasPuso::with('mst_tanaman')->whereIn('tanaman_id', $puso_horti)->orderBy('id_produktivitas_puso', 'desc')->count();
            $count_admin_puso_horti = ProduktivitasPuso::with('mst_tanaman')->where('created_by',$user)->whereIn('tanaman_id', $puso_horti)->orderBy('id_produktivitas_puso', 'desc')->count();

            // perkebunan
            $tanam_perkebunan = Tanaman::where('jenis_tanam',3)->pluck('id_tanaman')->toArray();
            $count_tanam_perkebunan = ProduktivitasTanam::with('mst_tanaman')->whereIn('tanaman_id', $tanam_perkebunan)->orderBy('id_produktivitas_tanam', 'desc')->count();
            $count_admin_tanam_perkebunan = ProduktivitasTanam::with('mst_tanaman')->where('created_by',$user)->whereIn('tanaman_id', $tanam_perkebunan)->orderBy('id_produktivitas_tanam', 'desc')->count();
            $panen_perkebunan = Tanaman::where('jenis_panen',3)->pluck('id_tanaman')->toArray();
            $count_panen_perkebunan = Produktivitas::with('mst_tanaman')->whereIn('tanaman_id', $panen_perkebunan)->orderBy('id_produktivitas', 'desc')->count();
            $count_admin_panen_perkebunan = Produktivitas::with('mst_tanaman')->where('created_by',$user)->whereIn('tanaman_id', $panen_perkebunan)->orderBy('id_produktivitas', 'desc')->count();
            $puso_perkebunan = Tanaman::where('jenis_panen',3)->pluck('id_tanaman')->toArray();
            $count_puso_perkebunan = ProduktivitasPuso::with('mst_tanaman')->whereIn('tanaman_id', $puso_perkebunan)->orderBy('id_produktivitas_puso', 'desc')->count();
            $count_admin_puso_perkebunan = ProduktivitasPuso::with('mst_tanaman')->where('created_by',$user)->whereIn('tanaman_id', $puso_perkebunan)->orderBy('id_produktivitas_puso', 'desc')->count();

            // puso





            $created_at = date('Y-m-d', strtotime("+1 day", strtotime($created_at)));
        }

        if (auth()->user()->level == 1)
        {
            return view('dashboard.counter' ,
            compact(
                'created_at',
                'updated_at',
                'count_data',
                'tanam_pajale',
                'panen_pajale',
                'puso_pajale',
                'tanam_horti',
                'panen_horti',
                'puso_horti',
                'tanam_perkebunan',
                'panen_perkebunan',
                'puso_perkebunan',
                'count_tanam_pajale',
                'count_panen_pajale',
                'count_puso_pajale',
                'count_tanam_horti',
                'count_panen_horti',
                'count_puso_horti',
                'count_tanam_perkebunan',
                'count_panen_perkebunan',
                'count_puso_perkebunan'
            ));
        }

        elseif (auth()->user()->level == 2)
        {
            return view('dashboard.counter2',
            compact(
                'created_at',
                'updated_at',
                'count_data',
                'tanam_pajale',
                'panen_pajale',
                'puso_pajale',
                'tanam_horti',
                'panen_horti',
                'puso_horti',
                'tanam_perkebunan',
                'panen_perkebunan',
                'puso_perkebunan',
                'count_tanam_pajale',
                'count_panen_pajale',
                'count_puso_pajale',
                'count_tanam_horti',
                'count_panen_horti',
                'count_puso_horti',
                'count_tanam_perkebunan',
                'count_panen_perkebunan',
                'count_puso_perkebunan'
            ));
        }
        elseif (auth()->user()->level == 3)
        {
            return view('dashboard.counter3',
            compact(
                'created_at',
                'updated_at',
                'count_data',
                'tanam_pajale',
                'panen_pajale',
                'puso_pajale',
                'tanam_horti',
                'panen_horti',
                'puso_horti',
                'tanam_perkebunan',
                'panen_perkebunan',
                'puso_perkebunan',
                'count_admin_tanam_pajale',
                'count_admin_panen_pajale',
                'count_admin_puso_pajale',
                'count_admin_tanam_horti',
                'count_admin_panen_horti',
                'count_admin_puso_horti',
                'count_admin_tanam_perkebunan',
                'count_admin_panen_perkebunan',
                'count_admin_puso_perkebunan',
            ));
        }
    }
}
