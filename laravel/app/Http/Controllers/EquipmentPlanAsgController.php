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

        $sql = "SELECT A.*, 0 HIDE FROM TOWER.TWR_MEMBER_GROUP A
                WHERE KD_GROUP=(SELECT KD_GROUP FROM TOWER.TWR_MEMBER_GROUP 
                WHERE NIPP='{$nipp}') 
                AND ID_OPERATOR_POSITION IN ('201', '63') 
                ORDER BY NAMA ASC";

        $operators = DB::select($sql);
        $kd_group = '';
        if(count($operators) > 0) {
            $kd_group = $operators[0]->kd_group;
        }

        $sql_default = " AND B.IS_DEFAULT(+)=1 ";
        $sql = "SELECT * FROM CBSLAM.VIER_EQP_ASSIGNMENT WHERE PLAN_DATE=TRUNC(SYSDATE)";
        $cur_asg = DB::select($sql);
        if(count($cur_asg) > 0) {
            $sql_default = " AND B.PLAN_DATE(+)=TRUNC(SYSDATE) ";
        }


        $sql = "SELECT A.*, NULL OPT, NULL OPT_IDX, B.NIPP 
                FROM VALAT_TTL@MONICLINK A, CBSLAM.VIER_EQP_ASSIGNMENT B
                WHERE KONDISI='R'
                AND JENIS IN ('CTT', 'TT', 'TB', 'HT') 
                {$sql_default} 
                AND A.KODE_ALAT=B.EQ_ID(+)
                AND B.KD_GROUP(+)='{$kd_group}' 
                AND OPR_VENDOR='PDS'";

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


        // echo json_encode($equipments);
        // echo "<br><br>";
        // echo json_encode($operators);
        // die();

        return response()->json([
            'success'   => true,
            'operators' => $operators,
            'equipments' => $equipments,
        ]);
    }

    public function save(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        $nipp = session('nipp');

        $sql = "SELECT * FROM TOWER.VW_TW_JADWAL
                WHERE KD_GROUP=(
                    SELECT KD_GROUP FROM TOWER.TWR_MEMBER_GROUP
                    WHERE NIPP='{$nipp}'
                ) AND JAM_AWAL>SYSDATE
                AND JAM_AKHIR<SYSDATE+16/24";

        $member = DB::select($sql);

        if(count($member) > 0) {

            if($request->is_default) {
                DB::table('CBSLAM.VIER_EQP_ASSIGNMENT')
                    ->where('IS_DEFAULT', 1)
                    ->update(['IS_DEFAULT' => 0]);
            }

            DB::table('CBSLAM.VIER_EQP_ASSIGNMENT')
                ->where('PLAN_DATE', '>=', date('Y-m-d'))
                ->where('KD_GROUP', $member[0]->kd_group)
                ->delete();
                
            $equipments = $request->equipments;
            $plan_type = $request->plan_type;
            $data = [];

            foreach ($equipments as $i => $val) {
                if($val['opt'] != null) {
                    $data[] = [
                        'PLAN_TYPE' => $plan_type,
                        'NIPP'      => $val['opt']['nipp'],
                        'EQ_ID'     => $val['kode_alat'],
                        'PLAN_DATE' => date('Y-m-d'),
                        'SHIFT'     => $member[0]->shift,
                        'KD_GROUP'  => $member[0]->kd_group,
                        'UPDATED_BY'=> session('data'),
                        'IS_DEFAULT'=> ($request->is_default?1:0)
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
