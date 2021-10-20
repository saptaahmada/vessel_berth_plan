<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class MonReqPanduController extends Controller
{
    public function index()
    {
        return view('content.mon_req_pandu.view');
    }

    public function json($tipe){
    	$data = DB::table('CBSLAM.VIERV_PMH_PELY_KAPAL');
    	// if(isset($tipe)) {
    		if($tipe>=0) {
    			$data->where('TIPE', $tipe);
    		}
    	// }
        return DataTables::of($data->get())->make(true);
    }
}
