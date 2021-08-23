<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Blokirkade;

class MonitorController extends Controller
{
    public function proses(Request $request)
    {

        $from = $request->date_start;
        $to = $request->date_end;

        $dataIntern= DB::table('CBSLAM.CBS_VESSEL_MONITORING')
        -> where('ocean_interisland_fake','I')
        -> whereBetween('EST_BERTH_TS',[$from.' 00:00:00', $to.' 23:59:59'])
        -> get();
        $dataDomes= DB::table('CBSLAM.CBS_VESSEL_MONITORING')
        -> where('ocean_interisland_fake','D')
        -> whereBetween('EST_BERTH_TS',[$from.' 00:00:00', $to.' 23:59:59'])
        -> get();
        $dataCurah= DB::table('CBSLAM.CBS_VESSEL_MONITORING')
        -> where('ocean_interisland_fake','C')
        -> whereBetween('EST_BERTH_TS',[$from.' 00:00:00', $to.' 23:59:59'])
        -> get();
        $data = [
            'Intern' => $dataIntern,
            'Domes' => $dataDomes,
            'Curah' => $dataCurah,
        ];

        return response()->json($data);
    }

    public function proses2(Request $request)
    {

        $from = $request->date2_start;
        $to = $request->date2_end;

        $dataIntern= DB::table('CBSLAM.CBS_VESSEL_MONITORING')
        -> where('ocean_interisland_fake','I')
        -> whereBetween('EST_BERTH_TS',[$from.' 00:00:00', $to.' 23:59:59'])
        -> get();
        $dataDomes= DB::table('CBSLAM.CBS_VESSEL_MONITORING')
        -> where('ocean_interisland_fake','D')
        -> whereBetween('EST_BERTH_TS',[$from.' 00:00:00', $to.' 23:59:59'])
        -> get();
        $dataCurah= DB::table('CBSLAM.CBS_VESSEL_MONITORING')
        -> where('ocean_interisland_fake','C')
        -> whereBetween('EST_BERTH_TS',[$from.' 00:00:00', $to.' 23:59:59'])
        -> get();
        $data = [
            'Intern' => $dataIntern,
            'Domes' => $dataDomes,
            'Curah' => $dataCurah,
        ];

        return response()->json($data);
    }
}
