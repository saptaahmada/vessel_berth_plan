<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class EquipmentPlanController extends Controller
{
    public function index()
    {
        return view('content.equipment_plan.view');
    }

    public function save(Request $request)
    {
        DB::table('CBSLAM.VIER_EQ_PLAN')->where('PLAN_DATE', '>=', date('Y-m-d'))->delete();
        foreach ($request->nodes as $key => $val) {
            $data = [
                'VES_ID'        => $val['ves_id'],
                'EQ_ID'         => $val['eq_id'],
                'EQ_TYPE'       => $val['eq_type'],
                'PLAN_DATE'     => getDefaultDate($val['plan_date_str']),
                'PLAN_TIME'     => $val['plan_time'],
                'COLOR_CODE'    => $val['color_code'],
                'CREATED_BY'    => session('data'),
            ];
            DB::table('CBSLAM.VIER_EQ_PLAN')->insert($data);
        }
        return [
            'success'   => true,
            'message'   => 'Sukses'
        ];
    }

    public function getNodes(Request $request)
    {
        $data = DB::table('CBSLAM.VIERV_EQ_PLAN_NOW')->get();

        $data_0 = [];
        $data_1 = [];
        $data_2 = [];

        foreach ($data as $key => $val) {
            if($val->eq_type == 0) {
                $data_0[] = $val;
            } else if($val->eq_type == 1) {
                $data_1[] = $val;
            } else if($val->eq_type == 2) {
                $data_2[] = $val;
            }
        }

        return response()->json([
            'success'   => true,
            'data'      => [
                'data_0'=> $data_0,
                'data_1'=> $data_1,
                'data_2'=> $data_2,
            ]
        ]);
    }

    public function getVesBerth(Request $request)
    {
        $data = DB::table('CBSLAM.CBS_VESSEL_PLANNING')
            ->where(DB::raw("TRUNC(EST_BERTH_TS)"), "<=", DB::raw("TRUNC(SYSDATE+1)"))
            ->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getCrane(Request $request)
    {
        $data_0 = DB::table('CBSLAM.CBS_CHE_MASTER')
            ->orWhere('CHE_TYPE', 'PTR')
            ->orWhere('CHE_TYPE', 'GSU')
            ->orderBy('ORDER_CHE_TYPE', 'ASC')
            ->orderBy('OCEAN_INTERISLAND', 'DESC')
            ->orderBy('CHE_ID', 'ASC')
            ->get();

        $data_1 = DB::table('CBSLAM.CBS_CHE_MASTER')
            ->orWhere('CHE_TYPE', 'TLR')
            ->orderBy('CHE_NAME', 'ASC')
            ->get();

        $data_2 = [];

        return response()->json([
            'success'   => true,
            'data'      => [
                'data_0'=> $data_0,
                'data_1'=> $data_1,
                'data_2'=> $data_2,
            ]
        ]);
    }

    public function getTruck(Request $request)
    {
        $data = DB::table('CBSLAM.CBS_CHE_MASTER')
            ->orWhere('CHE_TYPE', 'TLR')
            ->orderBy('CHE_NAME', 'ASC')
            ->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getEqPlanHour(Request $request)
    {
        $data_tgl = DB::select("SELECT TGL_STR, COUNT(1) JUM 
            FROM CBSLAM.VIERV_EQ_PLAN_HOUR 
            GROUP BY TGL_STR 
            ORDER BY MAX(TGL)");
        $data = DB::table('CBSLAM.VIERV_EQ_PLAN_HOUR')->get();
        return response()->json([
            'success'   => true,
            'data'      => $data,
            'data_tgl'  => $data_tgl,
        ]);
    }

}
