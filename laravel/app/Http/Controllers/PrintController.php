<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Note;

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
        // dump($arr);

        return response()->json($arr);
    }

    public function grup(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $grup_all = DB::table('CBSLAM.CBS_JADWAL_GROUP')
        -> whereBetween('TANGGAL',[$start_date, $end_date])
        -> get();

        $startTime = strtotime($start_date);
        $endTime = strtotime( $end_date );
        $index = 0;

        $arr = [];

        for ( $f = $startTime; $f <= $endTime; $f = $f + 86400 ) {
          $thisDate = date( 'Y-m-d', $f );
          // dump($thisDate);
          $arr[$index] = ['tanggal' => $thisDate,'grup' => []];

            for($i=0;$i < count( $grup_all ); $i++){
                if ($thisDate == $grup_all[$i]->tanggal) {

                    $grup_1 = $grup_all[$i]->kd_group;
                    $shift = $grup_all[$i]->shift;
                    $arr[$index]['grup'][] = [
                        'grup' => $grup_1,
                        'shift' =>  $shift
                    ];
                    // $arr[$index] = ['tanggal' => $thisDate,'start_time' =>  $start_time,'end_time' => $end_time] ;
                }
            }
            $index++;
        }

        // dump($arr);

         return response()->json($arr);

    }

    
    public function getvessel(Request $request)
    {
        set_time_limit(60000);
        $vessel = DB::table('CBSLAM.VESSEL_DETAILS_SIM_TMP')->where('PRINT_CODE', $request->code)->get();

        $dataIntern = [];
        $dataDomes = [];
        $dataCurah = [];

        foreach ($vessel as $key => $val) {
            if($val->ocean_interisland_fake == 'I') {
                $dataIntern[] = $val;
            } else if($val->ocean_interisland_fake == 'D') {
                $dataDomes[] = $val;
            } else if($val->ocean_interisland_fake == 'C') {
                $dataCurah[] = $val;
            }
        }

        $sql = "SELECT CODE,
              TEXT,
              X,
              Y,
              START_DATE,
              WIDTH,
              HEIGHT,
              OCEAN_INTERISLAND,
              0 IS_EDITED
         FROM (SELECT A.CODE,
                      A.TEXT,
                      A.X,
                      Y + (TRUNC (START_DATE) - TRUNC (TO_DATE('{$request->datenow}', 'YYYY-MM-DD HH24:MI'))) * 480 Y,
                      START_DATE,
                      A.WIDTH,
                      A.HEIGHT,
                      OCEAN_INTERISLAND
                 FROM cbslam.vessel_details_note A)
        WHERE Y >= 0 AND Y<=480*7 AND START_DATE>=TRUNC(TO_DATE('{$request->datenow}', 'YYYY-MM-DD HH24:MI'))";

        $note = DB::select($sql);
        // $note = Note::whereDate('START_DATE', '>=', date('Y-m-d'))->get();

        $note_d = [];
        $note_i = [];
        $note_c = [];

        foreach ($note as $key => $val) {
            if($val->ocean_interisland == 'D')
                $note_d[] = $val;
            else if($val->ocean_interisland == 'I')
                $note_i[] = $val;
            else if($val->ocean_interisland == 'C')
                $note_c[] = $val;
        }

        $data = [
            'Intern' => $dataIntern,
            'Domes' => $dataDomes,
            'Curah' => $dataCurah,
            'note' => $note,
            'note_d' => $note_d,
            'note_i' => $note_i,
            'note_c' => $note_c,
        ];

        return response()->json($data);
    }


    public function print()
    {
        $data = [];
        
        if(isset($_GET['param'])) {
            $encoded = $_GET['param'];   // <-- encoded string from the request
            $decoded = "";
            for( $i = 0; $i < strlen($encoded); $i++ ) {
                $b = ord($encoded[$i]);
                $a = $b ^ 123;  // <-- must be same number used to encode the character
                $decoded .= chr($a);
            }
            
            $arrParam = explode('|', str_replace('[', 'P', $decoded));

            if(count($arrParam) == 4) {
                $data = [
                    'param11' => $arrParam[0],
                    'param22' => $arrParam[1],
                    'date'    => $arrParam[2],
                    'no_doc'  => $arrParam[3],
                ];
            }
        }

        return view('content.printpdf', compact('data'));
    }


    public function show()
    {
        $data = [];

        if(isset($_GET['params'])) {

            $params = safeDecrypt(str_replace(' ', '+', $_GET['params']), 'P3lindoBer1');

            $arrParam = explode('|', $params);

            if(count($arrParam) == 5) {
                $data = [
                    'param11' => $arrParam[0],
                    'param22' => $arrParam[1],
                    'datestart' => getDefaultDate($arrParam[2]),
                    'date'    => $arrParam[2],
                    'no_doc'  => $arrParam[3],
                    'code'    => $arrParam[4],
                    'is_required'=> true
                ];
            }
        }

        // echo json_encode($data);
        // die();

        return view('content.printpdf', compact('data'));
    }

    public function export()
    {
        $date_from  = $_GET['export_start'];
        $date_to    = $_GET['export_end'];
        $data = DB::table('CBSLAM.VIERV_EXPORT_MONTHLY')
        // ->where('ACT_DEP_TS', '>=', $_GET['export_start'])
        // ->where('ACT_DEP_TS', '<=', $_GET['export_end'])
        ->where(function($query) use ($date_from, $date_to){
             $query->orWhereBetween('ATD',array($date_from, $date_to))
             ->orWhereBetween('ATB',array($date_from, $date_to));
        })
        ->where('ET', '<>', '0')
        ->orderBy('ATB', 'ASC')
        ->get();

        $data_cuker = DB::table('CBSLAM.VIERV_EXPORT_MONTHLY')
        ->where(function($query) use ($date_from, $date_to){
             $query->orWhereBetween('ATD',array($date_from, $date_to))
             ->orWhereBetween('ATB',array($date_from, $date_to));
        })
        ->where('VES_TYPE', 'GC')
        ->orderBy('ATB', 'ASC')
        ->get();

        foreach ($data_cuker as $key => $val) {
            $data[] = $val;
        }

        return view('content.print.export', [
            "data"      => $data,
            "start_date"=> $_GET['export_start'],
            "end_date"  => $_GET['export_end'],
        ]);
    }

}
