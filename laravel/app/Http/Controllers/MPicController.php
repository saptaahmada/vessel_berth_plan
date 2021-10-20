<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\MPic;
use DataTables;

class MPicController extends Controller
{
    public function index()
    {
        return view('content.m_pic.view');
    }

    public function add(Request $request)
    {
        $result = DB::table('CBSLAM.VIER_M_PIC')
        ->insert([
            'TIPE'      => $request->tipe,
            'AGENT'     => $request->agent,
            'AGENT_NAME'=> $request->agent_name,
            'HP'        => $request->hp,
            'EMAIL'     => $request->email,
            'CREATED_BY'=> session('data'),
        ]);
        return [
            'success'   => $result,
            'message'   => ($result?'Success':'Failed')
        ];
    }

    public function update(Request $request)
    {
        $result = DB::table('CBSLAM.VIER_M_PIC')
        ->where('ID', $request->id)
        ->update([
            'TIPE'      => $request->tipe,
            'AGENT'     => $request->agent,
            'AGENT_NAME'=> $request->agent_name,
            'HP'        => $request->hp,
            'EMAIL'     => $request->email,
            'UPDATED_BY'=> session('data'),
        ]);
        return [
            'success'   => $result,
            'message'   => ($result?'Success':'Failed')
        ];
    }

    public function remove(Request $request)
    {
        $result = DB::table('CBSLAM.VIER_M_PIC')
        ->where('ID', $request->id)
        ->delete();
        return [
            'success'   => $result,
            'message'   => ($result?'Success':'Failed')
        ];
    }

    public function json(){
        return DataTables::of(DB::table('CBSLAM.VIERV_M_PIC')->get())->make(true);
    }
}
