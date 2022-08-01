<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->level == 1)
        {
            return view('dashboard.counter');
        }
        elseif (auth()->user()->level == 2)
        {
            return view('dashboard.counter');
        }
    }
}
