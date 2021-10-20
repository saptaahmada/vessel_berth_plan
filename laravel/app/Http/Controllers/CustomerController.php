<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Dermaga;
use DataTables;

class CustomerController extends Controller
{
    public function get_agent_json(Request $request)
    {
        $result = DB::table('CBSLAM.CUSTOMER')
        ->where("CUST_TYPE", '3  ')
        ->whereNotNull('AGENT')
        ->where('FULL_NAME', 'LIKE', '%'.strtoupper($request->keyword).'%')
        // ->where('AGENT', 'LIKE', '%'.strtoupper($request->keyword).'%')
        ->get();

        $data = [];

        foreach ($result as $key => $val) {
            $data[] = ['id' => trim($val->agent), 'text' => trim($val->full_name)];
        }

        return response()->json($data);
    }
}
