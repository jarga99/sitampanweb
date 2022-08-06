<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function getDesa(Request $request)
    {
        $desa = Desa::where('kecamatan_id', $request->id_kecamatan)->get();

        return response()->json($desa);
    }
}
