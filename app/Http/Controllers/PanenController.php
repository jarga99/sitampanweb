<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanenController extends Controller
{
    // Pajale
    public function pajale_index()
    {
        $data['title'] = 'Panen Pajale';
        return view('panen/pajale', $data);
    }

    // Horti
    public function horti_index()
    {
        $data['title'] = 'Panen Horti';
        return view('panen/horti', $data);
    }

    // Perkebunan
    public function perkebunan_index()
    {
        $data['title'] = 'Panen Perkebunan';
        return view('panen/perkebunan', $data);
    }
}
