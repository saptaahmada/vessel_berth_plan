<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Blokirkade;
use DataTables;

class BlokirkadeController extends Controller
{
    public function index()
    {
        // $blokirkade = DB::table('TOWER.VBP_GEN_REF')
        // ->where('PARAM1', 'BLOKIR_KADE')
        // ->get();
        return view('content.blokirkade.view');
    }

    public function add(Request $request)
    {
        $result = DB::table('TOWER.VBP_GEN_REF')
        ->insert([
        	'PARAM1'	=> 'BLOKIR_KADE',
        	'PARAM2'	=> $request->param2,
        	'PARAM3'	=> $request->param3,
        	'PARAM4'	=> $request->param4,
        ]);
        return [
        	'success'	=> $result,
        	'message'	=> ($result?'Success':'Gagal')
        ];
    }

    public function update(Request $request)
    {
        $result = DB::table('TOWER.VBP_GEN_REF')
        ->where('PARAM2', $request->curParam2)
        ->update([
        	'PARAM2'	=> $request->param2,
        	'PARAM3'	=> $request->param3,
        	'PARAM4'	=> $request->param4,
        ]);
        return [
        	'success'	=> $result,
        	'message'	=> ($result?'Success':'Gagal')
        ];
    }

    public function remove(Request $request)
    {
        $result = DB::table('TOWER.VBP_GEN_REF')
        ->where('PARAM1', 'BLOKIR_KADE')
        ->where('PARAM2', $request->param2)
        ->delete();
        return [
        	'success'	=> $result,
        	'message'	=> ($result?'Success':'Gagal')
        ];
    }

    public function json(){
        return DataTables::of(Blokirkade::where('PARAM1', 'BLOKIR_KADE')->get())->make(true);
    }
}
