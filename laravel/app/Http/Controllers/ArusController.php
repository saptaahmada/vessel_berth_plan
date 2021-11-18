<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Arus;
use DataTables;
// use vendor\PHPExcel\PHPExcel;

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

    public function getAll(Request $request)
    {
        echo json_encode(DB::table('CBSLAM.VIERV_ARUS')->whereDate('START_DATE', '>=', date('Y-m-d 00:00:00'))->orderBy('START_DATE', 'DESC')->get());
    }

    public function add(Request $request)
    {
        $start = $request->start_date;
        $end   = $request->end_date;

        // dump(count($start));
        for ($s=0 ; $s < count($start); $s++){
            $data_arus = [
                'start_date'    => $start[$s],
                'end_date'      => $end[$s]
            ];

            $result = DB::table('CBSLAM.MASTER_ARUS')->insert($data_arus);
           
                // dump($data_arus);
        }
        return [
            'success'	=> $result,
            'message'	=> ($result?'Success':'Failed')
        ];

        
    }

    public function remove(Request $request)
    {
        $result = DB::table('CBSLAM.MASTER_ARUS')
        ->where('ARUS_ID', $request->arus_id)
        ->delete();
        return [
        	'success'	=> $result,
        	'message'	=> ($result?'Success':'Failed')
        ];
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $file_name = time().".".$file->getClientOriginalExtension();
        $file->move('public/uploads', $file_name);

        $sheet = getSheet("public/uploads/{$file_name}");

        $data = [];

        foreach ($sheet as $key => $val) {
            if($key>1) {
                $data[] = [
                    'START_DATE'    => getDefaultDate($val['A'].' '.($val['B']<10?"0{$val['B']}":$val['B']).':00', true),
                    'END_DATE'      => getDefaultDate($val['A'].' '.($val['C']<10?"0{$val['C']}":$val['C']).':00', true),
                ];
            }
        }

        $is_success = Arus::insert($data);
        \Session::flash('message', '<div class="alert alert-success">Success insert data arus minus</div>');
        return back();
        // return view('content.arus.arus', ['success' => $is_success, 'message' => '<div class="alert alert-success"></div>']);
    }

}
