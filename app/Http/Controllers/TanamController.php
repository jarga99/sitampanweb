<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TanamController extends Controller
{
    public function index_pajale(){
        return view('tanam.index_pajale');
    }
}
