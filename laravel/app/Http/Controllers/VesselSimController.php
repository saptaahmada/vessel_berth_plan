<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class VesselSimController extends Controller
{
    public function index()
    {
        return view('content.vessel_sim.view');
    }

    public function update(Request $request)
    {
        $data_new = DB::table('CBSLAM.CBS_VESSEL_MONITORING')->where('VES_ID', $request->ves_id_new)->get();

        $result = false;

        if(count($data_new) <= 0 || $request->ves_id_new == $request->ves_id) {
            $result = DB::table('CBSLAM.VESSEL_DETAILS_SIM')
            ->where('VES_ID', $request->ves_id)
            ->update([
                'VES_ID'        => $request->ves_id_new,
                'UPDATED_BY'    => session('data'),
                'UPDATED_DATE'  => date('Y-m-d H:i:s')
            ]);
        }

        return [
            'success'   => $result,
            'message'   => ($result?'Success':'Failed')
        ];
    }

    public function json(){
        return DataTables::of(DB::table('CBSLAM.CBS_VESSEL_MONITORING')->orderBy('EST_BERTH_TS')->get())->make(true);
    }
}
