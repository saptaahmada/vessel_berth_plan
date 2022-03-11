<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class EqpAsgThemeController extends Controller
{
    public function index()
    {
        return view('content.eqp_asg_theme.view');
    }

    public function add()
    {
        return view('content.eqp_asg_theme.add');
    }

    public function update($theme_name)
    {
        return view('content.eqp_asg_theme.update', ['theme_name' => $theme_name]);
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

        $sql = "SELECT A.*, NULL OPT, NULL OPT_IDX, NULL NIPP 
                FROM MONIC.VALAT_TTL@MONICLINK A
                WHERE OPR_VENDOR='{$plan_type}'";

        $equipments = DB::select($sql);

        return response()->json([
            'success'   => true,
            'operators' => $operators,
            'equipments' => $equipments,
        ]);
    }

    public function getDataUpdate(Request $request)
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

        $sql = "SELECT A.*, NULL OPT, NULL OPT_IDX, B.NIPP 
                FROM MONIC.VALAT_TTL@MONICLINK A,
                CBSLAM.VIER_EQP_ASG_THEME B
                WHERE OPR_VENDOR='{$request->plan_type}'
                AND A.KODE_ALAT=B.EQ_ID(+)
                AND THEME_NAME(+)='{$request->theme_name}' 
                ORDER BY A.KODE_ALAT";

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
            'sql'   => $sql
        ]);
    }

    public function addProcess(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        $nipp = session('nipp');

        $sql = "SELECT * FROM TOWER.TWR_MEMBER_GROUP WHERE NIPP='{$nipp}'";
        $member = DB::select($sql);

        if(count($member) > 0) {

            if($request->plan_type == 'PDS') {
                $kd_group = $member[0]->kd_group;
            } else {
                $kd_group = 'Z';
            }

            $equipments = $request->equipments;
            $plan_type  = $request->plan_type;
            $theme_name = $request->theme_name;

            $sql = "SELECT * FROM CBSLAM.VIER_EQP_ASG_THEME WHERE THEME_NAME='{$theme_name}'";
            $theme = DB::select($sql);
            
            if(count($theme) <= 0) {
                $data = [];

                foreach ($equipments as $i => $val) {
                    if($val['opt'] != null) {
                        $data[] = [
                            'PLAN_TYPE' => $plan_type,
                            'NIPP'      => $val['opt']['nipp'],
                            'EQ_ID'     => $val['kode_alat'],
                            'KD_GROUP'  => $kd_group,
                            'THEME_NAME'=> $theme_name,
                            'UPDATED_BY'=> session('data'),
                        ];
                    }
                }
                
                $res = DB::table('CBSLAM.VIER_EQP_ASG_THEME')->insert($data);

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
                    'message'   => 'Nama Template sudah ada, atau sudah dipakai oleh grup lain'
                ]);
            }

        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Anda tidak punya akses'
            ]);
        }

    }

    public function updateProcess(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        $nipp = session('nipp');

        $sql = "SELECT * FROM TOWER.TWR_MEMBER_GROUP WHERE NIPP='{$nipp}'";
        $member = DB::select($sql);

        if(count($member) > 0) {
            if($request->plan_type == 'PDS') {
                $kd_group = $member[0]->kd_group;
            } else {
                $kd_group = 'Z';
            }

            $equipments = $request->equipments;
            $plan_type  = $request->plan_type;
            $theme_name = $request->theme_name;
            $theme_name_old = $request->theme_name_old;

            $sql = "SELECT * FROM CBSLAM.VIER_EQP_ASG_THEME WHERE THEME_NAME='{$theme_name}'";
            $theme = DB::select($sql);

            if($theme_name == $theme_name_old) {
                $theme = [];
            }
            
            if(count($theme) <= 0) {

                DB::table('CBSLAM.VIER_EQP_ASG_THEME')
                    ->where('KD_GROUP', $kd_group)
                    ->where('THEME_NAME', $theme_name)
                    ->delete();

                $data = [];

                foreach ($equipments as $i => $val) {
                    if($val['opt'] != null) {
                        $data[] = [
                            'PLAN_TYPE' => $plan_type,
                            'NIPP'      => $val['opt']['nipp'],
                            'EQ_ID'     => $val['kode_alat'],
                            'KD_GROUP'  => $kd_group,
                            'THEME_NAME'=> $theme_name,
                            'UPDATED_BY'=> session('data'),
                        ];
                    }
                }
                
                $res = DB::table('CBSLAM.VIER_EQP_ASG_THEME')->insert($data);

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
                    'message'   => 'Nama Template sudah ada, atau sudah dipakai oleh grup lain'
                ]);
            }

        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Anda tidak punya akses'
            ]);
        }

    }

    public function remove(Request $request)
    {
        $res = DB::table('CBSLAM.VIER_EQP_ASG_THEME')
                ->where('PLAN_TYPE', $request->plan_type)
                ->where('THEME_NAME', $request->theme_name)
                ->delete();
        if($res) {
            return response()->json([
                'success'   => true,
                'message'   => 'Success'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal'
            ]);
        }
    }

    public function getMyTheme(Request $request)
    {
        $nipp = session('nipp');
        $sql = "SELECT * FROM TOWER.TWR_MEMBER_GROUP WHERE NIPP='{$nipp}'";
        $member = DB::select($sql);

        if($request->plan_type == 'PDS') {
            $kd_group = $member[0]->kd_group;
        } else {
            $kd_group = 'Z';
        }

        $data = Db::table('CBSLAM.VIERV_EQP_ASG_THEME_H')
                    ->where('PLAN_TYPE', $request->plan_type)
                    ->where('KD_GROUP', $kd_group)
                    ->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Success',
            'data'      => $data
        ]);
    }

    public function json(){
        $nipp = session('nipp');
        $plan_type = session('plan_type');

        $sql = "SELECT * FROM TOWER.TWR_MEMBER_GROUP WHERE NIPP='{$nipp}'";

        $member = DB::select($sql);

        if($plan_type == 'PDS') {
            $kd_group = $member[0]->kd_group;
        } else {
            $kd_group = 'Z';
        }

        return DataTables::of(
            Db::table('CBSLAM.VIERV_EQP_ASG_THEME_H')
            ->where('PLAN_TYPE', session('plan_type'))
            ->where('KD_GROUP', $kd_group)
            ->get()
        )->make(true);
    }
}
