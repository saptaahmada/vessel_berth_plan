<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\MHoliday;
use DataTables;

class MHolidayController extends Controller
{
    public function index()
    {
        return view('content.m_holiday.view');
    }

    public function json(){
        return DataTables::of(MHoliday::all())->make(true);
    }

    public function getAll(Request $request)
    {
        echo json_encode(DB::table('CBSLAM.VIERV_M_HOLIDAY')->whereDate('START_DATE', '>=', date('Y-m-d 00:00:00'))->get());
    }

    public function add(Request $request)
    {
        $start = $request->start_date;
        $end   = $request->end_date;

        for ($s=0 ; $s < count($start); $s++){
            $data_m_holiday = [
                'start_date'    => getDefaultDate($start[$s]),
                'end_date'      => getDefaultDate($end[$s])
            ];

            $result = DB::table('CBSLAM.VIER_M_HOLIDAY')->insert($data_m_holiday);
        }
        return [
            'success'	=> $result,
            'message'	=> ($result?'Success':'Failed')
        ];
    }

    public function remove(Request $request)
    {
        $result = DB::table('CBSLAM.VIER_M_HOLIDAY')
        ->where('ID', $request->id)
        ->delete();
        return [
        	'success'	=> $result,
        	'message'	=> ($result?'Success':'Failed')
        ];
    }

}
