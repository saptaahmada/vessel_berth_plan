<?php

namespace App\Http\Controllers;

use SoapClient;
use Session;
use App\MPic;
use DB;

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


            $url="http://sittl.teluklamong.co.id/wsouth.asmx?wsdl";
            $client=new SoapClient($url);
            $p = $client->valLoginAkun([
                "xIDAPLIKASI"=>"42",
                "xUsername"=>$username,
                "xPassword"=>$pass
                // "xUsername"=>$username,
                // "xPassword"=>$pass
            ]);
            // 210797001
            // Pelindo3
            $response=$p->valLoginAkunResult;
            // dd($response);
            // E-002 user/pas salah
            if ($response->responType == "S"){
                session(['berhasil_login'=>true]);
                session(['hak_akses'=> $response->HAKAKSES_DESC]);
                session(['data'=> $response->NAMA]);
                session(['id'=> $response->IDUSER]);
                session(['nipp'=> $response->USERNAME]);
                session(['email'=> $response->EMAIL]);
                session(['hp'=> $response->HP]);
                return redirect('/role');
            } else if ($response->responType == "E-010"){
                return redirect('/')->with('message', 'Akses Anda Telah Diblokir!!');
            } else {
                return redirect('/')->with('message', 'Username atau Password salah');
            }
           
    }

    public function login_customer_1(Request $request)
    {
        $result = MPic::where('HP', $request->hp)->get();

        if(count($result) > 0) {
            $mpic = $result[0];
            $code = rand(1000,9999);
            $result = DB::table('CBSLAM.VIER_PIC_REQ_LOGIN')->insert([
                'HP'        => $mpic->hp,
                'VERIF_CODE'=> $code,
            ]);
            if($result) {
                $text = "*[NO-REPLY] VIERA*\n\nTerima Kasih telah mengakses Aplikai VIERA, Kode verifikasi login OTP anda adalah *{$code}* .\n\nMohon tidak memberitahukan Kode OTP anda ke orang lain.\n\n(Generate by TTL System)";
                send_wa($mpic->hp, $text);

                return response()->json([
                    'success'   => true,
                    'message'   => '<div class="alert alert-success">Kode verifikasi sudah dikirimkan di nomor WhatsApp anda, Silahkan masukkan kode verifikasi di kolom kode verifikasi</div>'
                ]);
            }
            return response()->json([
                'success'   => false,
                'message'   => "<div class='alert alert-danger'>Terjadi kesalahan sistem</div>"
            ]);
        }
        return response()->json([
            'success'   => false,
            'message'   => "<div class='alert alert-danger'>Anda tidak punya hak akses</div>"
        ]);
    }

    public function login_customer_2(Request $request)
    {
        $sysdate = date('Y-m-d H:i:s');

        $result = DB::table('CBSLAM.VIER_PIC_REQ_LOGIN')
            ->where('HP', $request->hp)
            ->where('VERIF_CODE', $request->code)
            ->where('IS_CLOSED', '0')
            // ->whereDate('EXPIRED_DATE', '>=', $sysdate)
            ->get();

        if(count($result) > 0) {
            $arr_mpic = MPic::where('HP', $request->hp)->get();

            if(count($arr_mpic) > 0) {
                
                $mpic = $arr_mpic[0];

                DB::table('CBSLAM.VIER_PIC_REQ_LOGIN')
                    ->where('HP', $mpic->hp)
                    ->update([
                        'IS_CLOSED' => '1'
                    ]);

                session(['berhasil_login'=>true]);
                session(['data'=> $mpic->email]);
                session(['data_pic'=> $arr_mpic]);
                // session(['agent'=> $mpic->agent]);
                // session(['id'=> $mpic->id]);
                // session(['email'=> $mpic->email]);
                // session(['hp'=> $mpic->hp]);
                session(['role'=> 'CUSTOMER']);
                return response()->json([
                    'success'   => true,
                    'message'   => "Success"
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => "<div class='alert alert-danger'>Anda tidak punya hak akses</div>"
                ]);
            }
        } else {
            return response()->json([
                'success'   => false,
                'message'   => "<div class='alert alert-danger'>Anda tidak punya hak akses</div>"
            ]);
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
        if($session == 'PIC PDS') {
            session(['plan_type'=> 'PDS']);
        } else if($session == 'PIC BDS') {
            session(['plan_type'=> 'BDS']);
        }
        session(['role'=> $session]);
        return response()->json($session);

    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
