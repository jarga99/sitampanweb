<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TanamController extends Controller
{
    public function index(){
        $data['title'] = 'Tanam Pajale';
        return view('tanam/pajale',$data);
    }
}
