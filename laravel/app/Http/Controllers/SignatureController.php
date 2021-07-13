<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Signature;
use DataTables;

class SignatureController extends Controller
{
    public function index()
    {
        return view('content.signature.signature');
    }

    public function json(){
        return DataTables::of(Signature::all())->make(true);
    //    dump(DataTables::of(Signature::all())->make(true));
    }

    public function add(Request $request)
    { 
        $paramjab = $request->param4;
        if ($paramjab=='BERTH PLANNER')
            $jab = '2';
        else 
            $jab = '1';

        $result = DB::table('TOWER.MASTER_SIGNATURE_PLAN')
        ->insert([
        	'NIPP'	=> $request->param2,
        	'NAMA'	=> $request->param3,
        	'JABATAN'	=> $request->param4,
            'URUTAN' => $jab
        ]);
        return [
        	'success'	=> $result,
        	'message'	=> ($result?'Success':'Gagal')
        ];
    }

    public function update(Request $request)
    {
        $result = DB::table('TOWER.MASTER_SIGNATURE_PLAN')
        ->where('nipp', $request->curParam2)
        ->update([
        	'NIPP'	=> $request->param2,
        	'NAMA'	=> $request->param3,
        	'JABATAN'	=> $request->param4
        ]);
        return [
        	'success'	=> $result,
        	'message'	=> ($result?'Success':'Gagal')
        ];
    }

    public function remove(Request $request)
    {
        $result = DB::table('TOWER.MASTER_SIGNATURE_PLAN')
        ->where('nipp', $request->param)
        ->delete();
        return [
        	'success'	=> $result,
        	'message'	=> ($result?'Success':'Gagal')
        ];
    }


    public function qrcode(Request $request)
    { 
        $param_print = $request->param_print;

        $date_printnow = $param_print['0']['date_print'];
        $bp = $param_print['0']['bp'];
        $pm = $param_print['0']['pm'];
        
        // dump($date_printnow);

        
        

        $count = DB::table('TOWER.MASTER_SIGNATURE_QR')->count();
        $countout = $count+1;
        
        if (($count >= 0) && ($count <= 9)) 
            $nomor_doc="00".$countout;
        else if (($count >= 10) && ($count <= 99))
            $nomor_doc="0".$countout;
        else if (($count >= 100) && ($count <= 999))
            $nomor_doc=$countout;


        $id=$countout;
        $link1="https://viera.teluklamong.co.id/vesselberthplan/Signature/qr?date=".$date_printnow."&bp=".$bp;
        $link2="https://viera.teluklamong.co.id/vesselberthplan/Signature/qr?date=".$date_printnow."&bp=".$pm;
        $no_doc = "BA.".$nomor_doc."/TI.02.03/PTTL-2021";
        $date_print=$date_printnow;

        $data_print = [
            'ID' => $id,
            'LINK1' => $link1,
            'LINK2' => $link2,
            'NO_DOC' => $no_doc,
            'DATE_PRINT'=> $date_print
        ];
        // dump($data_print);
        // DB::table('TOWER.MASTER_SIGNATURE_QR')
        // ->insert($data_print);
       
        // return response()->json($param_print);
        return response()->json(["sukses"=> true ]);
        
    }

}
