<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class ResearchController extends Controller
{
    public function index()
    {
        return view('content.research.view');
    }

}
