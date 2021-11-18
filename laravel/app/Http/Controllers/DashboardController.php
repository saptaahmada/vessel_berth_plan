<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;


class DashboardController extends Controller
{
    public function index()
    {
        return view('content.dashboard.view');
    }

    public function json($ocean_interisland, $date_from, $date_to){
        $data = DB::table('CBSLAM.VIERV_SHIP_TO_SHIP')->whereBetween('VES1_DEP_DATE', [$date_from, $date_to]);
        if($ocean_interisland != 'A')
            $data->where('OCEAN_INTERISLAND', $ocean_interisland);
        return DataTables::of($data->get())->make(true);
    }

    public function get_ship_to_ship(Request $request)
    {
        $result = DB::select("SELECT *
                FROM
                (SELECT NVL(ROUND(SUM(DIFF)/COUNT(1), 2), 0) RES 
                FROM CBSLAM.VIERV_SHIP_TO_SHIP
                WHERE IS_SHIP_TO_SHIP='Y'
                AND VES1_DEP_DATE BETWEEN TO_DATE('{$request->date_from}', 'YYYY-MM-DD')
                AND TO_DATE('{$request->date_to} 23:59:59', 'YYYY-MM-DD HH24:MI:SS')) A,
                (SELECT NVL(ROUND(SUM(DIFF)/COUNT(1), 2), 0) RES_D 
                FROM CBSLAM.VIERV_SHIP_TO_SHIP 
                WHERE IS_SHIP_TO_SHIP='Y'
                AND VES1_DEP_DATE BETWEEN TO_DATE('{$request->date_from}', 'YYYY-MM-DD')
                AND TO_DATE('{$request->date_to} 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
                AND OCEAN_INTERISLAND='D') B,
                (SELECT NVL(ROUND(SUM(DIFF)/COUNT(1), 2), 0) RES_I
                FROM CBSLAM.VIERV_SHIP_TO_SHIP
                WHERE IS_SHIP_TO_SHIP='Y'
                AND VES1_DEP_DATE BETWEEN TO_DATE('{$request->date_from}', 'YYYY-MM-DD')
                AND TO_DATE('{$request->date_to} 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
                AND OCEAN_INTERISLAND='I') C,
                (SELECT NVL(ROUND(SUM(DIFF)/COUNT(1), 2), 0) RES_C
                FROM CBSLAM.VIERV_SHIP_TO_SHIP
                WHERE IS_SHIP_TO_SHIP='Y'
                AND VES1_DEP_DATE BETWEEN TO_DATE('{$request->date_from}', 'YYYY-MM-DD')
                AND TO_DATE('{$request->date_to} 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
                AND OCEAN_INTERISLAND='C') D,
                CBSLAM.VBP_GEN_REF E
                WHERE E.PARAM1='SHIP_TO_SHIP_MAX'");

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
}
