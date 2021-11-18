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
        $data_pic = session('data_pic');
        $pic_no = '';
        $pic_nama = '';

        if(count($data_pic) > 0) {
            $pic_no = $data_pic[0]['hp'];
            $pic_nama = $data_pic[0]['nama'];
        }

        $closing_cargo_date = getDefaultDate($request->closing_cargo_date);
        $rbt = getDefaultDate($request->rbt);
        $eta = getDefaultDate($request->eta);
        // $etb = getDefaultDate($request->etb);

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
            'EST_LOAD'      => $request->est_load,
            'EST_DISC'      => $request->est_disc,
            'NEXT_PORT'     => $request->next_port,
            'NEXT_PORT_NAME'=> $request->next_port_name,
            'DEST_PORT'     => $request->dest_port,
            'DEST_PORT_NAME'=> $request->dest_port_name,
            'DRAFT'         => $request->draft,
            'CLOSING_CARGO_DATE' => $closing_cargo_date,
            'REMARK'        => $request->remark,
            'AGENT'         => $request->agent,
            'CREATED_BY'    => $pic_nama,
            'CREATED_BY_HP' => $pic_no,
            'STATUS'        => $request->status,
            'IS_CANCEL'     => ($request->status==2?1:0)
        ]);
        if($request->id != null && $request->id != ''){
            $result = DB::table('CBSLAM.VIER_REQ_BERTH')
                ->where('ID', $request->id)
                ->update([
                    'IS_CANCEL' => 1
                ]);
        }
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
        $data_pic = session('data_pic');

        $data = DB::table('CBSLAM.VIERV_REQ_BERTH');
        foreach ($data_pic as $key => $val) {
            $data->orWhere('AGENT', $val['agent']);
        }
        $data->orderBy('CREATED_DATE', 'DESC');

        return DataTables::of($data->get())->make(true);
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
