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
        $data = DB::table('CBSLAM.VIERV_EQ_PLAN_NOW')->where('EQ_TYPE', $request->eq_type)->get();
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
            ->orderBy('JENIS', 'DESC')
            ->orderBy('KODE_ALAT', 'ASC')
            ->get();

        $data_truck = DB::table('CBSLAM.VIERV_EQ_MONIC')
            // ->where('KONDISI', 'R')
            ->whereIn('JENIS', ['TB', 'CTT', 'HT', 'TT'])
            ->orderBy('JENIS', 'ASC')
            ->orderBy('KODE_ALAT', 'ASC')
            ->get();

        return response()->json([
            'success'       => true,
            'data_crane'    => $data_crane,
            'data_truck'    => $data_truck,
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

}
