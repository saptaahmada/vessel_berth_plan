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
                'EST_BERTH_TS'  => $request->etb,
                'EST_DEP_TS'    => $request->etd,
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
        $draw   = $_GET['draw'];
        $start  = $_GET['start'];
        $length = $_GET['length'];
        $search = $_GET['search'];

        $total_members = DB::table('CBSLAM.CBS_VESSEL_MONITORING')->count();;
        $sql = DB::table('CBSLAM.CBS_VESSEL_MONITORING')
                ->skip($start)
                ->take($length);


        // if($search['']) {
            $result = $sql->where('VES_NAME', 'like', '%' . strtoupper($search['value']) . '%')
            ->orWhere('VES_ID', 'like', '%' . strtoupper($search['value']) . '%')
            ->get();
        // } else {
        //     $result = $sql->get();
        // }

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_members,
            'recordsFiltered' => $total_members,
            'data' => $result,
        );

        echo json_encode($data);
    }
}
