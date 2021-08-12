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

Route::get('/login2', function () {
    return view('login.login2');
});







// Route::get('/Home', 'HomeController@parkingbackup')->name('vessel');


Route::group(['middleware'=> 'CekLogin'],function(){
    Route::get('/role', 'LoginController@roleForm')->name('role');
    Route::get('/role/proses',  'LoginController@role')->name('roleproses');
    Route::post('/role/session',  'LoginController@rolesession')->name('rolesession');

    Route::get('/Dashboard', function () {
        return view('content.dashboard');
    });
   
    Route::get('/Monitoring', function () {
        return view('content.berthplan2');
    });
    Route::post('/Monitoring/proses',  'MonitorController@proses')->name('monitoringproses');

    Route::get('/VesselBerthPlan', 'HomeController@parkingbackup')->name('vessel'); 
    Route::get('/VesselBerthPlan/getvessel', 'HomeController@getvessel')->name('getvessel');
    Route::post('/VesselBerthPlan/addvessel', 'HomeController@addvessel')->name('addvessel');
    Route::get('/VesselBerthPlan/getdermaga', 'HomeController@getdermaga')->name('getdermaga');
    Route::post('/VesselBerthPlan/updatevessel', 'HomeController@updatevessel')->name('updatevessel');
    Route::get('/VesselBerthPlan/getcrane', 'HomeController@getcrane')->name('getcrane');
    Route::get('/VesselBerthPlan/getport', 'HomeController@getport')->name('getport');
    Route::get('/VesselBerthPlan/getsignature', 'HomeController@getsignature')->name('getsignature');
    
    Route::get('/VesselBerthPlan_Logo','HomeController@logo')->name('logo');
    Route::post('/VesselBerthPlan_Logo/updatelogo/{customer}','HomeController@updatelogo')->name('updatelogo');

    Route::get('/VesselBerthPlan3', 'Home3Controller@parkingbackup')->name('vessel3'); 
    Route::get('/VesselBerthPlan3/getvessel', 'Home3Controller@getvessel')->name('getvessel3');
    Route::post('/VesselBerthPlan3/addvessel', 'Home3Controller@addvessel')->name('addvessel3');
    Route::get('/VesselBerthPlan3/getdermaga', 'Home3Controller@getdermaga')->name('getdermaga3');
    Route::post('/VesselBerthPlan3/updatevessel', 'Home3Controller@updatevessel')->name('updatevessel3');
    Route::get('/VesselBerthPlan3/getcrane', 'Home3Controller@getcrane')->name('getcrane3');
    Route::get('/VesselBerthPlan3/getport', 'Home3Controller@getport')->name('getport3');
    Route::get('/VesselBerthPlan3/getsignature', 'Home3Controller@getsignature')->name('getsignature3');
    
    Route::get('/VesselBerthPlan_Logo','Home3Controller@logo')->name('logo3');
    Route::post('/VesselBerthPlan_Logo/updatelogo/{customer}','Home3Controller@updatelogo')->name('updatelogo3');
    
    Route::get('/Dermaga','DermagaController@index')->name('dermaga');
    Route::post('/Dermaga/add','DermagaController@add')->name('dermagaAdd');
    Route::post('/Dermaga/update','DermagaController@update')->name('dermagaUpdate');
    Route::post('/Dermaga/remove','DermagaController@remove')->name('dermagaRemove');
    Route::get('/Dermaga/json','DermagaController@json');
    

    Route::get('/Blokirkade','BlokirkadeController@index')->name('blokirkade');
    Route::post('/Blokirkade/add','BlokirkadeController@add')->name('blokirkadeAdd');
    Route::post('/Blokirkade/update','BlokirkadeController@update')->name('blokirkadeUpdate');
    Route::post('/Blokirkade/remove','BlokirkadeController@remove')->name('blokirkadeRemove');
    Route::get('/Blokirkade/json','BlokirkadeController@json');
    

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
    
    Route::get('/print','HomeController@print')->name('print');
    Route::get('/print/blockkade','PrintController@blokirkade')->name('blokirkade');

    Route::post('/print/qr','SignatureController@qrcode')->name('printQr');


    Route::get('/logout',  'LoginController@logout')->name('logout');
    
});




Route::get('/Signature/qr', function () {
    return view('content.signature.signature_qr');
});


