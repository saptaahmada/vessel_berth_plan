<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PrintController extends Controller
{
    public function blokirkade()
    {
        $blokir_intern = DB::table('CBSLAM.VBP_GEN_REF')
        -> where('param1','BLOKIR_KADE')
        -> where('param2','I')
        -> get();
        $blokir_domes = DB::table('CBSLAM.VBP_GEN_REF')
        -> where('param1','BLOKIR_KADE')
        -> where('param2','D')
        -> get();
        $blokir_curah = DB::table('CBSLAM.VBP_GEN_REF')
        -> where('param1','BLOKIR_KADE')
        -> where('param2','C')
        -> get();
        $panjang_curah = DB::table('CBSLAM.VBP_GEN_REF')
        -> where('param1','DERMAGA')
        -> where('param2','C')
        -> get();

        $blokir_data = [
            'blokir_intern' => $blokir_intern,
            'blokir_domes' => $blokir_domes,
            'blokir_curah' => $blokir_curah,
            'panjang_curah' => $panjang_curah,
        ];
        return response()->json($blokir_data);
    }
}
