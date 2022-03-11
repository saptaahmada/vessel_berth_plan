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
        $res_jam = DB::select("SELECT MIN(PARAM3)||':00' MIN_JAM FROM CBSLAM.VBP_GEN_REF
                WHERE PARAM1='EQ_PLAN_HOUR'
                AND PARAM2='0'");

        $min_jam = '00:00';

        if(count($res_jam) > 0) {
            $min_jam = $res_jam[0]->min_jam;
        }

        $min_date = DB::select("SELECT TO_CHAR(PLAN_DATE, 'YYYY-MM-DD') || ' ' || PLAN_TIME PLAN_DATE_TIME
                                FROM CBSLAM.VIERV_EQ_PLAN_COUNT_DEFAULT");

        DB::table('CBSLAM.VIER_EQ_PLAN')
        ->where(DB::raw("TO_DATE(TO_CHAR(PLAN_DATE, 'DD/MM/YYYY') || ' ' || PLAN_TIME, 'DD/MM/YYYY HH24:MI')"), '>=', $min_date[0]->plan_date_time)
        ->delete();

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

        $kesiapan = [];
        // echo json_encode($nested_date);
        // die();

        $data = [];
        foreach ($request->nodes as $n => $nodes) {
            $tam        = 2;
            $i_tam      = 0;
            $eq_type    = $nested_row[$n];
            $plan_date  = $nested_date[$i_tam]['label'];
            $colspan    = $nested_date[$i_tam]['colspan'];
            if($n >= 2) {
                foreach ($nodes as $i => $val) {
                    if($i == ($colspan+$tam)) {
                        $i_tam++;
                        $tam += $colspan;
                        $plan_date  = $nested_date[$i_tam]['label'];
                        $colspan    = $nested_date[$i_tam]['colspan'];
                    }
                    if($i>=2) {
                        $time = $nested_time[$i];
                        // $time = ($nested_time[$i] > 9 ? $nested_time[$i] : '0'.$nested_time[$i]);
                        $data[] = [
                            'PLAN_TYPE'     => 'TRUCK',
                            'EQ_TYPE'       => $eq_type,
                            'PLAN_DATE'     => getDefaultDate($plan_date),
                            'PLAN_TIME'     => "{$time}:00",
                            'PLAN_COUNT'    => $val=='' ? 0: $val,
                            'UPDATED_BY'    => session('data'),
                        ];
                    } else if($i == 1) {
                        $kesiapan[] = [
                            'PLAN_TYPE' => 'KESIAPAN',
                            'EQ_TYPE'   => $eq_type, 
                            'PLAN_DATE' => date('Y-m-d'),
                            'PLAN_COUNT'=> $val=='' ? 0: $val,
                            'UPDATED_BY'=> session('data')
                        ];
                    }
                }
            }
        }

        $res_kes = DB::table('CBSLAM.VIER_EQ_PLAN_COUNT_READY')->insert($kesiapan);

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
            $data = DB::table('CBSLAM.VIERV_EQ_PLAN_COUNT_NOW')->orderBy("Y", "ASC")->orderBy("X", "ASC")->get();
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getVesBerth(Request $request)
    {
        $data = DB::table('CBSLAM.VIERV_VESSEL_NOW A')
            ->orderBy('EST_BERTH_TS', 'ASC')
            ->get();

        // echo json_encode($data);
        // die();
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
            ->orderBy('OI', 'DESC')
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
        $data_tgl_vessel = DB::select("SELECT TO_CHAR(DT, 'DD/MM/YYYY') TGL_STR 
            FROM TOWER.VW_TW_LIST_DATE_ALL
            WHERE DT>=TRUNC(SYSDATE)
            AND DT<=TRUNC(SYSDATE+1)
            ORDER BY DT");
        $data = DB::table('CBSLAM.VIERV_EQ_PLAN_HOUR')->get();
        return response()->json([
            'success'   => true,
            'data'      => $data,
            'data_tgl'  => $data_tgl,
            'data_tgl_vessel' => $data_tgl_vessel,
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
        // $data = DB::select($sql);
        $data = DB::table("CBSLAM.VIERV_EQ_TRUCK_READY")->get();

        return response()->json([
            'success'   => true,
            'data'      => $data,
        ]);
    }

    public function getShiftMinMax()
    {
        $data = DB::table("CBSLAM.VIERV_EQ_PLAN_SHIFT_MIN_MAX")->get();

        return response()->json([
            'success'   => true,
            'data'      => $data,
        ]);
    }

    public function print_spk()
    {
        $sql = "SELECT * FROM CBSLAM.VIERV_EQ_PRINT_SPK WHERE DISTINCT_SHIFT>0";
        $data['data'] = DB::select($sql);
        return view('content.equipment_plan.print_spk', ['data' => $data]);
    }

    public function print($date, $manager, $planner)
    {
        $tgl = DB::select("SELECT INITCAP(TO_CHAR(TGL, 'DY DD MON YYYY')) TGL, TGL_STR, COUNT(1) JUM 
            FROM CBSLAM.VIERV_EQ_PLAN_HOUR 
            GROUP BY TGL_STR, TGL 
            ORDER BY TO_DATE(TGL_STR, 'DD/MM/YYYY') ASC");

        $shift = DB::select("SELECT TGL, SHIFT, COUNT(SHIFT) JUM 
            FROM CBSLAM.VIERV_EQ_PLAN_HOUR_ROSID
            GROUP BY TGL, SHIFT
            ORDER BY TGL, SHIFT");

        $jam = DB::select("SELECT * FROM CBSLAM.VIERV_EQ_PLAN_HOUR");
        $sts_group = DB::select("SELECT VES_ID, TO_NUMBER(regexp_replace(EQ_ID, '[^0-9]', '')) ||SUBSTR (EQ_ID, -1) CRANE
                        FROM CBSLAM.VIERV_EQ_PLAN_NOW
                        GROUP BY VES_ID, EQ_ID
                        ORDER BY VES_ID");

        $sts = DB::select("SELECT 
                A.*,
                CASE 
                    WHEN TO_CHAR(B.ACT_BERTH_TS, 'YYYY') <> '1900' 
                        AND TO_CHAR(B.ACT_DEP_TS, 'YYYY')<>'1900' THEN 2
                    WHEN TO_CHAR(B.ACT_BERTH_TS, 'YYYY') <> '1900' 
                        AND TO_CHAR(B.ACT_DEP_TS, 'YYYY')='1900' THEN 1
                    ELSE 0
                END ALONGSIDE
                FROM CBSLAM.VIERV_EQ_PLAN_VES_MIN_MAX A, 
                CBSLAM.VESSEL_DETAILS_SIM B
                WHERE A.VES_ID=B.VES_ID");
        $perhour = DB::select("SELECT * FROM CBSLAM.VIERV_EQ_PLAN_VES_PERHOUR");

        $det_count = DB::table("CBSLAM.VIERV_EQ_PLAN_COUNT_DEFAULT")->get();
        $det_now = DB::table("CBSLAM.VIERV_EQ_PLAN_COUNT_NOW")->get();
        $det_truck = DB::table("CBSLAM.VIERV_EQ_PLAN_COUNT_NOW")->get();
        $det_total = DB::table("CBSLAM.VIERV_EQ_PLAN_COUNT_NOW")->where('EQ_TYPE', 'TOTAL')->get();
        $row_truck = DB::table("CBSLAM.VIERV_EQ_MONIC_TRUCK")->get();
        $kesiapan = DB::table("CBSLAM.VIERV_EQ_PLAN_KESIAPAN")->get();

        $row_owner = DB::select("SELECT * FROM CBSLAM.VIERV_OWNER_GROUP");

        $sts = json_decode(json_encode($sts), true);
        $sts_i = [];
        $sts_d = [];
        $perhour = json_decode(json_encode($perhour), true);
        $det_truck = json_decode(json_encode($det_truck), true);
        $row_truck = json_decode(json_encode($row_truck), true);
        $row_owner = json_decode(json_encode($row_owner), true);
        // $det_total = [];

        foreach ($sts as $i => $val) {
            foreach ($perhour as $j => $row) {
                if($val['ves_id'] == $row['ves_id']) {
                    $val['hours'][] = $row;
                }
            }
            $crane = [];
            foreach($sts_group as $g => $group) {
                if($val['ves_id'] == $group->ves_id)
                    $crane[] = $group->crane;
                    // $val['crane'] .= $group->crane. ' ';
            }
            $val['crane'] = implode(", ",$crane);;
            if($val['oi'] == 'I') {
                $sts_i[] = $val;
            } else if($val['oi'] == 'D') {
                $sts_d[] = $val;
            }
        }

        foreach ($row_owner as $a => $owner) {
            foreach ($row_truck as $i => $val) {
                // $det_total = [];
                foreach ($det_truck as $j => $row) {
                    if($val['jenis'] == $row['eq_type']) {
                        $val['item'][] = $row;
                    }
                }

                if($owner['owner'] == $val['owner']) {
                    $row_owner[$a]['truck'][] = $val;
                }
            }
        }


        $data = [
            'tgl'   => $tgl,
            'shift' => $shift,
            'jam'   => $jam,
            'sts'   => $sts,
            'sts_i' => $sts_i,
            'sts_d' => $sts_d,
            'hours' => $perhour,
            'det_count'     => $det_count,
            'det_now'       => $det_now,
            'det_truck'     => $det_truck,
            'det_total'     => $det_total,
            'row_truck'     => $row_truck,
            'row_owner'     => $row_owner,
            'manager'       => $manager, 
            'planner'       => $planner,
            'kesiapan'      => $kesiapan
        ];

        return view('content.equipment_plan.print', compact('data'));
    }


    public function show_pdf()
    {
        $data = [];
        $arrParam = [];

        if(isset($_GET['params'])) {

            $params = safeDecrypt(str_replace(' ', '+', $_GET['params']), 'P3lindoBer1');

            $arrParam = explode('|', $params);
        }


        $tgl = DB::select("SELECT INITCAP(TO_CHAR(TGL, 'DY DD MON YYYY')) TGL, TGL_STR, COUNT(1) JUM 
            FROM CBSLAM.VIERV_EQ_PLAN_HOUR 
            GROUP BY TGL_STR, TGL 
            ORDER BY TO_DATE(TGL_STR, 'DD/MM/YYYY') ASC");

        $shift = DB::select("SELECT TGL, SHIFT, COUNT(SHIFT) JUM 
            FROM CBSLAM.VIERV_EQ_PLAN_HOUR_ROSID
            GROUP BY TGL, SHIFT
            ORDER BY TGL, SHIFT");

        $jam = DB::select("SELECT * FROM CBSLAM.VIERV_EQ_PLAN_HOUR");
        $sts_group = DB::select("SELECT VES_ID, TO_NUMBER(regexp_replace(EQ_ID, '[^0-9]', '')) ||SUBSTR (EQ_ID, -1) CRANE
                        FROM CBSLAM.VIER_EQ_PLAN_TMP
                        WHERE PRINT_CODE='{$arrParam[4]}' 
                        GROUP BY VES_ID, EQ_ID
                        ORDER BY VES_ID");

        $sts = DB::select("SELECT 
                A.*,
                CASE 
                    WHEN TO_CHAR(B.ACT_BERTH_TS, 'YYYY') <> '1900' 
                        AND TO_CHAR(B.ACT_DEP_TS, 'YYYY')<>'1900' THEN 2
                    WHEN TO_CHAR(B.ACT_BERTH_TS, 'YYYY') <> '1900' 
                        AND TO_CHAR(B.ACT_DEP_TS, 'YYYY')='1900' THEN 1
                    ELSE 0
                END ALONGSIDE
                FROM CBSLAM.VIERV_EQP_VES_MIN_MAX_TMP A, 
                CBSLAM.VESSEL_DETAILS_SIM B
                WHERE A.VES_ID=B.VES_ID AND PRINT_CODE='{$arrParam[4]}' 
                ORDER BY MIN_DATE");

        $perhour = DB::select("SELECT * FROM CBSLAM.VIERV_EQ_PLAN_VES_PERHOUR");

        $det_count = DB::table("CBSLAM.VIER_EQ_PLAN_COUNT_DEFAULT_TMP")->where('PRINT_CODE', $arrParam[4])->get();
        $det_now = DB::table("CBSLAM.VIER_EQ_PLAN_COUNT_TMP")->where('PRINT_CODE', $arrParam[4])->orderBy('X')->get();
        $det_truck = DB::table("CBSLAM.VIER_EQ_PLAN_COUNT_TMP")->where('PRINT_CODE', $arrParam[4])->orderBy('X')->get();
        $det_total = DB::table("CBSLAM.VIER_EQ_PLAN_COUNT_TMP")
                    ->where('PRINT_CODE', $arrParam[4])
                    ->where('EQ_TYPE', 'TOTAL')->orderBy('X')->get();
        $row_truck = DB::table("CBSLAM.VIERV_EQ_MONIC_TRUCK")->get();
        $kesiapan = DB::table("CBSLAM.VIER_EQ_PLAN_KESIAPAN_TMP")->where('PRINT_CODE', $arrParam[4])->get();

        $row_owner = DB::select("SELECT * FROM CBSLAM.VIERV_OWNER_GROUP");

        $sts = json_decode(json_encode($sts), true);
        $sts_i = [];
        $sts_d = [];
        $perhour = json_decode(json_encode($perhour), true);
        $det_truck = json_decode(json_encode($det_truck), true);
        $row_truck = json_decode(json_encode($row_truck), true);
        $row_owner = json_decode(json_encode($row_owner), true);
        // $det_total = [];

        foreach ($sts as $i => $val) {
            foreach ($perhour as $j => $row) {
                if($val['ves_id'] == $row['ves_id']) {
                    $val['hours'][] = $row;
                }
            }
            $crane = [];
            foreach($sts_group as $g => $group) {
                if($val['ves_id'] == $group->ves_id)
                    $crane[] = $group->crane;
                    // $val['crane'] .= $group->crane. ' ';
            }
            $val['crane'] = implode(", ",$crane);;
            if($val['oi'] == 'I') {
                $sts_i[] = $val;
            } else if($val['oi'] == 'D') {
                $sts_d[] = $val;
            }
        }

        foreach ($row_owner as $a => $owner) {
            foreach ($row_truck as $i => $val) {
                // $det_total = [];
                foreach ($det_truck as $j => $row) {
                    if($val['jenis'] == $row['eq_type']) {
                        $val['item'][] = $row;
                    }
                }

                if($owner['owner'] == $val['owner']) {
                    $row_owner[$a]['truck'][] = $val;
                }
            }
        }


        $data = [
            'tgl'   => $tgl,
            'shift' => $shift,
            'jam'   => $jam,
            'sts'   => $sts,
            'sts_i' => $sts_i,
            'sts_d' => $sts_d,
            'hours' => $perhour,
            'det_count'     => $det_count,
            'det_now'       => $det_now,
            'det_truck'     => $det_truck,
            'det_total'     => $det_total,
            'row_truck'     => $row_truck,
            'row_owner'     => $row_owner,
            'kesiapan'      => $kesiapan
        ];


        if(count($arrParam) == 5) {
            $data['param11']    = $arrParam[0];
            $data['param22']    = $arrParam[1];
            $data['datestart']  = getDefaultDate($arrParam[2]);
            $data['date']       = $arrParam[2];
            $data['no_doc']     = $arrParam[3];
            $data['code']       = $arrParam[4];
            $data['is_required']= true;
        }

        // echo json_encode($data);
        // die();

        return view('content.equipment_plan.print', compact('data'));
    }

    public function show_spk()
    {
        $data = [];
        $arrParam = [];

        if(isset($_GET['params'])) {

            $params = safeDecrypt(str_replace(' ', '+', $_GET['params']), 'P3lindoBer1');

            $arrParam = explode('|', $params);
        }


        $sql            = "SELECT * FROM CBSLAM.VIER_EQ_PRINT_SPK_TMP WHERE DISTINCT_SHIFT>0 AND PRINT_CODE='{$arrParam[4]}'";
        $data['data']   = DB::select($sql);

        if(count($arrParam) == 5) {
            $data['param11']    = $arrParam[0];
            $data['param22']    = $arrParam[1];
            $data['datestart']  = getDefaultDate($arrParam[2]);
            $data['date']       = $arrParam[2];
            $data['no_doc']     = $arrParam[3];
            $data['code']       = $arrParam[4];
            $data['is_required']= true;
        }

        return view('content.equipment_plan.print_spk', ['data' => $data]);
    }

}
