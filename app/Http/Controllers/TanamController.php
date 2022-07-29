<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TanamController extends Controller
{
    // For Back END
    // Pajale
    public function pajale_index(){
        $data['title'] = 'Tanam Pajale';
        return view('tanam/pajale',$data);
    }

    // Horti
    public function horti_index(){
        $data['title'] = 'Tanam Horti';
        return view('tanam/horti',$data);
    }

    // Perkebunan
    public function perkebunan_index(){
        $data['title'] = 'Tanam Perkebunan';
        return view('tanam/perkebunan',$data);
    }

    // For Front END
    public function user_pajale_index(){
        $data['title'] = 'Tanam Pajale';
        return view('user/tanam/pajale',$data);
    }

    // Horti
    public function user_horti_index(){
        $data['title'] = 'Tanam Horti';
        return view('user/tanam/horti',$data);
    }

    // Perkebunan
    public function user_perkebunan_index(){
        $data['title'] = 'Tanam Perkebunan';
        return view('user/tanam/perkebunan',$data);
    }

}
