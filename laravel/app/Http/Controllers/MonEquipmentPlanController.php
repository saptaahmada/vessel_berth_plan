<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class MonEquipmentPlanController extends Controller
{
    public function index()
    {
        return view('content.mon_equipment_plan.view');
    }

    public function getNodes(Request $request)
    {
        if($request->eq_key == 'CRANE') {
            $data = DB::select("SELECT B.X,
                        D.Y,
                        A.ID,
                        A.EQ_ID,
                        CASE WHEN EQ_TYPE = 0 THEN SUBSTR (EQ_ID, 7, 1) ELSE NULL END OI,
                        A.EQ_TYPE,
                        A.PLAN_DATE,
                        A.PLAN_DATE_STR,
                        A.PLAN_TIME,
                        A.PLAN_TIME_ID,
                        A.VES_ID,
                        A.START_DATE,
                        A.END_DATE,
                        A.START_TIME,
                        A.END_TIME,
                        A.COLOR_CODE,
                        A.UPDATED_BY,
                        A.UPDATED_DATE
                   FROM CBSLAM.VIERV_EQ_PLAN A,
                        (SELECT 
                        X, 
                        TGL, 
                        TO_DATE(TO_CHAR(TGL, 'DD/MM/YYYY')||' '||JAM_STR, 'DD/MM/YYYY HH24:MI') JAM, 
                        TO_CHAR(TGL, 'DD/MM/YYYY') TGL_STR, 
                        JAM_STR, 
                        JAM_ID, SHIFT, DISTINCT_SHIFT
                        FROM (
                        SELECT X, 
                        CASE WHEN TGL=TRUNC(SYSDATE) THEN TO_DATE('{$request->date}', 'YYYY-MM-DD')
                        ELSE TO_DATE('{$request->date}', 'YYYY-MM-DD')+1
                        END TGL, 
                        JAM, TGL_STR, JAM_STR, JAM_ID, SHIFT, DISTINCT_SHIFT 
                        FROM CBSLAM.VIERV_EQ_PLAN_HOUR)) B,
                        (SELECT MIN (JAM) JAM_MIN, MAX (JAM) JAM_MAX
                           FROM (SELECT 
                        X, 
                        TGL, 
                        TO_DATE(TO_CHAR(TGL, 'DD/MM/YYYY')||' '||JAM_STR, 'DD/MM/YYYY HH24:MI') JAM, 
                        TO_CHAR(TGL, 'DD/MM/YYYY') TGL_STR, 
                        JAM_STR, 
                        JAM_ID, SHIFT, DISTINCT_SHIFT
                        FROM (
                        SELECT X, 
                        CASE WHEN TGL=TRUNC(SYSDATE) THEN TO_DATE('{$request->date}', 'YYYY-MM-DD')
                        ELSE TO_DATE('{$request->date}', 'YYYY-MM-DD')+1
                        END TGL, 
                        JAM, TGL_STR, JAM_STR, JAM_ID, SHIFT, DISTINCT_SHIFT 
                        FROM CBSLAM.VIERV_EQ_PLAN_HOUR))) C,
                        (SELECT ROWNUM - 1 Y, A.*
                           FROM (  SELECT *
                                     FROM CBSLAM.VIERV_EQ_MONIC
                                    WHERE JENIS IN ('STS', 'GSU')
                                 ORDER BY JENIS DESC, OI DESC, KODE_ALAT ASC) A
                         UNION ALL
                         SELECT ROWNUM - 1 Y, A.*
                           FROM (  SELECT *
                                     FROM CBSLAM.VIERV_EQ_MONIC
                                    WHERE JENIS IN ('CTT', 'HT', 'TB', 'TT')
                                 ORDER BY KODE_ALAT ASC) A) D
                  WHERE     START_DATE >= C.JAM_MIN - 1 / 24
                        AND START_DATE <= C.JAM_MAX
                        AND PLAN_DATE = B.TGL
                        AND PLAN_TIME = B.JAM_STR
                        AND EQ_ID = D.KODE_ALAT
                        AND EQ_TYPE=0
               ORDER BY START_DATE DESC");
        } else if($request->eq_key == 'TRUCK') {
            $data = DB::select("SELECT B.X,
                            D.Y,
                            A.ID,
                            A.EQ_TYPE,
                            A.PLAN_DATE,
                            A.PLAN_DATE_STR,
                            A.PLAN_TIME,
                            A.PLAN_COUNT,
                            A.PLAN_TIME_ID,
                            B.SHIFT,
                            B.DISTINCT_SHIFT,
                            A.START_DATE,
                            A.END_DATE,
                            A.START_TIME,
                            A.END_TIME,
                            A.UPDATED_BY,
                            A.UPDATED_DATE
                       FROM CBSLAM.VIERV_EQ_PLAN_COUNT A,
                            (SELECT 
                            X, 
                            TGL, 
                            TO_DATE(TO_CHAR(TGL, 'DD/MM/YYYY')||' '||JAM_STR, 'DD/MM/YYYY HH24:MI') JAM, 
                            TO_CHAR(TGL, 'DD/MM/YYYY') TGL_STR, 
                            JAM_STR, 
                            JAM_ID, SHIFT, DISTINCT_SHIFT
                            FROM (
                            SELECT X, 
                            CASE WHEN TGL=TRUNC(SYSDATE) THEN TO_DATE('{$request->date}', 'YYYY-MM-DD')
                            ELSE TO_DATE('{$request->date}', 'YYYY-MM-DD')+1
                            END TGL, 
                            JAM, TGL_STR, JAM_STR, JAM_ID, SHIFT, DISTINCT_SHIFT 
                            FROM CBSLAM.VIERV_EQ_PLAN_HOUR)) B,
                            (SELECT MIN (JAM) JAM_MIN, MAX (JAM) JAM_MAX
                               FROM (SELECT 
                            X, 
                            TGL, 
                            TO_DATE(TO_CHAR(TGL, 'DD/MM/YYYY')||' '||JAM_STR, 'DD/MM/YYYY HH24:MI') JAM, 
                            TO_CHAR(TGL, 'DD/MM/YYYY') TGL_STR, 
                            JAM_STR, 
                            JAM_ID, SHIFT, DISTINCT_SHIFT
                            FROM (
                            SELECT X, 
                            CASE WHEN TGL=TRUNC(SYSDATE) THEN TO_DATE('{$request->date}', 'YYYY-MM-DD')
                            ELSE TO_DATE('{$request->date}', 'YYYY-MM-DD')+1
                            END TGL, 
                            JAM, TGL_STR, JAM_STR, JAM_ID, SHIFT, DISTINCT_SHIFT 
                            FROM CBSLAM.VIERV_EQ_PLAN_HOUR))) C,
                            (SELECT ROWNUM - 1 Y, PARAM2 JENIS
                               FROM (  SELECT A.*
                                         FROM CBSLAM.VBP_GEN_REF A
                                        WHERE PARAM1 = 'EQ_PLAN_ARMADA'
                                     ORDER BY TO_NUMBER (PARAM3))) D
                      WHERE     START_DATE >= C.JAM_MIN - 1 / 24
                            AND START_DATE <= C.JAM_MAX
                            AND PLAN_DATE = B.TGL
                            AND PLAN_TIME = B.JAM_STR
                            AND EQ_TYPE = D.JENIS
                   ORDER BY START_DATE ASC, X ASC, Y ASC");
            // $data = DB::table('CBSLAM.VIERV_EQ_PLAN_COUNT_NOW')->orderBy("Y", "ASC")->orderBy("X", "ASC")->get();
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getVesBerth(Request $request)
    {
        $sql = "SELECT * FROM CBSLAM.VIERV_VESSEL_ALL
                WHERE EST_BERTH_TS>=TO_DATE('{$request->date}', 'YYYY-MM-DD')
                AND EST_BERTH_TS<TO_DATE('{$request->date}', 'YYYY-MM-DD')+2
                ORDER BY EST_BERTH_TS ASC";

        $data = DB::select($sql);

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

        $data_truck = DB::select("SELECT C.TGL PLAN_DATE,
                            C.JAM_STR PLAN_TIME,
                            COUNT (A.PLAN_DATE) JUM_V,
                            COUNT (A.PLAN_DATE) * TO_NUMBER (PARAM2) JUM_T
                       FROM (SELECT *
                               FROM (SELECT B.X,
                                        D.Y,
                                        A.ID,
                                        A.EQ_ID,
                                        CASE WHEN EQ_TYPE = 0 THEN SUBSTR (EQ_ID, 7, 1) ELSE NULL END OI,
                                        A.EQ_TYPE,
                                        A.PLAN_DATE,
                                        A.PLAN_DATE_STR,
                                        A.PLAN_TIME,
                                        A.PLAN_TIME_ID,
                                        A.VES_ID,
                                        A.START_DATE,
                                        A.END_DATE,
                                        A.START_TIME,
                                        A.END_TIME,
                                        A.COLOR_CODE,
                                        A.UPDATED_BY,
                                        A.UPDATED_DATE
                                   FROM CBSLAM.VIERV_EQ_PLAN A,
                                        (SELECT 
                                        X, 
                                        TGL, 
                                        TO_DATE(TO_CHAR(TGL, 'DD/MM/YYYY')||' '||JAM_STR, 'DD/MM/YYYY HH24:MI') JAM, 
                                        TO_CHAR(TGL, 'DD/MM/YYYY') TGL_STR, 
                                        JAM_STR, 
                                        JAM_ID, SHIFT, DISTINCT_SHIFT
                                        FROM (
                                        SELECT X, 
                                        CASE WHEN TGL=TRUNC(SYSDATE) THEN TO_DATE('{$request->date}', 'YYYY-MM-DD')
                                        ELSE TO_DATE('{$request->date}', 'YYYY-MM-DD')+1
                                        END TGL, 
                                        JAM, TGL_STR, JAM_STR, JAM_ID, SHIFT, DISTINCT_SHIFT 
                                        FROM CBSLAM.VIERV_EQ_PLAN_HOUR)) B,
                                        (SELECT MIN (JAM) JAM_MIN, MAX (JAM) JAM_MAX
                                           FROM (SELECT 
                                        X, 
                                        TGL, 
                                        TO_DATE(TO_CHAR(TGL, 'DD/MM/YYYY')||' '||JAM_STR, 'DD/MM/YYYY HH24:MI') JAM, 
                                        TO_CHAR(TGL, 'DD/MM/YYYY') TGL_STR, 
                                        JAM_STR, 
                                        JAM_ID, SHIFT, DISTINCT_SHIFT
                                        FROM (
                                        SELECT X, 
                                        CASE WHEN TGL=TRUNC(SYSDATE) THEN TO_DATE('{$request->date}', 'YYYY-MM-DD')
                                        ELSE TO_DATE('{$request->date}', 'YYYY-MM-DD')+1
                                        END TGL, 
                                        JAM, TGL_STR, JAM_STR, JAM_ID, SHIFT, DISTINCT_SHIFT 
                                        FROM CBSLAM.VIERV_EQ_PLAN_HOUR))) C,
                                        (SELECT ROWNUM - 1 Y, A.*
                                           FROM (  SELECT *
                                                     FROM CBSLAM.VIERV_EQ_MONIC
                                                    WHERE JENIS IN ('STS', 'GSU')
                                                 ORDER BY JENIS DESC, OI DESC, KODE_ALAT ASC) A
                                         UNION ALL
                                         SELECT ROWNUM - 1 Y, A.*
                                           FROM (  SELECT *
                                                     FROM CBSLAM.VIERV_EQ_MONIC
                                                    WHERE JENIS IN ('CTT', 'HT', 'TB', 'TT')
                                                 ORDER BY KODE_ALAT ASC) A) D
                                  WHERE     START_DATE >= C.JAM_MIN - 1 / 24
                                        AND START_DATE <= C.JAM_MAX
                                        AND PLAN_DATE = B.TGL
                                        AND PLAN_TIME = B.JAM_STR
                                        AND EQ_ID = D.KODE_ALAT
                                        AND EQ_TYPE=0
                               ORDER BY START_DATE DESC) A, CBSLAM.VESSEL_DETAILS_SIM B
                              WHERE A.VES_ID = B.VES_ID AND OCEAN_INTERISLAND_FAKE <> 'C') A,
                            CBSLAM.VBP_GEN_REF B,
                            (SELECT 
                            X, 
                            TGL, 
                            TO_DATE(TO_CHAR(TGL, 'DD/MM/YYYY')||' '||JAM_STR, 'DD/MM/YYYY HH24:MI') JAM, 
                            TO_CHAR(TGL, 'DD/MM/YYYY') TGL_STR, 
                            JAM_STR, 
                            JAM_ID, SHIFT, DISTINCT_SHIFT
                            FROM (
                            SELECT X, 
                            CASE WHEN TGL=TRUNC(SYSDATE) THEN TO_DATE('{$request->date}', 'YYYY-MM-DD')
                            ELSE TO_DATE('{$request->date}', 'YYYY-MM-DD')+1
                            END TGL, 
                            JAM, TGL_STR, JAM_STR, JAM_ID, SHIFT, DISTINCT_SHIFT 
                            FROM CBSLAM.VIERV_EQ_PLAN_HOUR)) C
                      WHERE     B.PARAM1 = 'EQ_PLAN_P_NEED_TRUCK'
                            AND A.PLAN_DATE(+) = C.TGL
                            AND A.PLAN_TIME(+) = C.JAM_STR
                   GROUP BY C.TGL, C.JAM_STR, PARAM2
                   ORDER BY PLAN_DATE, PLAN_TIME");

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
            FROM (SELECT 
                X, 
                TGL, 
                TO_DATE(TO_CHAR(TGL, 'DD/MM/YYYY')||' '||JAM_STR, 'DD/MM/YYYY HH24:MI') JAM, 
                TO_CHAR(TGL, 'DD/MM/YYYY') TGL_STR, 
                JAM_STR, 
                JAM_ID, SHIFT, DISTINCT_SHIFT
                FROM (
                SELECT X, 
                CASE WHEN TGL=TRUNC(SYSDATE) THEN TO_DATE('{$request->date}', 'YYYY-MM-DD')
                ELSE TO_DATE('{$request->date}', 'YYYY-MM-DD')+1
                END TGL, 
                JAM, TGL_STR, JAM_STR, JAM_ID, SHIFT, DISTINCT_SHIFT 
                FROM CBSLAM.VIERV_EQ_PLAN_HOUR))
            GROUP BY TGL_STR 
            ORDER BY MAX(TGL)");
        $data_tgl_vessel = DB::select("SELECT TO_CHAR(DT, 'DD/MM/YYYY') TGL_STR 
            FROM TOWER.VW_TW_LIST_DATE_ALL
            WHERE DT>=TRUNC(TO_DATE('{$request->date}', 'YYYY-MM-DD'))
            AND DT<=TRUNC(TO_DATE('{$request->date}', 'YYYY-MM-DD')+1)
            ORDER BY DT");
        $data = DB::select("SELECT 
            X, 
            TGL, 
            TO_DATE(TO_CHAR(TGL, 'DD/MM/YYYY')||' '||JAM_STR, 'DD/MM/YYYY HH24:MI') JAM, 
            TO_CHAR(TGL, 'DD/MM/YYYY') TGL_STR, 
            JAM_STR, 
            JAM_ID, SHIFT, DISTINCT_SHIFT
            FROM (
            SELECT X, 
            CASE WHEN TGL=TRUNC(SYSDATE) THEN TO_DATE('{$request->date}', 'YYYY-MM-DD')
            ELSE TO_DATE('{$request->date}', 'YYYY-MM-DD')+1
            END TGL, 
            JAM, TGL_STR, JAM_STR, JAM_ID, SHIFT, DISTINCT_SHIFT 
            FROM CBSLAM.VIERV_EQ_PLAN_HOUR)");

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

    public function getEqTruckReady(Request $request)
    {
        // $data = DB::select($sql);
        $data = DB::select("SELECT * FROM CBSLAM.VIER_EQ_PLAN_KESIAPAN_TMP 
                WHERE TRUNC(PRINT_DATE)=TO_DATE('{$request->date}', 'YYYY-MM-DD')");

        return response()->json([
            'success'   => true,
            'data'      => $data,
        ]);
    }

    public function getShiftMinMax(Request $request)
    {
        $data = DB::select("SELECT DISTINCT_SHIFT,
                        MAX (SHIFT) SHIFT,
                        COUNT (DISTINCT_SHIFT) JUM,
                        TO_CHAR (MIN (JAM), 'DD/MM/YYYY') MIN_TGL,
                        TO_CHAR (MAX (JAM), 'DD/MM/YYYY') MAX_TGL,
                        TO_CHAR (MIN (JAM), 'HH24') MIN_JAM,
                        TO_CHAR (MAX (JAM), 'HH24') MAX_JAM,
                        TO_CHAR (MAX (JAM + 1 / 24), 'HH24') MAX_END_JAM,
                        MIN (X) MIN_X,
                        MAX (X) MAX_X,
                        TO_CHAR (MIN (JAM), 'YYYY-MM-DD') MIN_TGL_2
                   FROM (SELECT 
                        X, 
                        TGL, 
                        TO_DATE(TO_CHAR(TGL, 'DD/MM/YYYY')||' '||JAM_STR, 'DD/MM/YYYY HH24:MI') JAM, 
                        TO_CHAR(TGL, 'DD/MM/YYYY') TGL_STR, 
                        JAM_STR, 
                        JAM_ID, SHIFT, DISTINCT_SHIFT
                        FROM (
                        SELECT X, 
                        CASE WHEN TGL=TRUNC(SYSDATE) THEN TO_DATE('{$request->date}', 'YYYY-MM-DD')
                        ELSE TO_DATE('{$request->date}', 'YYYY-MM-DD')+1
                        END TGL, 
                        JAM, TGL_STR, JAM_STR, JAM_ID, SHIFT, DISTINCT_SHIFT 
                        FROM CBSLAM.VIERV_EQ_PLAN_HOUR))
               GROUP BY DISTINCT_SHIFT
               ORDER BY DISTINCT_SHIFT");

        return response()->json([
            'success'   => true,
            'data'      => $data,
        ]);
    }

    public function getShiftMinMax2Day()
    {
        $data = DB::table("CBSLAM.VIERV_EQP_SHIFT_MIN_MAX_2DAY")->get();

        return response()->json([
            'success'   => true,
            'data'      => $data,
        ]);
    }

    public function print_spk($date)
    {
        $sql = "SELECT B.DISTINCT_SHIFT,
                    MIN (START_DATE) START_DATE,
                    MAX (END_DATE) END_DATE,
                    CASE
                       WHEN TO_CHAR (MIN (START_DATE), 'DY') = 'SUN' THEN 'Minggu'
                       WHEN TO_CHAR (MIN (START_DATE), 'DY') = 'MON' THEN 'Senin'
                       WHEN TO_CHAR (MIN (START_DATE), 'DY') = 'TUE' THEN 'Selasa'
                       WHEN TO_CHAR (MIN (START_DATE), 'DY') = 'WED' THEN 'Rabu'
                       WHEN TO_CHAR (MIN (START_DATE), 'DY') = 'THU' THEN 'Kamis'
                       WHEN TO_CHAR (MIN (START_DATE), 'DY') = 'FRI' THEN 'Jumat'
                       WHEN TO_CHAR (MIN (START_DATE), 'DY') = 'SAT' THEN 'Sabtu'
                    END
                       HARI,
                    TO_CHAR (MIN (START_DATE), 'DD/MM/YYYY') TANGGAL,
                    TO_CHAR (MIN (START_DATE), 'HH24:MI') START_TIME,
                    TO_CHAR (MAX (END_DATE), 'HH24:MI') END_TIME,
                    MAX (PLAN_COUNT) PLAN_COUNT
               FROM CBSLAM.VIERV_EQ_PLAN_COUNT A, (SELECT DISTINCT_SHIFT,
                                MAX (SHIFT) SHIFT,
                                COUNT (DISTINCT_SHIFT) JUM,
                                TO_CHAR (MIN (JAM), 'DD/MM/YYYY') MIN_TGL,
                                TO_CHAR (MAX (JAM), 'DD/MM/YYYY') MAX_TGL,
                                TO_CHAR (MIN (JAM), 'HH24') MIN_JAM,
                                TO_CHAR (MAX (JAM), 'HH24') MAX_JAM,
                                TO_CHAR (MAX (JAM + 1 / 24), 'HH24') MAX_END_JAM,
                                MIN (X) MIN_X,
                                MAX (X) MAX_X,
                                TO_CHAR (MIN (JAM), 'YYYY-MM-DD') MIN_TGL_2
                           FROM (SELECT 
                                X, 
                                TGL, 
                                TO_DATE(TO_CHAR(TGL, 'DD/MM/YYYY')||' '||JAM_STR, 'DD/MM/YYYY HH24:MI') JAM, 
                                TO_CHAR(TGL, 'DD/MM/YYYY') TGL_STR, 
                                JAM_STR, 
                                JAM_ID, SHIFT, DISTINCT_SHIFT
                                FROM (
                                SELECT X, 
                                CASE WHEN TGL=TRUNC(SYSDATE) THEN TO_DATE('{$date}', 'YYYY-MM-DD')
                                ELSE TO_DATE('{$date}', 'YYYY-MM-DD')+1
                                END TGL, 
                                JAM, TGL_STR, JAM_STR, JAM_ID, SHIFT, DISTINCT_SHIFT 
                                FROM CBSLAM.VIERV_EQ_PLAN_HOUR))
                       GROUP BY DISTINCT_SHIFT
                       ORDER BY DISTINCT_SHIFT) B
              WHERE     EQ_TYPE = 'REQ'
                    AND PLAN_DATE >= TO_DATE('{$date}', 'YYYY-MM-DD')
                    AND TO_DATE (
                           TO_CHAR (A.PLAN_DATE, 'DD/MM/YYYY') || ' ' || PLAN_TIME,
                           'DD/MM/YYYY HH24:MI') BETWEEN TO_DATE (
                                                            MIN_TGL || ' ' || MIN_JAM,
                                                            'DD/MM/YYYY HH24')
                                                     AND TO_DATE (
                                                            MAX_TGL || ' ' || MAX_JAM,
                                                            'DD/MM/YYYY HH24')
                                                            AND DISTINCT_SHIFT>0
           GROUP BY DISTINCT_SHIFT
           ORDER BY DISTINCT_SHIFT ASC";
        $data['data'] = DB::select($sql);
        return view('content.equipment_plan.print_spk', ['data' => $data]);
    }

    public function print($date, $manager, $planner)
    {
        $print = DB::select("SELECT MAX(PRINT_CODE) PRINT_CODE FROM CBSLAM.VIER_EQ_PLAN_TMP
                        WHERE TRUNC(PRINT_DATE)=TO_DATE('01-04-2022', 'DD-MM-YYYY')");

        if(count($print) > 0) {

            $tgl = DB::select("SELECT INITCAP(TO_CHAR(TGL, 'DY DD MON YYYY')) TGL, TGL_STR, COUNT(1) JUM 
                                FROM (
                                    SELECT CASE WHEN DISTINCT_SHIFT IN (0,1) THEN MIN_DATE
                                    ELSE MAX_DATE
                                    END TGL,
                                    TO_CHAR(CASE WHEN DISTINCT_SHIFT IN (0,1) THEN MIN_DATE
                                    ELSE MAX_DATE
                                    END, 'DD/MM/YYYY') TGL_STR
                                    FROM CBSLAM.VIERV_EQ_PLAN_HOUR A,
                                    (SELECT MIN(PLAN_DATE) MIN_DATE, MAX(PLAN_DATE) MAX_DATE FROM CBSLAM.VIER_EQ_PLAN_TMP
                                    WHERE PRINT_CODE='{$print[0]->print_code}') B
                                )
                                GROUP BY TGL_STR, TGL 
                                ORDER BY TO_DATE(TGL_STR, 'DD/MM/YYYY') ASC");

            $shift = DB::select("SELECT TGL, SHIFT, COUNT(SHIFT) JUM 
                FROM (SELECT CASE WHEN DISTINCT_SHIFT IN (0,1) THEN MIN_DATE
                    ELSE MAX_DATE
                    END TGL,
                    TO_CHAR(CASE WHEN DISTINCT_SHIFT IN (0,1) THEN MIN_DATE
                    ELSE MAX_DATE
                    END, 'DD/MM/YYYY') TGL_STR,
                    SHIFT,
                    DISTINCT_SHIFT
                    FROM CBSLAM.VIERV_EQ_PLAN_HOUR_ROSID A,
                    (SELECT MIN(PLAN_DATE) MIN_DATE, MAX(PLAN_DATE) MAX_DATE FROM CBSLAM.VIER_EQ_PLAN_TMP
                    WHERE PRINT_CODE='{$print[0]->print_code}') B)
                GROUP BY TGL, SHIFT
                ORDER BY TGL, SHIFT");

            $jam = DB::select("SELECT JAM_STR, JAM_ID, 
                    CASE WHEN DISTINCT_SHIFT IN (0,1) THEN MIN_DATE
                    ELSE MAX_DATE
                    END TGL,
                    TO_CHAR(CASE WHEN DISTINCT_SHIFT IN (0,1) THEN MIN_DATE
                    ELSE MAX_DATE
                    END, 'DD/MM/YYYY') TGL_STR,
                    SHIFT,
                    DISTINCT_SHIFT
                    FROM CBSLAM.VIERV_EQ_PLAN_HOUR A,
                    (SELECT MIN(PLAN_DATE) MIN_DATE, MAX(PLAN_DATE) MAX_DATE FROM CBSLAM.VIER_EQ_PLAN_TMP
                    WHERE PRINT_CODE='{$print[0]->print_code}') B");
            $sts_group = DB::select("SELECT VES_ID, TO_NUMBER(regexp_replace(EQ_ID, '[^0-9]', '')) ||SUBSTR (EQ_ID, -1) CRANE
                            FROM CBSLAM.VIER_EQ_PLAN_TMP
                            WHERE PRINT_CODE='{$print[0]->print_code}' 
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
                    WHERE A.VES_ID=B.VES_ID AND PRINT_CODE='{$print[0]->print_code}' 
                    ORDER BY MIN_DATE");

            $perhour = DB::select("SELECT * FROM CBSLAM.VIERV_EQ_PLAN_VES_PERHOUR_TMP WHERE PRINT_CODE='{$print[0]->print_code}'");

            $det_count = DB::table("CBSLAM.VIER_EQ_PLAN_COUNT_DEFAULT_TMP")->where('PRINT_CODE', $print[0]->print_code)->get();
            $det_now = DB::table("CBSLAM.VIER_EQ_PLAN_COUNT_TMP")->where('PRINT_CODE', $print[0]->print_code)->orderBy('X')->get();
            $det_truck = DB::table("CBSLAM.VIER_EQ_PLAN_COUNT_TMP")->where('PRINT_CODE', $print[0]->print_code)->orderBy('X')->get();
            $det_total = DB::table("CBSLAM.VIER_EQ_PLAN_COUNT_TMP")
                        ->where('PRINT_CODE', $print[0]->print_code)
                        ->where('EQ_TYPE', 'TOTAL')->orderBy('X')->get();
            $row_truck = DB::table("CBSLAM.VIERV_EQ_MONIC_TRUCK")->get();
            $kesiapan = DB::table("CBSLAM.VIER_EQ_PLAN_KESIAPAN_TMP")->where('PRINT_CODE', $print[0]->print_code)->get();

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
                $val['hours'] = [];
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

    }


    public function show_spk()
    {
        $data = [];
        $arrParam = [];

        if(isset($_GET['params'])) {

            $params = safeDecrypt(str_replace(' ', '+', $_GET['params']), 'P3lindoBer1');

            $arrParam = explode('|', $params);
        }


        $sql            = "SELECT * FROM CBSLAM.VIER_EQ_PRINT_SPK_TMP WHERE DISTINCT_SHIFT>0 AND PRINT_CODE='{$print[0]->print_code}'";
        $data['data']   = DB::select($sql);

        if(count($arrParam) == 5) {
            $data['param11']    = $arrParam[0];
            $data['param22']    = $arrParam[1];
            $data['datestart']  = getDefaultDate($arrParam[2]);
            $data['date']       = $arrParam[2];
            $data['no_doc']     = $arrParam[3];
            $data['code']       = $print[0]->print_code;
            $data['is_required']= true;
        }

        return view('content.mon_equipment_plan.print_spk', ['data' => $data]);
    }

}
