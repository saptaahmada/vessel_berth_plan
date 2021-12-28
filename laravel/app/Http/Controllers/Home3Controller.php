<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use DB;
use PDF;
use Session;
use App\Blokirkade;
use App\Note;
use DataTables;


class Home3Controller extends Controller
{

    public function index()
    {
        return view('content.printplan');
    }

    public function parking()
    {
        return view('content.berthplan3');
    }

    public function parkingbackup()
    {
        set_time_limit(60000);
        $blokirkade = Blokirkade::where('PARAM1', 'BLOKIR_KADE')->get();
        return view('content.berthplan3', compact("blokirkade"));
    }

    public function getdermaga() 
    {
        set_time_limit(60000);
        $vessel = DB::table('CBSLAM.CBS_VESSEL_MASTER_PLAN')-> get();
        $dry = [];
        $con = [];

        foreach ($vessel as $key => $val) {
            if($val->ves_type == 'GC') {
                $dry[] = $val;
            } else if($val->ves_type == 'CT') {
                $con[] = $val;
            }
        }

        $dermaga = [
            'Dry' => $dry,
            'Con'=> $con,
        ];

        echo json_encode($dermaga);

    }

    public function getvessel(Request $request)
    {
        set_time_limit(60000);
        $vessel = DB::table('CBSLAM.CBS_VESSEL_PLANNING')-> get();

        $dataIntern = [];
        $dataDomes = [];
        $dataCurah = [];

        foreach ($vessel as $key => $val) {
            if($val->ocean_interisland_fake == 'I') {
                $dataIntern[] = $val;
            } else if($val->ocean_interisland_fake == 'D') {
                $dataDomes[] = $val;
            } else if($val->ocean_interisland_fake == 'C') {
                $dataCurah[] = $val;
            }
        }

        $note = DB::table('CBSLAM.VIERV_NOTE')->get();

        $note_d = [];
        $note_i = [];
        $note_c = [];

        foreach ($note as $key => $val) {
            if($val->ocean_interisland == 'D')
                $note_d[] = $val;
            else if($val->ocean_interisland == 'I')
                $note_i[] = $val;
            else if($val->ocean_interisland == 'C')
                $note_c[] = $val;
        }

        $data = [
            'Intern' => $dataIntern,
            'Domes' => $dataDomes,
            'Curah' => $dataCurah,
            'note' => $note,
            'note_d' => $note_d,
            'note_i' => $note_i,
            'note_c' => $note_c,
        ];

        echo json_encode($data);

        // return response()->json($data);
    }

    public function addvessel(Request $request)
    {
        $dataIntern = DB::table('CBSLAM.CBS_VESSEL_MASTER_PLAN')
        -> where('ves_id',$request->param_data)
        -> get();

        $param1=$request->param_crane;

        echo json_encode($dataIntern);
    }

    public function save2(Request $request)
    {
        $arr_vess = $request->param_vess;
        $arr_removed = $request->param_vess_removed;

        // echo json_encode($arr_vess['Intern']);
        // die();

        // $act_berth_ts = "";
        // $act_dep_ts
        // $act_dep_ts_ori
        // $agent
        // $agent_mobile
        // $agent_name
        // $bch
        // $berth_fr_metre
        // $berth_fr_metre_ori
        // $berth_to_metre
        // $berth_to_metre_ori
        // $box_act
        // $box_plan
        // $box_remain
        // $bsh
        // $btoa_side
        // $crane
        // $dest_port
        // $disc_act
        // $disc_plan
        // $disc_remain
        // $doco_cutoff_ts
        // $est_anchorage_ts
        // $est_berth_ts
        // $est_dep_ts
        // $est_disch
        // $est_discharge
        // $est_end_date
        // $est_end_work_ts
        // $est_load
        // $est_pilot_ts
        // $est_start_work_ts
        // $height
        // $height_est
        // $image
        // $info
        // $in_voyage
        // $is_inserted
        // $is_prev_day
        // $is_simulation
        // $is_unreg
        // $load_act
        // $load_plan
        // $load_remain
        // $next_port
        // $ocean_interisland
        // $ocean_interisland_fake
        // $out_voyage
        // $real_disch
        // $real_load
        // $recv_cargo_cutoff_ts
        // $recv_ctr_cutoff_ts
        // $req_berth_ts
        // $tentatif
        // $time_remain
        // $time_remain_label
        // $ves_code
        // $ves_id
        // $ves_id_old
        // $ves_name
        // $ves_service
        // $ves_type
        // $width
        // $width_ori
        // $windows
        // $y_akhir
        // $y_akhir_est
        // $y_awal

        echo "'".json_encode(['vess' => $arr_vess, 'removed' => $arr_removed])."'";
        // return response()->json(["sukses"=> true ]);

    }

