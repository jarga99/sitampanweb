<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TanamController extends Controller
{
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
}
