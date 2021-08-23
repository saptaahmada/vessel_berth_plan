<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Arus;
use DataTables;

class ArusController extends Controller
{
    public function index()
    {
        // $dermaga = DB::table('CBSLAM.VBP_GEN_REF')
        // ->where('PARAM1', 'DERMAGA')
        // ->get();
        return view('content.arus.arus');
    }

    public function json(){
        return DataTables::of(Arus::all())->make(true);
    }

    public function add(Request $request)
    {
        // dump($request->param4);
        $result = DB::table('CBSLAM.MASTER_ARUS')
        ->insert([
        	'ARUS_ID'	=> $request->param2,
        	'TANGGAL'	=> $request->param3,
        	'START_TIME'	=> $request->param4,
        	'END_TIME'	=> $request->param5
        ]);
        return [
        	'success'	=> $result,
        	'message'	=> ($result?'Success':'Gagal')
        ];
    }

    public function update(Request $request)
    {
        $result = DB::table('CBSLAM.MASTER_ARUS')
        ->where('ARUS_ID', $request->curParam2)
        ->update([
            'ARUS_ID'	=> $request->param2,
        	'TANGGAL'	=> $request->param3,
        	'START_TIME'=> $request->param4,
        	'END_TIME'	=> $request->param5
        ]);
        return [
        	'success'	=> $result,
        	'message'	=> ($result?'Success':'Gagal')
        ];
    }

    public function remove(Request $request)
    {
        $result = DB::table('CBSLAM.MASTER_ARUS')
        ->where('ARUS_ID', $request->param2)
        ->delete();
        return [
        	'success'	=> $result,
        	'message'	=> ($result?'Success':'Gagal')
        ];
    }

}
