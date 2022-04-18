<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/login', function () {
//     return view('login.login');
// });

// Route::get('/login',  'LoginController@loginForm')->name('login');
// Route::post('/login/proses',  'LoginController@login');

Route::get('/', 'LoginController@loginForm')->name('login');
Route::post('/login/proses',  'LoginController@login')->name('loginproses');
Route::post('/login/login_customer_1',  'LoginController@login_customer_1')->name('login_customer_1');
Route::post('/login/login_customer_2',  'LoginController@login_customer_2')->name('login_customer_2');

Route::get('/login2', function () {
    return view('login.login2');
});







// Route::get('/Home', 'HomeController@parkingbackup')->name('vessel');


Route::group(['middleware'=> 'CekLogin'],function(){
    Route::get('/role', 'LoginController@roleForm')->name('role');
    Route::get('/role/proses',  'LoginController@role')->name('roleproses');
    Route::post('/role/session',  'LoginController@rolesession')->name('rolesession');

    Route::get('/Dashboard',  'DashboardController@index');
    Route::get('/Dashboard/json/{ocean_interisland}/{date_from}/{date_to}',  'DashboardController@json');
    Route::post('/Dashboard/get_ship_to_ship',  'DashboardController@get_ship_to_ship');

    // Route::get('/Dashboard', function () {
    //     return view('content.dashboard');
    // });
   
  

    // Route::get('/VesselBerthPlan', 'HomeController@parkingbackup')->name('vessel'); 
    // Route::get('/VesselBerthPlan/getvessel', 'HomeController@getvessel')->name('getvessel');
    // Route::post('/VesselBerthPlan/addvessel', 'HomeController@addvessel')->name('addvessel');
    // Route::get('/VesselBerthPlan/getdermaga', 'HomeController@getdermaga')->name('getdermaga');
    // Route::post('/VesselBerthPlan/updatevessel', 'HomeController@updatevessel')->name('updatevessel');
    // Route::get('/VesselBerthPlan/getcrane', 'HomeController@getcrane')->name('getcrane');
    // Route::get('/VesselBerthPlan/getport', 'HomeController@getport')->name('getport');
    // Route::get('/VesselBerthPlan/getsignature', 'HomeController@getsignature')->name('getsignature');
    
    
    // Route::get('/VesselBerthPlan_Logo','HomeController@logo')->name('logo');
    // Route::post('/VesselBerthPlan_Logo/updatelogo/{customer}','HomeController@updatelogo')->name('updatelogo');

    Route::get('/VesselBerthPlan3', 'Home3Controller@parkingbackup')->name('vessel'); 
    Route::post('/VesselBerthPlan3/addvessel', 'Home3Controller@addvessel')->name('addvessel');
    Route::post('/VesselBerthPlan3/save', 'Home3Controller@Save')->name('save');
    Route::get('/VesselBerthPlan3/getdermaga', 'Home3Controller@getdermaga')->name('getdermaga');
    Route::post('/VesselBerthPlan3/updatevessel', 'Home3Controller@updatevessel')->name('updatevessel');
    Route::get('/VesselBerthPlan3/getcrane', 'Home3Controller@getcrane')->name('getcrane');
    Route::get('/VesselBerthPlan3/getport', 'Home3Controller@getport')->name('getport');
    Route::get('/VesselBerthPlan3/getsignature', 'Home3Controller@getsignature')->name('getsignature');
    
    Route::post('/VesselBerthPlan3/delete_one', 'Home3Controller@delete_one')->name('delete_one');
    Route::post('/VesselBerthPlan3/save_one', 'Home3Controller@save_one')->name('save_one');
    Route::post('/VesselBerthPlan3/delete_note_one', 'Home3Controller@delete_note_one')->name('delete_note_one');
    Route::post('/VesselBerthPlan3/save_note_one', 'Home3Controller@save_note_one')->name('save_note_one');
    Route::post('/VesselBerthPlan3/save2', 'Home3Controller@save2')->name('save2');
    Route::post('/VesselBerthPlan3/sync_prod', 'Home3Controller@sync_prod')->name('sync_prod');
    Route::post('/VesselBerthPlan3/send_to_tos', 'Home3Controller@send_to_tos')->name('send_to_tos');
    Route::get('/VesselBerthPlan_Logo','Home3Controller@logo')->name('logo3');
    Route::post('/VesselBerthPlan_Logo/updatelogo/{customer}','Home3Controller@updatelogo')->name('updatelogo3');
    Route::post('/VesselBerthPlan3/getvessel', 'Home3Controller@getvessel')->name('getvessel');
    Route::get('/VesselBerthPlan3/ves_not_yet_json/{status}', 'Home3Controller@ves_not_yet_json')->name('ves_not_yet_json');
    Route::get('/VesselBerthPlan3/ves_bsh_history_json/{ves_code}', 'Home3Controller@ves_bsh_history_json');
    Route::post('/VesselBerthPlan3/delete_ves_not_input', 'Home3Controller@delete_ves_not_input');

    Route::get('/VesselBerthPlan3/ijin_kawasan', 'Home3Controller@ijin_kawasan');
    Route::get('/VesselBerthPlan3/send_ijin_kawasan', 'Home3Controller@send_ijin_kawasan');
    
    Route::get('/VesselBerthPlan3/getkade', 'DermagaController@getkade')->name('getkade');
    Route::get('/Dermaga','DermagaController@index')->name('dermaga');
    Route::post('/Dermaga/add','DermagaController@add')->name('dermagaAdd');
    Route::post('/Dermaga/update','DermagaController@update')->name('dermagaUpdate');
    Route::post('/Dermaga/remove','DermagaController@remove')->name('dermagaRemove');
    Route::get('/Dermaga/json','DermagaController@json');

    
    Route::get('/MonReqPandu','MonReqPanduController@index')->name('monreqpandu');
    Route::get('/MonReqPandu/json/{tipe}','MonReqPanduController@json');

    Route::get('/MonAssignmentPandu','MonAssignmentPanduController@index')->name('monassignmentpandu');
    Route::get('/MonAssignmentPandu/json','MonAssignmentPanduController@json');

    Route::get('/MPic','MPicController@index')->name('mpic');
    Route::post('/MPic/add','MPicController@add')->name('mpicAdd');
    Route::post('/MPic/update','MPicController@update')->name('mpicUpdate');
    Route::post('/MPic/remove','MPicController@remove')->name('mpicRemove');
    Route::get('/MPic/json','MPicController@json');


    Route::get('/VesselSim','VesselSimController@index');
    Route::post('/VesselSim/add','VesselSimController@add');
    Route::post('/VesselSim/update','VesselSimController@update');
    Route::post('/VesselSim/remove','VesselSimController@remove');
    Route::get('/VesselSim/json','VesselSimController@json');


    Route::get('/ReqBerth','ReqBerthController@index')->name('reqberth');
    Route::post('/ReqBerth/add','ReqBerthController@add')->name('reqberthAdd');
    Route::post('/ReqBerth/cancel','ReqBerthController@cancel')->name('reqberthCancel');
    // Route::post('/ReqBerth/update','ReqBerthController@update')->name('reqberthUpdate');
    Route::post('/ReqBerth/getAll','ReqBerthController@getAll')->name('reqberthGetAll');
    Route::get('/ReqBerth/json','ReqBerthController@json');



    Route::post('/GeneralService/get_vessel_by_ves_code','GeneralServiceController@get_vessel_by_ves_code');
    Route::post('/GeneralService/get_vessel_det_by_ves_code','GeneralServiceController@get_vessel_det_by_ves_code');
    Route::post('/GeneralService/get_vessel_json','GeneralServiceController@get_vessel_json');
    Route::post('/GeneralService/get_port_json','GeneralServiceController@get_port_json');
    Route::post('/GeneralService/get_service_json','GeneralServiceController@get_service_json');

    Route::post('/Customer/get_agent_json','CustomerController@get_agent_json')->name('get_agent_json');
    

    Route::get('/Blokirkade','BlokirkadeController@index')->name('blokirkade');
    Route::post('/Blokirkade/add','BlokirkadeController@add')->name('blokirkadeAdd');
    Route::post('/Blokirkade/update','BlokirkadeController@update')->name('blokirkadeUpdate');
    Route::post('/Blokirkade/remove','BlokirkadeController@remove')->name('blokirkadeRemove');
    Route::get('/Blokirkade/json','BlokirkadeController@json');


    Route::get('/EqpAsgTheme','EqpAsgThemeController@index');
    Route::get('/EqpAsgTheme/add','EqpAsgThemeController@add');
    Route::post('/EqpAsgTheme/addProcess','EqpAsgThemeController@addProcess');
    Route::get('/EqpAsgTheme/update/{theme_name}','EqpAsgThemeController@update');
    Route::post('/EqpAsgTheme/updateProcess','EqpAsgThemeController@updateProcess');
    Route::post('/EqpAsgTheme/getData','EqpAsgThemeController@getData');
    Route::post('/EqpAsgTheme/getDataUpdate','EqpAsgThemeController@getDataUpdate');
    Route::post('/EqpAsgTheme/remove','EqpAsgThemeController@remove');
    Route::post('/EqpAsgTheme/getMyTheme','EqpAsgThemeController@getMyTheme');
    Route::get('/EqpAsgTheme/json','EqpAsgThemeController@json');
    

    Route::get('/Signature','SignatureController@index')->name('signature');
    Route::post('/Signature/add','SignatureController@add')->name('signatureAdd');
    Route::post('/Signature/update','SignatureController@update')->name('signatureUpdate');
    Route::post('/Signature/remove','SignatureController@remove')->name('signatureRemove');
    Route::get('/Signature/json','SignatureController@json');

    Route::get('/Arus','ArusController@index')->name('arus');
    Route::post('/Arus/add','ArusController@add')->name('arusAdd');
    Route::post('/Arus/update','ArusController@update')->name('arusUpdate');
    Route::post('/Arus/remove','ArusController@remove')->name('arusRemove');
    Route::get('/Arus/json','ArusController@json');
    Route::post('/Arus/getAll','ArusController@getAll')->name('getAllArus');
    Route::post('/Arus/import','ArusController@import');


    Route::get('/MHoliday','MHolidayController@index')->name('arus');
    Route::post('/MHoliday/add','MHolidayController@add')->name('arusAdd');
    Route::post('/MHoliday/update','MHolidayController@update')->name('arusUpdate');
    Route::post('/MHoliday/remove','MHolidayController@remove')->name('arusRemove');
    Route::get('/MHoliday/json','MHolidayController@json');
    Route::post('/MHoliday/getAll','MHolidayController@getAll')->name('getAllMHoliday');
    


    Route::get('/Monitoring/{is_act}','MonitorController@index');
    Route::get('/Monitoring/{is_act}','MonitorController@index');
    // Route::get('/Monitoring', function () {
    //     return view('content.monitoring');
    // });
    // Route::get('/Monitoring/Act', function () {
    //     return view('content.monitoring');
    // });
    Route::get('/Monitoring/print', function () {
        return view('content.printmonitoring');
    });
    Route::post('/Monitoring/print','MonitorController@proses2')->name('monitorprint');
    Route::post('/Monitoring/proses', 'MonitorController@proses')->name('monitoringproses');

    
    Route::get('/logout',  'LoginController@logout')->name('logout');
    

    Route::get('/Research','ResearchController@index');
    Route::get('/EquipmentPlan','EquipmentPlanController@index');
    Route::post('/EquipmentPlan/getVesBerth','EquipmentPlanController@getVesBerth');
    Route::post('/EquipmentPlan/getNodes','EquipmentPlanController@getNodes');
    Route::post('/EquipmentPlan/getEq','EquipmentPlanController@getEq');
    Route::post('/EquipmentPlan/getEqGroup','EquipmentPlanController@getEqGroup');
    Route::post('/EquipmentPlan/getEqPlanHour','EquipmentPlanController@getEqPlanHour');
    Route::post('/EquipmentPlan/getEqTruckReady','EquipmentPlanController@getEqTruckReady');
    Route::post('/EquipmentPlan/getShiftMinMax','EquipmentPlanController@getShiftMinMax');
    Route::post('/EquipmentPlan/getShiftMinMax2Day','EquipmentPlanController@getShiftMinMax2Day');
    Route::post('/EquipmentPlan/save','EquipmentPlanController@save');
    Route::post('/EquipmentPlan/saveTruck','EquipmentPlanController@saveTruck');
    Route::get('/EquipmentPlan/print/{tipe}/{manager}/{planner}','EquipmentPlanController@print');
    Route::get('/EquipmentPlan/print_spk','EquipmentPlanController@print_spk');
    
    Route::get('/EquipmentPlanAsg','EquipmentPlanAsgController@index');
    Route::post('/EquipmentPlanAsg/getData','EquipmentPlanAsgController@getData');
    Route::post('/EquipmentPlanAsg/save','EquipmentPlanAsgController@save');



    Route::get('/YardPlan','YardPlanController@index');
    Route::post('/YardPlan/getVesBerth','YardPlanController@getVesBerth');
    Route::post('/YardPlan/getBlock','YardPlanController@getBlock');
    Route::post('/YardPlan/getDestination','YardPlanController@getDestination');



    Route::get('/MonEquipmentPlan','MonEquipmentPlanController@index');
    Route::post('/MonEquipmentPlan/getVesBerth','MonEquipmentPlanController@getVesBerth');
    Route::post('/MonEquipmentPlan/getNodes','MonEquipmentPlanController@getNodes');
    Route::post('/MonEquipmentPlan/getEq','MonEquipmentPlanController@getEq');
    Route::post('/MonEquipmentPlan/getEqGroup','MonEquipmentPlanController@getEqGroup');
    Route::post('/MonEquipmentPlan/getEqPlanHour','MonEquipmentPlanController@getEqPlanHour');
    Route::post('/MonEquipmentPlan/getEqTruckReady','MonEquipmentPlanController@getEqTruckReady');
    Route::post('/MonEquipmentPlan/getShiftMinMax','MonEquipmentPlanController@getShiftMinMax');
    Route::post('/MonEquipmentPlan/getShiftMinMax2Day','MonEquipmentPlanController@getShiftMinMax2Day');
    Route::post('/MonEquipmentPlan/save','MonEquipmentPlanController@save');
    Route::post('/MonEquipmentPlan/saveTruck','MonEquipmentPlanController@saveTruck');
    Route::get('/MonEquipmentPlan/print/{tipe}/{manager}/{planner}','MonEquipmentPlanController@print');
    Route::get('/MonEquipmentPlan/print_spk/{date}','MonEquipmentPlanController@print_spk');

    Route::get('/print/export','PrintController@export');
});

Route::get('/print','PrintController@print')->name('print');
Route::get('/print/show','PrintController@show')->name('print_show');
Route::get('/print/blockkade','PrintController@blokirkade')->name('blokirkade');
Route::post('/print/arus','PrintController@arusminus')->name('arusminus');
Route::post('/print/grup','PrintController@grup')->name('grup');
Route::post('/print/qr','SignatureController@qrcode')->name('printQr');
Route::post('/print/getvessel', 'PrintController@getvessel')->name('print_getvessel');

Route::get('/eqp/show_pdf','EquipmentPlanController@show_pdf');
Route::get('/eqp/show_spk','EquipmentPlanController@show_spk');

Route::get('/Signature/qrcode','SignatureController@qrcode');

Route::get('/Signature/qr', function () {
    return view('content.signature.signature_qr');
});


