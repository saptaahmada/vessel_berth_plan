<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Dermaga;
use DataTables;

class DermagaController extends Controller
{
    public function index()
    {
        // $dermaga = DB::table('CBSLAM.VBP_GEN_REF')
        // ->where('PARAM1', 'DERMAGA')
        // ->get();
        return view('content.dermaga.view');
    }

    public function add(Request $request)
    {
        $result = DB::table('CBSLAM.VBP_GEN_REF')
        ->insert([
            'PARAM1'    => 'DERMAGA',
            'PARAM2'    => $request->param2,
            'PARAM3'    => $request->param3,
            'PARAM4'    => $request->param4,
        ]);
        return [
            'success'   => $result,
            'message'   => ($result?'Success':'Gagal')
        ];
    }

    public function update(Request $request)
    {
        $result = DB::table('CBSLAM.VBP_GEN_REF')
        ->where('PARAM1', 'DERMAGA')
        ->where('PARAM2', $request->curParam2)
        ->update([
            'PARAM2'    => $request->param2,
            'PARAM3'    => $request->param3,
            'PARAM4'    => $request->param4,
        ]);
        return [
            'success'   => $result,
            'message'   => ($result?'Success':'Gagal')
        ];
    }

    public function remove(Request $request)
    {
        $result = DB::table('CBSLAM.VBP_GEN_REF')
        ->where('PARAM1', 'DERMAGA')
        ->where('PARAM2', $request->param2)
        ->delete();
        return [
            'success'   => $result,
            'message'   => ($result?'Success':'Gagal')
        ];
    }

    public function json(){
        return DataTables::of(Dermaga::where('PARAM1', 'DERMAGA')->get())->make(true);
    }

    public function getkade()
    {
        $all= DB::table('CBSLAM.VBP_GEN_REF')
        ->where ('PARAM1', 'DERMAGA')
        ->get();

        $kadedom = DB::table('CBSLAM.VBP_GEN_REF')
        ->where ('PARAM1', 'DERMAGA')
        ->where ('PARAM2', 'D')
        ->get();
        $kadeint = DB::table('CBSLAM.VBP_GEN_REF')
        ->where ('PARAM1', 'DERMAGA')
        ->where ('PARAM2', 'I')
        ->get();
        $kadecur = DB::table('CBSLAM.VBP_GEN_REF')
        ->where ('PARAM1', 'DERMAGA')
        ->where ('PARAM2', 'C')
        ->get();
        
        $kade = [
                    'all' => $all,
                    'dom' => $kadedom,
                    'int' => $kadeint,
                    'cur' => $kadecur,
                ];
        return response()->json($kade);
    }
}
