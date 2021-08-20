<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use DB;
use PDF;
use Session;
use App\Blokirkade;
use App\Note;


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
        $domes = DB::table('TOWER.CBS_VESSEL_MASTER_PLAN')
            -> where('ocean_interisland','D')
            -> get();
        $intern = DB::table('TOWER.CBS_VESSEL_MASTER_PLAN')
            -> where('ocean_interisland','I')
            -> get();
        $al = DB::table('TOWER.CBS_VESSEL_MASTER_PLAN')
            -> get();
        $blokirkade = Blokirkade::where('PARAM1', 'BLOKIR_KADE')->get();
        // $note = Note::whereDate('START_DATE', '>=', date('Y-m-d'))->get();
    
        return view('content.berthplan3', compact("domes", "intern","al","blokirkade"));
    }

    public function getdermaga() 
    {
        $all = DB::table('TOWER.CBS_VESSEL_MASTER_PLAN')
            -> get();
        $dermagaInt = DB::table('TOWER.CBS_VESSEL_MASTER_PLAN')
            -> where('ocean_interisland',"I")
            -> get();
        $dermagaDom = DB::table('TOWER.CBS_VESSEL_MASTER_PLAN')
            -> where('ocean_interisland',"D")
            -> get();
        $dry = DB::table('TOWER.CBS_VESSEL_MASTER_PLAN')
            -> where('ves_type',"GC")
            -> get();
        $con = DB::table('TOWER.CBS_VESSEL_MASTER_PLAN')
            -> where('ves_type',"CT")
             -> get();

        $note = Note::whereDate('START_DATE', '>=', date('Y-m-d'))->get();

        $dermaga = [
            'all' => $all,
            'Intern' => $dermagaInt,
            'Domes' => $dermagaDom,
            'Dry' => $dry,
            'Con'=> $con,
            'note'=>$note
        ];

        echo json_encode($dermaga);

    }

    public function getvessel(Request $request)
    {
        $dataIntern = DB::table('TOWER.CBS_VESSEL_PLANNING')
        -> where('ocean_interisland_fake','I')
        -> get();
        $dataDomes = DB::table('TOWER.CBS_VESSEL_PLANNING')
        -> where('ocean_interisland_fake','D')
        -> get();
        $dataCurah= DB::table('TOWER.CBS_VESSEL_PLANNING')
        -> where('ocean_interisland_fake','C')
        -> get();
        $note = Note::whereDate('START_DATE', '>=', date('Y-m-d'))
        // ->where('ocean_interisland', isset($request->ocean_interisland)?$request->ocean_interisland:'')
        ->get();

        $note_d = [];
        $note_i = [];
        $note_c = [];

        foreach ($note as $key => $val) {
            if($val['ocean_interisland'] == 'D')
                $note_d[] = $val;
            else if($val['ocean_interisland'] == 'I')
                $note_i[] = $val;
            else if($val['ocean_interisland'] == 'C')
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

        return response()->json($data);
    }

    public function addvessel(Request $request)
    {
        $dataIntern = DB::table('TOWER.CBS_VESSEL_MASTER_PLAN')
        -> where('ves_id',$request->param_data)
        -> get();

        $param1=$request->param_crane;

        echo json_encode($dataIntern);
    }

    public function save(Request $request)
    {
        $arr_vess = $request->param_vess;

        $this->saveProcess($arr_vess, 'Domes', 'note_d', 'D');
        $this->saveProcess($arr_vess, 'Intern', 'note_i', 'I');
        $this->saveProcess($arr_vess, 'Curah', 'note_c', 'C');

        // if(isset($arr_vess)) {
        //     if(isset($arr_vess['Intern'])) {
        //         DB::table('TOWER.VESSEL_DETAILS_SIM')
        //             ->where('IS_SIMULATION', '1')
        //             ->where('OCEAN_INTERISLAND_FAKE', 'I')
        //             ->delete();
                
        //         $param_vess = $arr_vess['Intern'];

        //         foreach ($param_vess as $i => $val) {

        //             if(isset($param_vess[$i]['crane']))
        //                 $craneparam = ($param_vess[$i]['crane']);
        //             else
        //                 $craneparam = [];

        //             if (is_array($craneparam)) 
        //                 $crane_string = implode(",", $craneparam);
        //             else 
        //                 $crane_string = $craneparam;

        //             $savecrane = explode(",", $crane_string);

        //             $data_update = [
        //                 'berth_fr_metre'        => $param_vess[$i]['berth_fr_metre_ori'],
        //                 'berth_to_metre'        => $param_vess[$i]['berth_to_metre_ori'],
        //                 'ves_id'                => $param_vess[$i]['ves_id'],
        //                 'ves_name'              => $param_vess[$i]['ves_name'],
        //                 'ocean_interisland'     => $param_vess[$i]['ocean_interisland'],
        //                 'ocean_interisland_fake'=> $request->param_ocean,
        //                 'EST_PILOT_TS'          => $param_vess[$i]['est_pilot_ts'] != null ? 
        //                                             $param_vess[$i]['est_pilot_ts'] : $null_date,
        //                 'REQ_BERTH_TS'          => $param_vess[$i]['req_berth_ts'] != null ? 
        //                                             $param_vess[$i]['req_berth_ts'] : $null_date,
        //                 'est_berth_ts'          => $param_vess[$i]['est_berth_ts'],
        //                 'est_dep_ts'            => $param_vess[$i]['est_dep_ts'],
        //                 'CRANE'                 => $crane_string,
        //                 'BCH'                   => $param_vess[$i]['bsh'],
        //                 'BSH'                   => $param_vess[$i]['bsh'],
        //                 'NEXT_PORT'             =>$param_vess[$i]['next_port'],
        //                 'DEST_PORT'             => $param_vess[$i]['dest_port'],
        //                 'EST_LOAD'              => $param_vess[$i]['est_load'],
        //                 'EST_DISCHARGE'         => $param_vess[$i]['est_discharge'],
        //                 'BTOA_SIDE'             => $param_vess[$i]['btoa_side'],
        //                 'WINDOWS'               => $param_vess[$i]['windows'],
        //                 'INFO'                  => $param_vess[$i]['info'],
        //                 'TENTATIF'              => $param_vess[$i]['tentatif'],
        //             ];

        //             $data_push = [
        //                 'berth_fr_metre'        => $param_vess[$i]['berth_fr_metre_ori'],
        //                 'berth_to_metre'        => $param_vess[$i]['berth_to_metre_ori'],
        //                 'ves_id'                => $param_vess[$i]['ves_id'],
        //                 'ves_name'              => $param_vess[$i]['ves_name'],
        //                 'ves_code'              => $param_vess[$i]['ves_code'],
        //                 'ocean_interisland'     => $param_vess[$i]['ocean_interisland'],
        //                 'ocean_interisland_fake'=> $request->param_ocean,
        //                 'EST_PILOT_TS'          => $param_vess[$i]['est_pilot_ts'] != null ? 
        //                                             $param_vess[$i]['est_pilot_ts'] : $null_date,
        //                 'REQ_BERTH_TS'          => $param_vess[$i]['req_berth_ts'] != null ? 
        //                                             $param_vess[$i]['req_berth_ts'] : $null_date,
        //                 'est_berth_ts'          => $param_vess[$i]['est_berth_ts'],
        //                 'est_dep_ts'            => $param_vess[$i]['est_dep_ts'],
        //                 'EST_ANCHORAGE_TS'      => $null_date,
        //                 'EST_START_WORK_TS'     => $null_date,
        //                 'EST_END_WORK_TS'       => $null_date,
        //                 'ACT_DEP_TS'            => $null_date,
        //                 'ACT_ANCHORAGE_TS'      => $null_date,
        //                 'ACT_PILOT_TS'          => $null_date,
        //                 'ACT_BERTH_TS'          => $null_date,
        //                 'ACT_START_WORK_TS'     => $null_date,
        //                 'ACT_END_WORK_TS'       => $null_date,
        //                 'DOCO_CUTOFF_TS'        => $null_date,
        //                 'RECV_CTR_CUTOFF_TS'    => $null_date,
        //                 'RECV_CARGO_CUTOFF_TS'  => $null_date,
        //                 'AGENT'                 => $param_vess[$i]['agent'],
        //                 'IS_SIMULATION'         => $param_vess[$i]['is_simulation'],
        //                 'CRANE'                 => $crane_string,
        //                 'BCH'                   => $param_vess[$i]['bsh'],
        //                 'BSH'                   => $param_vess[$i]['bsh'],
        //                 'NEXT_PORT'             =>$param_vess[$i]['next_port'],
        //                 'DEST_PORT'             => $param_vess[$i]['dest_port'],
        //                 'EST_LOAD'              => $param_vess[$i]['est_load'],
        //                 'EST_DISCHARGE'         => $param_vess[$i]['est_discharge'],
        //                 'BTOA_SIDE'             => $param_vess[$i]['btoa_side'],
        //                 'WINDOWS'               => $param_vess[$i]['windows'],
        //                 'INFO'                  => $param_vess[$i]['info'],
        //                 'TENTATIF'              => $param_vess[$i]['tentatif'],
        //                 'IS_UNREG'              => $param_vess[$i]['is_unreg'],
        //             ];

        //             DB::table('TOWER.VESSEL_DETAILS_CRANE')
        //             ->where('ves_id', $param_vess[$i]['ves_id'])
        //             ->delete();

        //             for ($a=0 ; $a < count($savecrane); $a++){
        //                 $data_crane=[
        //                     'ves_id' =>  $param_vess[$i]['ves_id'],
        //                     'che_id' => $savecrane[$a]
        //                 ];
        //                 DB::table('TOWER.VESSEL_DETAILS_CRANE')->insert($data_crane);
        //             }
        //             if($param_vess[$i]['is_simulation'] == '1' ) {
        //                 DB::table('TOWER.VESSEL_DETAILS_SIM')
        //                 ->insert($data_push);
        //             } else {
        //                 DB::table('TOWER.VESSEL_DETAILS_SIM')
        //                 ->where('ves_id', $param_vess[$i]['ves_id_old'])
        //                 ->update($data_update);
        //             }

        //         }

        //         Note::whereDate('START_DATE', '>=', date('Y-m-d'))
        //         ->where('OCEAN_INTERISLAND', 'I')->delete();

        //         if(isset($arr_note['note_i'])) {
        //             if($arr_note['note_i'] != null) {
        //                 foreach ($arr_note['note_i'] as $i => $val) {
        //                     Note::insert($val);
        //                 }
        //             }
        //         }

        //     }
        // }

        // if ($param_vess == null)
        //     $count = 0;
        // else
        //     $count = count($param_vess);

        // $null_date = '1900-12-21 23:00:00';

        // DB::table('TOWER.VESSEL_DETAILS_SIM')
        //     ->where('IS_SIMULATION', '1')
        //     ->where('OCEAN_INTERISLAND_FAKE', $request->param_ocean)
        //     ->delete();


        // if($request->param_vess_removed != null)
        //     foreach ($request->param_vess_removed as $i => $val)
        //         DB::table('TOWER.VESSEL_DETAILS_SIM')->where('ves_id', $val['ves_id'])->delete();


        // for ($i=0 ; $i < $count; $i++){

        //     if(isset($param_vess[$i]['crane']))
        //         $craneparam = ($param_vess[$i]['crane']);
        //     else
        //         $craneparam = [];

        //     if (is_array($craneparam)) 
        //         $crane_string = implode(",", $craneparam);
        //     else 
        //         $crane_string = $craneparam;

        //     $savecrane = explode(",", $crane_string);

        //     $data_update = [
        //         'berth_fr_metre'        => $param_vess[$i]['berth_fr_metre_ori'],
        //         'berth_to_metre'        => $param_vess[$i]['berth_to_metre_ori'],
        //         'ves_id'                => $param_vess[$i]['ves_id'],
        //         'ves_name'              => $param_vess[$i]['ves_name'],
        //         'ocean_interisland'     => $param_vess[$i]['ocean_interisland'],
        //         'ocean_interisland_fake'=> $request->param_ocean,
        //         'EST_PILOT_TS'          => $param_vess[$i]['est_pilot_ts'] != null ? 
        //                                     $param_vess[$i]['est_pilot_ts'] : $null_date,
        //         'REQ_BERTH_TS'          => $param_vess[$i]['req_berth_ts'] != null ? 
        //                                     $param_vess[$i]['req_berth_ts'] : $null_date,
        //         'est_berth_ts'          => $param_vess[$i]['est_berth_ts'],
        //         'est_dep_ts'            => $param_vess[$i]['est_dep_ts'],
        //         'CRANE'                 => $crane_string,
        //         'BCH'                   => $param_vess[$i]['bsh'],
        //         'BSH'                   => $param_vess[$i]['bsh'],
        //         'NEXT_PORT'             =>$param_vess[$i]['next_port'],
        //         'DEST_PORT'             => $param_vess[$i]['dest_port'],
        //         'EST_LOAD'              => $param_vess[$i]['est_load'],
        //         'EST_DISCHARGE'         => $param_vess[$i]['est_discharge'],
        //         'BTOA_SIDE'             => $param_vess[$i]['btoa_side'],
        //         'WINDOWS'               => $param_vess[$i]['windows'],
        //         'INFO'                  => $param_vess[$i]['info'],
        //         'TENTATIF'              => $param_vess[$i]['tentatif'],
        //     ];

        //     $data_push = [
        //         'berth_fr_metre'        => $param_vess[$i]['berth_fr_metre_ori'],
        //         'berth_to_metre'        => $param_vess[$i]['berth_to_metre_ori'],
        //         'ves_id'                => $param_vess[$i]['ves_id'],
        //         'ves_name'              => $param_vess[$i]['ves_name'],
        //         'ves_code'              => $param_vess[$i]['ves_code'],
        //         'ocean_interisland'     => $param_vess[$i]['ocean_interisland'],
        //         'ocean_interisland_fake'=> $request->param_ocean,
        //         'EST_PILOT_TS'          => $param_vess[$i]['est_pilot_ts'] != null ? 
        //                                     $param_vess[$i]['est_pilot_ts'] : $null_date,
        //         'REQ_BERTH_TS'          => $param_vess[$i]['req_berth_ts'] != null ? 
        //                                     $param_vess[$i]['req_berth_ts'] : $null_date,
        //         'est_berth_ts'          => $param_vess[$i]['est_berth_ts'],
        //         'est_dep_ts'            => $param_vess[$i]['est_dep_ts'],
        //         'EST_ANCHORAGE_TS'      => $null_date,
        //         'EST_START_WORK_TS'     => $null_date,
        //         'EST_END_WORK_TS'       => $null_date,
        //         'ACT_DEP_TS'            => $null_date,
        //         'ACT_ANCHORAGE_TS'      => $null_date,
        //         'ACT_PILOT_TS'          => $null_date,
        //         'ACT_BERTH_TS'          => $null_date,
        //         'ACT_START_WORK_TS'     => $null_date,
        //         'ACT_END_WORK_TS'       => $null_date,
        //         'DOCO_CUTOFF_TS'        => $null_date,
        //         'RECV_CTR_CUTOFF_TS'    => $null_date,
        //         'RECV_CARGO_CUTOFF_TS'  => $null_date,
        //         'AGENT'                 => $param_vess[$i]['agent'],
        //         'IS_SIMULATION'         => $param_vess[$i]['is_simulation'],
        //         'CRANE'                 => $crane_string,
        //         'BCH'                   => $param_vess[$i]['bsh'],
        //         'BSH'                   => $param_vess[$i]['bsh'],
        //         'NEXT_PORT'             =>$param_vess[$i]['next_port'],
        //         'DEST_PORT'             => $param_vess[$i]['dest_port'],
        //         'EST_LOAD'              => $param_vess[$i]['est_load'],
        //         'EST_DISCHARGE'         => $param_vess[$i]['est_discharge'],
        //         'BTOA_SIDE'             => $param_vess[$i]['btoa_side'],
        //         'WINDOWS'               => $param_vess[$i]['windows'],
        //         'INFO'                  => $param_vess[$i]['info'],
        //         'TENTATIF'              => $param_vess[$i]['tentatif'],
        //         'IS_UNREG'              => $param_vess[$i]['is_unreg'],
        //     ];

        //     DB::table('TOWER.VESSEL_DETAILS_CRANE')->where('ves_id', $param_vess[$i]['ves_id'])->delete();

        //     for ($a=0 ; $a < count($savecrane); $a++){
        //         $data_crane=[
        //             'ves_id' =>  $param_vess[$i]['ves_id'],
        //             'che_id' => $savecrane[$a]
        //         ];
        //         DB::table('TOWER.VESSEL_DETAILS_CRANE')->insert($data_crane);
        //     }
        //     if($param_vess[$i]['is_simulation'] == '1' ) {
        //         DB::table('TOWER.VESSEL_DETAILS_SIM')
        //         ->insert($data_push);
        //     } else {
        //         DB::table('TOWER.VESSEL_DETAILS_SIM')
        //         ->where('ves_id', $param_vess[$i]['ves_id_old'])
        //         ->update($data_update);
        //     }
        // }

        // Note::whereDate('START_DATE', '>=', date('Y-m-d'))->where('OCEAN_INTERISLAND', $request->param_ocean)->delete();

        // if($request->param_note != null) {
        //     foreach ($request->param_note as $i => $val) {
        //         Note::insert($val);
        //     }
        // }

        return response()->json(["sukses"=> true ]);

    }

    public function saveProcess($arr_vess, $var, $var_note, $ocean_interisland)
    {
        $null_date = '1900-12-21 23:00:00';

        // echo json_encode($arr_vess[$var]);
        // echo json_encode($ocean_interisland);
        // die();

        if(isset($arr_vess[$var])) {

            DB::table('TOWER.VESSEL_DETAILS_SIM')
                ->where('IS_SIMULATION', '1')
                ->where('OCEAN_INTERISLAND_FAKE', $ocean_interisland)
                ->delete();
            
            $param_vess = $arr_vess[$var];

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
                    'INFO'                  => $param_vess[$i]['info'],
                    'TENTATIF'              => $param_vess[$i]['tentatif'],
                    'IS_UNREG'              => $param_vess[$i]['is_unreg'],
                ];

                DB::table('TOWER.VESSEL_DETAILS_CRANE')
                ->where('ves_id', $param_vess[$i]['ves_id'])
                ->delete();

                for ($a=0 ; $a < count($savecrane); $a++){
                    $data_crane=[
                        'ves_id' =>  $param_vess[$i]['ves_id'],
                        'che_id' => $savecrane[$a]
                    ];
                    DB::table('TOWER.VESSEL_DETAILS_CRANE')->insert($data_crane);
                }
                if($param_vess[$i]['is_simulation'] == '1' ) {
                    DB::table('TOWER.VESSEL_DETAILS_SIM')
                    ->insert($data_push);
                } else {
                    DB::table('TOWER.VESSEL_DETAILS_SIM')
                    ->where('ves_id', $param_vess[$i]['ves_id_old'])
                    ->update($data_update);
                }

            }

            Note::whereDate('START_DATE', '>=', date('Y-m-d'))
            ->where('OCEAN_INTERISLAND', $ocean_interisland)->delete();

            if(isset($arr_vess[$var_note])) {
                if($arr_vess[$var_note] != null) {
                    foreach ($arr_vess[$var_note] as $i => $val) {
                        Note::insert($val);
                    }
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

        DB::table('TOWER.VESSEL_DETAILS_SIM')
            ->where('IS_SIMULATION', '1')
            ->where('OCEAN_INTERISLAND_FAKE', $request->param_ocean)
            ->delete();


        if($request->param_vess_removed != null)
            foreach ($request->param_vess_removed as $i => $val)
                DB::table('TOWER.VESSEL_DETAILS_SIM')->where('ves_id', $val['ves_id'])->delete();


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

            // if(!isset($param_vess[$i]['berth_fr_metre_ori'])) {
            //     echo $param_vess[$i]['ves_id'];
            //     die();
            // }

            // $data_update = [
            //     'CRANE'             => $crane_string,
            //     'ves_id'            => $param_vess[$i]['ves_id'],
            //     'berth_fr_metre'    => $param_vess[$i]['berth_fr_metre_ori'],
            //     'berth_to_metre'    => $param_vess[$i]['berth_to_metre_ori'],
            //     'est_berth_ts'      => $param_vess[$i]['est_berth_ts'],
            //     'est_dep_ts'        => $param_vess[$i]['est_dep_ts']
            // ];

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

            DB::table('TOWER.VESSEL_DETAILS_CRANE')->where('ves_id', $param_vess[$i]['ves_id'])->delete();

            for ($a=0 ; $a < count($savecrane); $a++){
                $data_crane=[
                    'ves_id' =>  $param_vess[$i]['ves_id'],
                    'che_id' => $savecrane[$a]
                ];
                DB::table('TOWER.VESSEL_DETAILS_CRANE')->insert($data_crane);
            }
            if($param_vess[$i]['is_simulation'] == '1' ) {
                DB::table('TOWER.VESSEL_DETAILS_SIM')
                ->insert($data_push);
            } else {
                DB::table('TOWER.VESSEL_DETAILS_SIM')
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
        $customer = DB::table('TOWER.CBS_CUSTOMER')
            ->get();
        return view('content.tablecustomer',compact("customer"));
    }

    public function updatelogo(Request $request, $customer)
    {  
       
        if($request->hasfile('file')){
            $request->file('file')->move('img/',$request->file('file')->getClientOriginalName());
            $img_name = $request->file('file')->getClientOriginalName();
            }
           
            $id_cus = $customer.' '; 
            $cus= DB::table('TOWER.CUSTOMER')
                ->where("CUSTOMER",$id_cus)
                ->update(['image' => $img_name]);

          
        return redirect()->back();
    }

    public function print()
    {  


        return view('content.printpdf');
    }

    public function getcrane()
    {
        $craneCon = DB::table('TOWER.CBS_CHE_MASTER')
        ->where ('CHE_TYPE', 'PTR')
        ->get();
        $craneDry= DB::table('TOWER.CBS_CHE_MASTER')
        ->where ('CHE_TYPE', 'GSU')
        ->get();
        $crane = [
                    'Con' => $craneCon,
                    'Dry' => $craneDry,
                ];

        return response()->json($crane);
    }

    public function getport()
    {
        $getport = DB::table('TOWER.CBS_PORT_MASTER')
        ->get();

        return response()->json($getport);
    }
    public function getsignature()
    {
        $manager =  DB::table('TOWER.MASTER_SIGNATURE_PLAN')
        ->where('jabatan', "PLANNING MANAGER")
        ->get();
        $planner =  DB::table('TOWER.MASTER_SIGNATURE_PLAN')
        ->where('jabatan', "BERTH PLANNER")
        ->get();


        $getsign = [
            'man' => $manager,
            'plan' => $planner,
        ];

        return response()->json($getsign);
    }
}
