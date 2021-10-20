<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ReqBerth;
use DataTables;

class ReqBerthController extends Controller
{
    public function index()
    {
        return view('content.req_berth.view');
    }

    public function add(Request $request)
    {
        $closing_cargo_date = getDefaultDate($request->closing_cargo_date);
        $rbt = getDefaultDate($request->rbt);
        $eta = getDefaultDate($request->eta);
        $etb = getDefaultDate($request->etb);

        $result = DB::table('CBSLAM.VIER_REQ_BERTH')
        ->insert([
            'VES_ID'        => $request->ves_id,
            'VES_CODE'      => $request->ves_code,
            'VES_NAME'      => $request->ves_name,
            'VES_CODE_MDM'  => $request->ves_code_mdm,
            'CALL_SIGN'     => $request->call_sign,
            'LOA'           => $request->loa,
            'VOY_NO_CUST'   => $request->voy_no_cust,
            'RBT'           => $rbt,
            'ETA'           => $eta,
            'ETB'           => $etb,
            'EST_LOAD'      => $request->est_load,
            'EST_DISC'      => $request->est_disc,
            'DEST_PORT'     => $request->dest_port,
            'DEST_PORT_NAME'=> $request->dest_port_name,
            'DRAFT'         => $request->draft,
            'CLOSING_CARGO_DATE' => $closing_cargo_date,
            'REMARK'        => $request->remark,
            'CREATED_BY'    => session('agent'),
            'STATUS'        => $request->status,
            'IS_CANCEL'     => ($request->status==2?1:0)
        ]);
        return [
            'success'   => $result,
            'message'   => ($result?'Success':'Failed')
        ];
    }

    public function cancel(Request $request)
    {
        $res = $this->add($request);

        if($res['success']) {
            $result = DB::table('CBSLAM.VIER_REQ_BERTH')
                ->where('ID', $request->id)
                ->update([
                    'IS_CANCEL' => 1
                ]);

            return [
                'success'   => $result,
                'message'   => ($result?'Success':'Failed')
            ];
        } else {
            return [
                'success'   => false,
                'message'   => 'Kesalahan sistem'
            ];
        }
    }

    public function remove(Request $request)
    {
        $result = DB::table('CBSLAM.VIER_REQ_BERTH')
        ->where('ID', $request->id)
        ->delete();
        return [
            'success'   => $result,
            'message'   => ($result?'Success':'Failed')
        ];
    }

    public function json(){
        return DataTables::of(
            DB::table('CBSLAM.VIERV_REQ_BERTH')
                ->where('CREATED_BY', session('agent'))
                ->orderBy('CREATED_DATE', 'DESC')
                ->get()
        )->make(true);
    }

    public function getAll(Request $request)
    {
        $now = date("Y-m-d");

        $result = DB::table('CBSLAM.VIERV_REQ_BERTH')->where('IS_DONE', 0)->where('CREATED_DATE', '>=', $now)->get();
        return response()->json([
            'success'   => true,
            'data'      => $result,
        ]);
    }

}
