<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class YardPlanController extends Controller
{
    public function index()
    {
        return view('content.yard_plan.view');
    }

    public function getBlock()
    {
    	$data = DB::table("CBSLAM.VIERV_YP_BLOCK")->get();
        return response()->json([
            'success' 	=> true,
            'data' 		=> $data
        ]);
    }

    public function getDestination(Request $request)
    {
    	$data = DB::table("CBSLAM.VESSEL_SERVICE")->where(DB::raw("TRIM(VES_SERVICE)"), $request->ves_service)->get();
        return response()->json([
            'success' 	=> true,
            'data' 		=> $data
        ]);
    }

}