    private function updateReqBerthPlanned($vessel)
    {
        if(isset($vessel['id_req_berth'])) {
            if($vessel['id_req_berth'] != null || $vessel['id_req_berth'] != '' || $vessel['id_req_berth'] != 'null') {
                DB::table('CBSLAM.VIER_REQ_BERTH')
                ->where('ID', $vessel['id_req_berth'])
                ->update([
                    'IS_PLANNED'    => 1,
                    'UPDATED_BY'    => 'SYSTEM',
                ]);
            }
        }
    }

    public function delete_one(Request $request)
    {
        $vessel = $request->vessel;
        $isSuccess = DB::table('CBSLAM.VESSEL_DETAILS_SIM')
            ->where('ves_id', $vessel['ves_id_old'] ? $vessel['ves_id_old'] : '')
            ->delete();

        if($isSuccess) $this->updateReqBerthPlanned($vessel);

        return response()->json([
            'success' => true,
            'message' => 'Delete success'
        ]);
    }

    public function save_one(Request $request)
    {
        $null_date = '1900-12-21 23:00:00';

        $vessel = $request->vessel;

        $isSuccess = false;

        if(isset($vessel['is_inserted'])) {
            if($vessel['is_inserted'] == 1) {
                $data_update = [
                    'berth_fr_metre'        => $vessel['berth_fr_metre_ori'],
                    'berth_to_metre'        => $vessel['berth_to_metre_ori'],
                    'ves_id'                => $vessel['ves_id'],
                    'ves_name'              => $vessel['ves_name'],
                    'ves_service'           => $vessel['ves_service'],
                    'ocean_interisland'     => $vessel['ocean_interisland'],
                    'ocean_interisland_fake'=> $request->ocean_interisland,
                    'EST_PILOT_TS'          => $vessel['est_pilot_ts'] != null ? 
                                                $vessel['est_pilot_ts'] : $null_date,
                    'REQ_BERTH_TS'          => $vessel['req_berth_ts'] != null ? 
                                                $vessel['req_berth_ts'] : $null_date,
                    'est_berth_ts'          => $vessel['est_berth_ts'],
                    'est_dep_ts'            => $vessel['est_dep_ts'],
                    'CRANE'                 => (implode(",", isset($vessel['crane'])?$vessel['crane']:[])),
                    'BCH'                   => $vessel['bsh'],
                    'BSH'                   => $vessel['bsh'],
                    'NEXT_PORT'             =>$vessel['next_port'],
                    'DEST_PORT'             => $vessel['dest_port'],
                    'EST_LOAD'              => $vessel['est_load'],
                    'EST_DISCHARGE'         => $vessel['est_discharge'],
                    'BTOA_SIDE'             => $vessel['btoa_side'],
                    'WINDOWS'               => $vessel['windows'],
                    'INFO'                  => str_replace("\n", "<br>", $vessel['info']),
                    'TENTATIF'              => $vessel['tentatif'],
                    'CRANE_DENSITY'         => $vessel['crane_density'],
                ];

                $isSuccess = DB::table('CBSLAM.VESSEL_DETAILS_SIM')
                ->where('ves_id', $vessel['ves_id_old'])
                ->update($data_update);

            } else {
                DB::table('CBSLAM.VESSEL_DETAILS_SIM')->where('ves_id', $vessel['ves_id_old'])->delete();

                $data_push = [
                    'berth_fr_metre'        => $vessel['berth_fr_metre_ori'],
                    'berth_to_metre'        => $vessel['berth_to_metre_ori'],
                    'ves_id'                => $vessel['ves_id'],
                    'ves_name'              => $vessel['ves_name'],
                    'ves_code'              => $vessel['ves_code'],
                    'ves_service'           => $vessel['ves_service'],
                    'call_sign'             => (isset($vessel['call_sign']) ? $vessel['call_sign'] : '-'),
                    'mdm_kode_kapal'        => (isset($vessel['mdm_kode_kapal']) ? $vessel['mdm_kode_kapal'] : '-'),
                    'ocean_interisland'     => $vessel['ocean_interisland'],
                    'ocean_interisland_fake'=> $request->ocean_interisland,
                    'EST_PILOT_TS'          => $vessel['est_pilot_ts'] != null ? 
                                                $vessel['est_pilot_ts'] : $null_date,
                    'REQ_BERTH_TS'          => $vessel['req_berth_ts'] != null ? 
                                                $vessel['req_berth_ts'] : $null_date,
                    'est_berth_ts'          => $vessel['est_berth_ts'],
                    'est_dep_ts'            => $vessel['est_dep_ts'],
                    'EST_ANCHORAGE_TS'      => $null_date,
                    'EST_START_WORK_TS'     => $null_date,
                    'EST_END_WORK_TS'       => $null_date,
                    'ACT_DEP_TS'            => $null_date,
                    'ACT_ANCHORAGE_TS'      => $null_date,
                    'ACT_PILOT_TS'          => $null_date,
                    'ACT_BERTH_TS'          => $null_date,
                    'ACT_START_WORK_TS'     => $null_date,
                    'ACT_END_WORK_TS'       => $null_date,
                    'DOCO_CUTOFF_TS'        => $null_date,
                    'RECV_CTR_CUTOFF_TS'    => $null_date,
                    'RECV_CARGO_CUTOFF_TS'  => $null_date,
                    'AGENT'                 => $vessel['agent'],
                    'IS_SIMULATION'         => $vessel['is_simulation'],
                    'CRANE'                 => (implode(",", isset($vessel['crane'])?$vessel['crane']:[])),
                    'BCH'                   => $vessel['bsh'],
                    'BSH'                   => $vessel['bsh'],
                    'NEXT_PORT'             => $vessel['next_port'],
                    'DEST_PORT'             => $vessel['dest_port'],
                    'EST_LOAD'              => $vessel['est_load'],
                    'EST_DISCHARGE'         => $vessel['est_discharge'],
                    'BTOA_SIDE'             => $vessel['btoa_side'],
                    'WINDOWS'               => $vessel['windows'],
                    // 'INFO'                  => $vessel['info'],
                    'INFO'                  => str_replace("\n", "<br>", $vessel['info']),
                    'TENTATIF'              => $vessel['tentatif'],
                    'IS_UNREG'              => $vessel['is_unreg'],
                    'CRANE_DENSITY'         => $vessel['crane_density'],
                ];
                
                $isSuccess = DB::table('CBSLAM.VESSEL_DETAILS_SIM')->insert($data_push);

            }
        }

        if($isSuccess) $this->updateReqBerthPlanned($vessel);

        return response()->json([
            'success' => $isSuccess,
            'message' => ($isSuccess ? 'Success' : 'Trouble system, try again...')
        ]);
    }

