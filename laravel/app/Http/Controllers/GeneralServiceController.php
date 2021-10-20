<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class GeneralServiceController extends Controller
{
    public function get_vessel_by_ves_code(Request $request)
    {
        $result = DB::table('')->where('VES_CODE', $request->ves_code)->get();
        if(count($result) > 0) {
            return response()->json([
                'success'   => true,
                'data'      => $result[0],
            ]);
        }
        return response()->json([
            'success'   => false,
            'data'      => null,
        ]);
    }

    public function get_vessel_det_by_ves_code(Request $request)
    {
        $result = DB::table('CBSLAM.CBS_VESSEL_MASTER_PLAN')->where('VES_CODE', $request->ves_code)->get();
        if(count($result) > 0) {
            return response()->json([
                'success'   => true,
                'data'      => $result[0],
            ]);
        }
        return response()->json([
            'success'   => false,
            'data'      => null,
        ]);
    }

    public function get_vessel_json(Request $request)
    {
        $result = DB::table('CBSLAM.VESSELS')
        ->where(DB::raw("TRIM(AGENT)"), session('agent'))
        ->where(function($query) use ($request){
            $query->orWhere('VES_NAME', 'LIKE', '%'.strtoupper($request->keyword).'%');
            $query->orWhere('VES_CODE', 'LIKE', '%'.strtoupper($request->keyword).'%');
        })
        ->get();

        $data = [];

        foreach ($result as $key => $val) {
            $data[] = ['id' => trim($val->ves_code), 'text' => $val->ves_name.' ('.$val->ves_code.')'];
        }

        return response()->json($data);
    }

    public function get_port_json(Request $request)
    {
        $result = DB::table('CBSLAM.CBS_PORT_MASTER')
        ->where('PORT', 'LIKE', '%'.strtoupper($request->keyword).'%')
        ->orWhere('DESCR', 'LIKE', '%'.strtoupper($request->keyword).'%')
        ->get();

        $data = [];

        foreach ($result as $key => $val) {
            $data[] = ['id' => trim($val->port), 'text' => trim($val->port).' - '.trim($val->descr)];
        }

        return response()->json($data);
    }

    public function get_service_json(Request $request)
    {
        $result = DB::table('CBSLAM.VIERV_MASTER_SERVICE')
        ->where(function($query) use ($request){
            $query->orWhere('VES_SERVICE', 'LIKE', '%'.strtoupper($request->keyword).'%');
        })
        ->get();

        $data = [];

        foreach ($result as $key => $val) {
            $data[] = ['id' => trim($val->ves_service), 'text' => $val->ves_service];
        }

        return response()->json($data);
        
    }
}
