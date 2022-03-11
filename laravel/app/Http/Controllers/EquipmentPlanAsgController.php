<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class EquipmentPlanAsgController extends Controller
{
    public function index()
    {
        return view('content.equipment_plan_asg.view');
    }

    public function getData(Request $request)
    {
        $nipp = session('nipp');
        $plan_type = session('plan_type');

        if($plan_type == 'PDS') {
            $sql_group = "SELECT KD_GROUP FROM TOWER.TWR_MEMBER_GROUP WHERE NIPP='{$nipp}'";
        } else {
            $sql_group = "'Z'";
        }

        $sql = "SELECT A.*, 0 HIDE FROM TOWER.TWR_MEMBER_GROUP A
                WHERE KD_GROUP=({$sql_group}) 
                AND ID_OPERATOR_POSITION IN ('201', '63') 
                ORDER BY NAMA ASC";

        $operators = DB::select($sql);
        $kd_group = '';
        if(count($operators) > 0) {
            $kd_group = $operators[0]->kd_group;
        }

        $sql = "SELECT * FROM CBSLAM.VIERV_EQ_PLAN_COUNT_JADWAL
                WHERE START_DATE>=SYSDATE
                AND KD_GROUP='{$kd_group}'";

        $jadwal = DB::select($sql);

        if(count($jadwal) > 0 || $plan_type == 'BDS') { 
            if($request->theme_name != '' && $request->theme_name != null) {
                $sql = "SELECT A.*, NULL OPT, NULL OPT_IDX, B.NIPP 
                        FROM MONIC.VALAT_TTL@MONICLINK A,
                        CBSLAM.VIER_EQP_ASG_THEME B
                        WHERE OPR_VENDOR='{$request->plan_type}'
                        AND A.KODE_ALAT=B.EQ_ID(+)
                        AND THEME_NAME(+)='{$request->theme_name}' 
                        ORDER BY A.KODE_ALAT";
            } else {
                if(count($jadwal) > 0) {
                    $sql_plan_date = " AND TO_CHAR(PLAN_DATE(+), 'DD/MM/YYYY')='{$jadwal[0]->tanggal}' ";
                } else {
                    $sql_plan_date = " AND TO_CHAR(PLAN_DATE(+), 'DD/MM/YYYY')='{$request->shift_min_max['min_tgl']}'
                    AND SHIFT(+)='{$request->shift_min_max['shift']}' ";
                }
                $sql = "SELECT A.*, NULL OPT, NULL OPT_IDX, B.NIPP 
                        FROM VALAT_TTL@MONICLINK A, CBSLAM.VIER_EQP_ASSIGNMENT B
                        WHERE JENIS IN ('CTT', 'TT', 'TB', 'HT') 
                        AND A.KODE_ALAT=B.EQ_ID(+)
                        AND B.KD_GROUP(+)='{$kd_group}' 
                        AND OPR_VENDOR='{$request->plan_type}' 
                        {$sql_plan_date} 
                        ORDER BY A.KODE_ALAT";
            }

            $equipments = DB::select($sql);

            foreach ($equipments as $i => $val) {
                foreach ($operators as $o => $opt) {
                    if($val->nipp == $opt->nipp) {
                        $equipments[$i]->opt = $opt;
                        $equipments[$i]->opt_idx = $o;
                        $operators[$o]->hide = 1;
                    }
                }
            }

            return response()->json([
                'success'   => true,
                'operators' => $operators,
                'equipments' => $equipments,
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => "belum waktunya anda mengisi assignment"
            ]);
        }

    }

    public function save(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        $nipp = session('nipp');

        $sql = "SELECT A.*, TO_CHAR (A.TGL, 'yyyy-mm-dd') TANGGAL_2 FROM TOWER.VW_TW_JADWAL A
                WHERE KD_GROUP=(
                    SELECT KD_GROUP FROM TOWER.TWR_MEMBER_GROUP
                    WHERE NIPP='{$nipp}'
                ) AND JAM_AWAL>SYSDATE-8/24
                AND JAM_AWAL<SYSDATE+16/24 
                ORDER BY JAM_AWAL ASC";

        $jadwal = DB::select($sql);
        if(count($jadwal) > 0 && $request->plan_type == 'PDS') {
            $kd_group   = $jadwal[0]->kd_group;
            $shift      = $jadwal[0]->shift;
            $tanggal_2  = $jadwal[0]->tanggal_2;
        } else {
            $kd_group   = 'Z';
            $shift      = $request->shift_min_max['shift'];
            $tanggal_2  = $request->shift_min_max['min_tgl_2'];
        }

        if(count($jadwal) > 0 || $request->plan_type == 'BDS') {

            DB::table('CBSLAM.VIER_EQP_ASSIGNMENT')
                ->where('PLAN_DATE', '>=', $tanggal_2)
                ->where('KD_GROUP', $kd_group)
                ->where('SHIFT', $shift)
                ->delete();
                
            $equipments = $request->equipments;
            $plan_type  = $request->plan_type;
            $data       = [];

            foreach ($equipments as $i => $val) {
                if($val['opt'] != null) {
                    $data[] = [
                        'PLAN_TYPE' => $plan_type,
                        'NIPP'      => $val['opt']['nipp'],
                        'EQ_ID'     => $val['kode_alat'],
                        'PLAN_DATE' => $tanggal_2,
                        'SHIFT'     => $shift,
                        'KD_GROUP'  => $kd_group,
                        'UPDATED_BY'=> session('data'),
                    ];
                }
            }
            
            $res = DB::table('CBSLAM.VIER_EQP_ASSIGNMENT')->insert($data);

            if($res) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'Success'
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'Failed'
                ]);
            }

        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Belum waktunya anda mengisi assignment'
            ]);
        }


    }

}
