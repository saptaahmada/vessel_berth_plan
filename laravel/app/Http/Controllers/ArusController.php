<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Arus;
use DataTables;

class ArusController extends Controller
{
    public function index()
    {
        // $dermaga = DB::table('CBSLAM.VBP_GEN_REF')
        // ->where('PARAM1', 'DERMAGA')
        // ->get();
        return view('content.arus.arus');
    }

    public function json(){
        return DataTables::of(Arus::all())->make(true);
    }

    public function getAll(Request $request)
    {
        echo json_encode(DB::table('CBSLAM.CBS_MASTER_ARUS')->whereDate('START_DATE', '>=', date('Y-m-d 00:00:00'))->get());
    }

    public function add(Request $request)
    {
        $start = $request->start_date;
        $end   = $request->end_date;

        // dump(count($start));
        for ($s=0 ; $s < count($start); $s++){
            $data_arus = [
                'start_date'    => $start[$s],
                'end_date'      => $end[$s]
            ];

            $result = DB::table('CBSLAM.MASTER_ARUS')->insert($data_arus);
           
                // dump($data_arus);
        }
        return [
            'success'	=> $result,
            'message'	=> ($result?'Success':'Gagal')
        ];

        
    }

   

    public function remove(Request $request)
    {
        $result = DB::table('CBSLAM.MASTER_ARUS')
        ->where('ARUS_ID', $request->arus_id)
        ->delete();
        return [
        	'success'	=> $result,
        	'message'	=> ($result?'Success':'Gagal')
        ];
    }

}
