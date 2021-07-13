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
   

    Route::get('/VesselBerthPlan', 'HomeController@parkingbackup')->name('vessel')->middleware('CekLogin'); 
    Route::get('/VesselBerthPlan/getvessel', 'HomeController@getvessel')->name('getvessel');
    Route::post('/VesselBerthPlan/addvessel', 'HomeController@addvessel')->name('addvessel');
    Route::get('/VesselBerthPlan/getdermaga', 'HomeController@getdermaga')->name('getdermaga');
    Route::post('/VesselBerthPlan/updatevessel', 'HomeController@updatevessel')->name('updatevessel');
    Route::get('/VesselBerthPlan/getcrane', 'HomeController@getcrane')->name('getcrane');
    Route::get('/VesselBerthPlan/getport', 'HomeController@getport')->name('getport');
    Route::get('/VesselBerthPlan/getsignature', 'HomeController@getsignature')->name('getsignature');
    
    Route::get('/VesselBerthPlan_Logo','HomeController@logo')->name('logo');
    Route::post('/VesselBerthPlan_Logo/updatelogo/{customer}','HomeController@updatelogo')->name('updatelogo');
    
    Route::get('/Dermaga','DermagaController@index')->name('dermaga');
    Route::post('/Dermaga/add','DermagaController@add')->name('dermagaAdd');
    Route::post('/Dermaga/update','DermagaController@update')->name('dermagaUpdate');
    Route::post('/Dermaga/remove','DermagaController@remove')->name('dermagaRemove');
    Route::get('/Dermaga/json','DermagaController@json');
    
    Route::get('/Signature','SignatureController@index')->name('signature');
    Route::post('/Signature/add','SignatureController@add')->name('signatureAdd');
    Route::post('/Signature/update','SignatureController@update')->name('signatureUpdate');
    Route::post('/Signature/remove','SignatureController@remove')->name('signatureRemove');
    Route::get('/Signature/json','SignatureController@json');
    
    Route::get('/print','HomeController@print')->name('print');
    Route::post('/print/qr','SignatureController@qrcode')->name('printQr');
    Route::get('/logout',  'LoginController@logout')->name('logout');
    
});




Route::get('/Signature/qr', function () {
    return view('content.signature.signature_qr');
});


