<?php

namespace App\Http\Controllers;
use SoapClient;
use Session;


use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function loginForm()
    {
        // return view('login.login');

        if (!session('berhasil_login')){
        return view('login.login');
        } else {
            return redirect()->back();
        }
    }

    public function login(Request $request){
        // dd($request->all());
            $username=$request->username;
            $pass=$request->pass;


            $url="your url login";
            $client=new SoapClient($url);
            $p = $client->valLoginAkun([
                "xIDAPLIKASI"=>"42",
                "xUsername"=>$username,
                "xPassword"=>$pass
            ]);
            $response=$p->valLoginAkunResult;
            // dd($response);
            // E-002 user/pas salah
            if ($response->responType == "S"){                        
                session(['berhasil_login'=>true]);
                session(['hak_akses'=> $response->HAKAKSES_DESC]);
                session(['data'=> $response->NAMA]);
                session(['id'=> $response->IDUSER]);
                session(['email'=> $response->EMAIL]);
                session(['hp'=> $response->HP]);
                return redirect('/role');
            } else {
                return redirect('/')->with('message', 'Username atau Password salah');
            }
           
    }

    public function roleForm()
    {
        if (!session('form_role')){
            return view('login.role');
        } else {
            return redirect()->back();
        }   
    }

    public function role()
    {
        session(['form_role'=>true]);

        $hak_akses= [Session::get('hak_akses')];
        return response()->json($hak_akses);
    }

    public function rolesession(Request $request)
    {
        $session=$request->param_role;
        session(['role'=> $session]);
        return response()->json($session);

    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
