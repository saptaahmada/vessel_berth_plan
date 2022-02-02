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
        $data = [];
        foreach ($request->nodes as $key => $val) {
            $data[] = [
                'VES_ID'        => $val['ves_id'],
                'EQ_ID'         => $val['eq_id'],
                'EQ_TYPE'       => $val['eq_type'],
                'PLAN_DATE'     => getDefaultDate($val['plan_date_str']),
                'PLAN_TIME'     => $val['plan_time'],
                'COLOR_CODE'    => $val['color_code'],
            ];
        }
        $res = DB::table('CBSLAM.VIER_EQ_PLAN')->insert($data);
        // return [
        //     'success'   => true,
        //     'message'   => 'Sukses'
        // ];
        if($res) {
            return [
                'success'   => true,
                'message'   => 'Sukses'
            ];
        } else {
            return [
                'success'   => false,
                'message'   => 'Error'
            ];
        }
    }

    public function delCurEqPlanCount()
    {
        $procedureName = 'CBSLAM.VIERP_DEL_CUR_EQ_PLAN_COUNT';
        $result = DB::executeProcedure($procedureName);
        return response()->json($result);
    }

    public function saveTruck(Request $request)
    {
        $this->delCurEqPlanCount();

        $sql = "SELECT * FROM CBSLAM.VBP_GEN_REF 
                WHERE PARAM1='EQ_PLAN_HOUR' 
                ORDER BY PARAM2, PARAM3";

        $hours = DB::select($sql);

        $tam            = 1;
        $i_tam          = 0;
        $nested_date    = $request->nested_date;
        $nested_time    = $request->nested_time;
        $nested_row    = $request->nested_row;

        $data = [];
        foreach ($request->nodes as $n => $nodes) {
            $tam        = 1;
            $i_tam      = 0;
            $eq_type    = $nested_row[$n];
            $plan_date  = $nested_date[$i_tam]['label'];
            $colspan    = $nested_date[$i_tam]['colspan'];
            foreach ($nodes as $i => $val) {
                if($i == ($colspan+$tam)) {
                    $i_tam++;
                    $tam += $colspan;
                    $plan_date  = $nested_date[$i_tam]['label'];
                    $colspan    = $nested_date[$i_tam]['colspan'];
                }
                if($i>=1) {
                    $time = $nested_time[$i];
                    // $time = ($nested_time[$i] > 9 ? $nested_time[$i] : '0'.$nested_time[$i]);
                    $data[] = [
                        'PLAN_TYPE'     => 'TRUCK',
                        'EQ_TYPE'       => $eq_type,
                        'PLAN_DATE'     => getDefaultDate($plan_date),
                        'PLAN_TIME'     => "{$time}:00",
                        'PLAN_COUNT'    => $val,
                        'UPDATED_BY'    => session('data'),
                    ];
                }
            }
        }

        $res = DB::table('CBSLAM.VIER_EQ_PLAN_COUNT')->insert($data);
        
        if($res) {
            return [
                'success'   => true,
                'message'   => 'Sukses'
            ];
        } else {
            return [
                'success'   => false,
                'message'   => 'Error'
            ];
        }
    }

    public function getNodes(Request $request)
    {
        if($request->eq_key == 'CRANE') {
            $data = DB::table('CBSLAM.VIERV_EQ_PLAN_NOW')->where('EQ_TYPE', $request->eq_type)->get();
        } else if($request->eq_key == 'TRUCK') {
            $data = DB::table('CBSLAM.VIERV_EQ_PLAN_COUNT_NOW')->get();
        }
        return response()->json([
            'success' => true,
            'data' => $data
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

    public function getEq(Request $request)
    {
        $data_crane = DB::table('CBSLAM.VIERV_EQ_MONIC')
            // ->where('KONDISI', 'R')
            ->whereIn('JENIS', ['STS', 'GSU'])
            ->orderBy('OI', 'ASC')
            ->orderBy('JENIS', 'DESC')
            ->orderBy('KODE_ALAT', 'ASC')
            ->get();

        $data_truck = DB::table('CBSLAM.VIERV_EQ_PLAN_COUNT_DEFAULT')->get();

        $sql = "SELECT PARAM2 EQ_TYPE FROM CBSLAM.VBP_GEN_REF
                WHERE PARAM1='EQ_PLAN_ARMADA'
                ORDER BY TO_NUMBER(PARAM3)";

        $row_header_truck = DB::select($sql);

        return response()->json([
            'success'       => true,
            'data_crane'    => $data_crane,
            'data_truck'    => $data_truck,
            'row_header_truck'  => $row_header_truck,
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

    public function getEqGroup(Request $request)
    {
        $sql = "SELECT * FROM CBSLAM.VIERV_EQ_GROUP 
                WHERE EQ_TYPE = '{$request->eq_type}'";

        $data = DB::select($sql);

        return response()->json([
            'success'   => true,
            'data'      => $data,
        ]);
    }

    public function getEqTruckReady()
    {
        $data = DB::table("CBSLAM.VIERV_EQ_MONIC_TRUCK")->get();

        return response()->json([
            'success'   => true,
            'data'      => $data,
        ]);
    }

}
