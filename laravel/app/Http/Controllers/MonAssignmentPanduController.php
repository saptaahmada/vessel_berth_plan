<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class MonAssignmentPanduController extends Controller
{
    public function index()
    {
        return view('content.mon_assignment_pandu.view');
    }

    public function json(){
        return DataTables::of(DB::table('CBSLAM.VIERV_ASSIGNMENT_PANDU')->get())->make(true);
    }
}