    public function save_note_one(Request $request)
    {
        $note = $request->note;

        $res = DB::table('CBSLAM.VESSEL_DETAILS_NOTE')->where('CODE', $note['code'])->delete();
        $isSuccess = DB::table('CBSLAM.VESSEL_DETAILS_NOTE')->insert([
            'CODE'              => $note['code'], 
            'HEIGHT'            => $note['height'], 
            'OCEAN_INTERISLAND' => $note['ocean_interisland'], 
            'START_DATE'        => date('Y-m-d'), 
            'TEXT'              => $note['text'], 
            'WIDTH'             => $note['width'], 
            'X'                 => $note['x'], 
            'Y'                 => $note['y']
        ]);
        return response()->json([
            'success' => $isSuccess,
            'message' => ($isSuccess ? 'Success' : 'Trouble system, try again...')
        ]);
    }

    public function delete_note_one(Request $request)
    {
        $note = $request->note;
        $isSuccess = DB::table('CBSLAM.VESSEL_DETAILS_NOTE')
            ->where('CODE', $note['code'])
            ->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete success'
        ]);
    }
    
    public function save(Request $request)
    {
        set_time_limit(60000);
        $arr_vess = $request->param_vess;

        if($request->param_vess_removed != null)
            foreach ($request->param_vess_removed as $i => $val)
                DB::table('CBSLAM.VESSEL_DETAILS_SIM')->where('ves_id', $val['ves_id_old'])->delete();

        DB::table('CBSLAM.VESSEL_DETAILS_CRANE')
        ->whereDate('CREATED_DATE', '>=', date('Y-m-d'))
        ->delete();

        $this->saveProcess($arr_vess, 'Domes', 'note_d', 'D');
        $this->saveProcess($arr_vess, 'Intern', 'note_i', 'I');
        $this->saveProcess($arr_vess, 'Curah', 'note_c', 'C');

        return response()->json(["sukses"=> true ]);

    }

    public function saveProcess($arr_vess, $var, $var_note, $ocean_interisland)
    {
        $null_date = '1900-12-21 23:00:00';

        if(isset($arr_vess[$var])) {

            $param_vess = $arr_vess[$var];
            $data_crane = [];
            $data_vessel = [];

            foreach ($param_vess as $i => $val) {

                if(isset($param_vess[$i]['crane']))
                    $craneparam = ($param_vess[$i]['crane']);
                else
                    $craneparam = [];

                if (is_array($craneparam)) 
                    $crane_string = implode(",", $craneparam);
                else 
                    $crane_string = $craneparam;

                $savecrane = explode(",", $crane_string);

                $data_update = [
                    'berth_fr_metre'        => $param_vess[$i]['berth_fr_metre_ori'],
                    'berth_to_metre'        => $param_vess[$i]['berth_to_metre_ori'],
                    'ves_id'                => $param_vess[$i]['ves_id'],
                    'ves_name'              => $param_vess[$i]['ves_name'],
                    'ocean_interisland'     => $param_vess[$i]['ocean_interisland'],
                    'ocean_interisland_fake'=> $ocean_interisland,
                    'EST_PILOT_TS'          => $param_vess[$i]['est_pilot_ts'] != null ? 
                                                $param_vess[$i]['est_pilot_ts'] : $null_date,
                    'REQ_BERTH_TS'          => $param_vess[$i]['req_berth_ts'] != null ? 
                                                $param_vess[$i]['req_berth_ts'] : $null_date,
                    'est_berth_ts'          => $param_vess[$i]['est_berth_ts'],
                    'est_dep_ts'            => $param_vess[$i]['est_dep_ts'],
                    'CRANE'                 => $crane_string,
                    'BCH'                   => $param_vess[$i]['bsh'],
                    'BSH'                   => $param_vess[$i]['bsh'],
                    'NEXT_PORT'             =>$param_vess[$i]['next_port'],
                    'DEST_PORT'             => $param_vess[$i]['dest_port'],
                    'EST_LOAD'              => $param_vess[$i]['est_load'],
                    'EST_DISCHARGE'         => $param_vess[$i]['est_discharge'],
                    'BTOA_SIDE'             => $param_vess[$i]['btoa_side'],
                    'WINDOWS'               => $param_vess[$i]['windows'],
                    // 'INFO'                  => $param_vess[$i]['info'],
                    'INFO'                  => str_replace("\n", "<br>", $param_vess[$i]['info']),
                    'TENTATIF'              => $param_vess[$i]['tentatif'],
                ];

                $data_push = [
                    'berth_fr_metre'        => $param_vess[$i]['berth_fr_metre_ori'],
                    'berth_to_metre'        => $param_vess[$i]['berth_to_metre_ori'],
                    'ves_id'                => $param_vess[$i]['ves_id'],
                    'ves_name'              => $param_vess[$i]['ves_name'],
                    'ves_code'              => $param_vess[$i]['ves_code'],
                    'ocean_interisland'     => $param_vess[$i]['ocean_interisland'],
                    'ocean_interisland_fake'=> $ocean_interisland,
                    'EST_PILOT_TS'          => $param_vess[$i]['est_pilot_ts'] != null ? 
                                                $param_vess[$i]['est_pilot_ts'] : $null_date,
                    'REQ_BERTH_TS'          => $param_vess[$i]['req_berth_ts'] != null ? 
                                                $param_vess[$i]['req_berth_ts'] : $null_date,
                    'est_berth_ts'          => $param_vess[$i]['est_berth_ts'],
                    'est_dep_ts'            => $param_vess[$i]['est_dep_ts'],
                    'EST_ANCHORAGE_TS'      => $null_date,
                    'EST_START_WORK_TS'     => $null_date,
                    'EST_END_WORK_TS'       => $null_date,
                    'ACT_DEP_TS'            => $null_date,
                    'ACT_ANCHORAGE_TS'      => $null_date,
                    'ACT_PILOT_TS'          => $null_date,
                    'ACT_BERTH_TS'          => $null_date,
                    'ACT_START_WORK_TS'     => $null_date,
                    'ACT_END_WORK_TS'       => $null_date,
                    'DOCO_CUTOFF_TS'        => $null_date,
                    'RECV_CTR_CUTOFF_TS'    => $null_date,
                    'RECV_CARGO_CUTOFF_TS'  => $null_date,
                    'AGENT'                 => $param_vess[$i]['agent'],
                    'IS_SIMULATION'         => $param_vess[$i]['is_simulation'],
                    'CRANE'                 => $crane_string,
                    'BCH'                   => $param_vess[$i]['bsh'],
                    'BSH'                   => $param_vess[$i]['bsh'],
                    'NEXT_PORT'             =>$param_vess[$i]['next_port'],
                    'DEST_PORT'             => $param_vess[$i]['dest_port'],
                    'EST_LOAD'              => $param_vess[$i]['est_load'],
                    'EST_DISCHARGE'         => $param_vess[$i]['est_discharge'],
                    'BTOA_SIDE'             => $param_vess[$i]['btoa_side'],
                    'WINDOWS'               => $param_vess[$i]['windows'],
                    // 'INFO'                  => $param_vess[$i]['info'],
                    'INFO'                  => str_replace("\n", "<br>", $param_vess[$i]['info']),
                    'TENTATIF'              => $param_vess[$i]['tentatif'],
                    'IS_UNREG'              => $param_vess[$i]['is_unreg'],
                ];


                if(isset($param_vess[$i]['is_prev_day'])) {
                    if($param_vess[$i]['is_prev_day'] == 0) {
                        $data_update['est_berth_ts'] = $param_vess[$i]['est_berth_ts'];
                    } else {
                        DB::table('CBSLAM.VESSEL_DETAILS_CRANE')
                        ->where('ves_id', $param_vess[$i]['ves_id'])
                        ->delete();
                    }
                }

                for ($a=0 ; $a < count($savecrane); $a++){
                    $data_crane[] = [
                        'ves_id' =>  $param_vess[$i]['ves_id'],
                        'che_id' => $savecrane[$a]
                    ];
                }

                if(isset($param_vess[$i]['is_inserted'])) {
                    if($param_vess[$i]['is_inserted'] == 1) {
                        DB::table('CBSLAM.VESSEL_DETAILS_SIM')
                        ->where('ves_id', $param_vess[$i]['ves_id_old'])
                        ->update($data_update);
                    } else {
                        $data_vessel[] = $data_push;
                        // DB::table('CBSLAM.VESSEL_DETAILS_SIM')->insert($data_push);
                    }
                } else {
                    $data_vessel[] = $data_push;
                    // DB::table('CBSLAM.VESSEL_DETAILS_SIM')->insert($data_push);
                }

            }

            DB::table('CBSLAM.VESSEL_DETAILS_CRANE')->insert($data_crane);
            DB::table('CBSLAM.VESSEL_DETAILS_SIM')->insert($data_vessel);
        }

        Note::where(DB::raw("(Y+(TRUNC(START_DATE)-TRUNC(SYSDATE))*480)"), '>=', "0")
        ->where('OCEAN_INTERISLAND', $ocean_interisland)->delete();

        if(isset($arr_vess[$var_note])) {
            if($arr_vess[$var_note] != null) {
                foreach ($arr_vess[$var_note] as $i => $val) {
                    $val['start_date'] = date('Y-m-d H:i');
                    Note::insert($val);
                }
            }
        }
    }


    public function updatevessel(Request $request)
    {
        $param_vess = $request->param_vess;

        if ($param_vess == null)
            $count = 0;
        else
            $count = count($param_vess);

        $null_date = '1900-12-21 23:00:00';

        DB::table('CBSLAM.VESSEL_DETAILS_SIM')
            ->where('IS_SIMULATION', '1')
            ->where('OCEAN_INTERISLAND_FAKE', $request->param_ocean)
            ->delete();


        if($request->param_vess_removed != null)
            foreach ($request->param_vess_removed as $i => $val)
                DB::table('CBSLAM.VESSEL_DETAILS_SIM')->where('ves_id', $val['ves_id'])->delete();


        for ($i=0 ; $i < $count; $i++){

            if(isset($param_vess[$i]['crane']))
                $craneparam = ($param_vess[$i]['crane']);
            else
                $craneparam = [];

            if (is_array($craneparam)) 
                $crane_string = implode(",", $craneparam);
            else 
                $crane_string = $craneparam;

            $savecrane = explode(",", $crane_string);


            $data_update = [
                'berth_fr_metre'        => $param_vess[$i]['berth_fr_metre_ori'],
                'berth_to_metre'        => $param_vess[$i]['berth_to_metre_ori'],
                'ves_id'                => $param_vess[$i]['ves_id'],
                'ves_name'              => $param_vess[$i]['ves_name'],
                'ocean_interisland'     => $param_vess[$i]['ocean_interisland'],
                'ocean_interisland_fake'=> $request->param_ocean,
                'EST_PILOT_TS'          => $param_vess[$i]['est_pilot_ts'] != null ? 
                                            $param_vess[$i]['est_pilot_ts'] : $null_date,
                'REQ_BERTH_TS'          => $param_vess[$i]['req_berth_ts'] != null ? 
                                            $param_vess[$i]['req_berth_ts'] : $null_date,
                'est_berth_ts'          => $param_vess[$i]['est_berth_ts'],
                'est_dep_ts'            => $param_vess[$i]['est_dep_ts'],
                'CRANE'                 => $crane_string,
                'BCH'                   => $param_vess[$i]['bsh'],
                'BSH'                   => $param_vess[$i]['bsh'],
                'NEXT_PORT'             =>$param_vess[$i]['next_port'],
                'DEST_PORT'             => $param_vess[$i]['dest_port'],
                'EST_LOAD'              => $param_vess[$i]['est_load'],
                'EST_DISCHARGE'         => $param_vess[$i]['est_discharge'],
                'BTOA_SIDE'             => $param_vess[$i]['btoa_side'],
                'WINDOWS'               => $param_vess[$i]['windows'],
                'INFO'                  => $param_vess[$i]['info'],
                'TENTATIF'              => $param_vess[$i]['tentatif'],
            ];

            $data_push = [
                'berth_fr_metre'        => $param_vess[$i]['berth_fr_metre_ori'],
                'berth_to_metre'        => $param_vess[$i]['berth_to_metre_ori'],
                'ves_id'                => $param_vess[$i]['ves_id'],
                'ves_name'              => $param_vess[$i]['ves_name'],
                'ves_code'              => $param_vess[$i]['ves_code'],
                'ocean_interisland'     => $param_vess[$i]['ocean_interisland'],
                'ocean_interisland_fake'=> $request->param_ocean,
                'EST_PILOT_TS'          => $param_vess[$i]['est_pilot_ts'] != null ? 
                                            $param_vess[$i]['est_pilot_ts'] : $null_date,
                'REQ_BERTH_TS'          => $param_vess[$i]['req_berth_ts'] != null ? 
                                            $param_vess[$i]['req_berth_ts'] : $null_date,
                'est_berth_ts'          => $param_vess[$i]['est_berth_ts'],
                'est_dep_ts'            => $param_vess[$i]['est_dep_ts'],
                'EST_ANCHORAGE_TS'      => $null_date,
                'EST_START_WORK_TS'     => $null_date,
                'EST_END_WORK_TS'       => $null_date,
                'ACT_DEP_TS'            => $null_date,
                'ACT_ANCHORAGE_TS'      => $null_date,
                'ACT_PILOT_TS'          => $null_date,
                'ACT_BERTH_TS'          => $null_date,
                'ACT_START_WORK_TS'     => $null_date,
                'ACT_END_WORK_TS'       => $null_date,
                'DOCO_CUTOFF_TS'        => $null_date,
                'RECV_CTR_CUTOFF_TS'    => $null_date,
                'RECV_CARGO_CUTOFF_TS'  => $null_date,
                'AGENT'                 => $param_vess[$i]['agent'],
                'IS_SIMULATION'         => $param_vess[$i]['is_simulation'],
                'CRANE'                 => $crane_string,
                'BCH'                   => $param_vess[$i]['bsh'],
                'BSH'                   => $param_vess[$i]['bsh'],
                'NEXT_PORT'             =>$param_vess[$i]['next_port'],
                'DEST_PORT'             => $param_vess[$i]['dest_port'],
                'EST_LOAD'              => $param_vess[$i]['est_load'],
                'EST_DISCHARGE'         => $param_vess[$i]['est_discharge'],
                'BTOA_SIDE'             => $param_vess[$i]['btoa_side'],
                'WINDOWS'               => $param_vess[$i]['windows'],
                'INFO'                  => $param_vess[$i]['info'],
                'TENTATIF'              => $param_vess[$i]['tentatif'],
                'IS_UNREG'              => $param_vess[$i]['is_unreg'],
            ];

            DB::table('CBSLAM.VESSEL_DETAILS_CRANE')->where('ves_id', $param_vess[$i]['ves_id'])->delete();

            for ($a=0 ; $a < count($savecrane); $a++){
                $data_crane=[
                    'ves_id' =>  $param_vess[$i]['ves_id'],
                    'che_id' => $savecrane[$a]
                ];
                DB::table('CBSLAM.VESSEL_DETAILS_CRANE')->insert($data_crane);
            }
            if($param_vess[$i]['is_simulation'] == '1' ) {
                DB::table('CBSLAM.VESSEL_DETAILS_SIM')
                ->insert($data_push);
            } else {
                DB::table('CBSLAM.VESSEL_DETAILS_SIM')
                ->where('ves_id', $param_vess[$i]['ves_id_old'])
                ->update($data_update);
            }
        }

        Note::whereDate('START_DATE', '>=', date('Y-m-d'))->where('OCEAN_INTERISLAND', $request->param_ocean)->delete();

        if($request->param_note != null) {
            foreach ($request->param_note as $i => $val) {
                Note::insert($val);
            }
        }

        return response()->json(["sukses"=> true ]);
       
    }


    public function logo()
    {   
        $customer = DB::table('CBSLAM.CBS_CUSTOMER')
            ->get();
        return view('content.tablecustomer',compact("customer"));
    }

    public function updatelogo(Request $request, $customer)
    {  
       
        if($request->hasfile('file')){
            $request->file('file')->move('public/img/customer/',$request->file('file')->getClientOriginalName());
            $img_name = $request->file('file')->getClientOriginalName();
            }
           
            $id_cus = $customer.' '; 
            $cus= DB::table('CBSLAM.CUSTOMER')
                ->where("CUSTOMER",$id_cus)
                ->update(['image' => $img_name]);

          
        return redirect()->back();
    }

    public function getcrane()
    {
        set_time_limit(60000);
        $craneCon = DB::table('CBSLAM.CBS_CHE_MASTER')
        ->where ('CHE_TYPE', 'PTR')
        ->orderBy('OCEAN_INTERISLAND', 'ASC')
        ->orderBy('CHE_ID', 'ASC')
        ->get();
        $craneDry= DB::table('CBSLAM.CBS_CHE_MASTER')
        ->where ('CHE_TYPE', 'GSU')
        ->orderBy('CHE_ID', 'ASC')
        ->get();
        $crane = [
                    'Con' => $craneCon,
                    'Dry' => $craneDry,
                ];

        return response()->json($crane);
    }

    public function getport()
    {
        $getport = DB::table('CBSLAM.CBS_PORT_MASTER')
        ->get();

        return response()->json($getport);
    }
    public function getsignature()
    {
        $manager =  DB::table('CBSLAM.MASTER_SIGNATURE_PLAN')
        ->where('jabatan', "PLANNING MANAGER")
        ->get();
        $planner =  DB::table('CBSLAM.MASTER_SIGNATURE_PLAN')
        ->where('jabatan', "BERTH PLANNER")
        ->get();


        $getsign = [
            'man' => $manager,
            'plan' => $planner,
        ];

        return response()->json($getsign);
    }

    public function sync_prod(Request $request)
    {
        // $result = DB::select(DB::raw("begin CBSLAM.VIERA_VES_DET_SIM_SYNC; end;"));
        $procedureName = 'CBSLAM.VIERA_VES_DET_SIM_SYNC';

        $result = DB::executeProcedure($procedureName);

        return response()->json($result);
    }

    public function send_to_tos(Request $request)
    {
        $procedureName = 'CBSLAM.SEND_VIERA_TOS';

        $result = DB::executeProcedure($procedureName);

        return response()->json($result);
    }


    public function delete_ves_not_input(Request $request) 
    {
        $isSuccess = DB::table('CBSLAM.VIER_REQ_BERTH')
            ->where('id', $request->id)
            ->update(['IS_PLANNED' => '1']);
            // ->delete();
        return response()->json([
            'success' => $isSuccess,
            'message' => ($isSuccess?'Delete success':'Delete failed')
        ]);
    }

    public function ves_not_yet_json($status){
        $where_addition = '';
        if($status != -2) {
            $where_addition = "WHERE STATUS='{$status}' ";
        }
        return DataTables::of(
            DB::select("SELECT * FROM CBSLAM.VIERV_VES_NOT_YET
                {$where_addition} 
                ORDER BY CREATED_DATE DESC")
        )->make(true);
    }

}
