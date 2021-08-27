<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

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

    public function arusminus(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $datearus = DB::table('CBSLAM.CBS_MASTER_ARUS')
        -> whereBetween('START_DATE',[$start_date, $end_date])
        -> get();

        $startTime = strtotime($start_date);
        $endTime = strtotime( $end_date );
        $index = 0;

        $arr = [];

        for ( $f = $startTime; $f <= $endTime; $f = $f + 86400 ) {
          $thisDate = date( 'Y-m-d', $f );
          $arr[$index] = ['tanggal' => $thisDate,'arus' => []];

            for($i=0;$i < count( $datearus ); $i++){
                if ($thisDate == $datearus[$i]->tanggal) {
                    $start_time = $datearus[$i]->start_time;
                    $end_time = $datearus[$i]->end_time;
                    $arr[$index]['arus'][] = [
                        'start_time' => $start_time,
                        'end_time' => $end_time
                    ];
                    // $arr[$index] = ['tanggal' => $thisDate,'start_time' =>  $start_time,'end_time' => $end_time] ;
                    
                }

              
            }
            $index++;
        }

        return response()->json($arr);

    }
}
