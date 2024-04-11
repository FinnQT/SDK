<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class WebPayController extends Controller
{
    public function login(){
        return view('webpay/loginpay');
    }
    function loginPost(Request $request){
        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ],[
            'username.required'=>'Vui lòng nhập tên tài khoản',
            'password.required'=>'Vui lòng nhập mật khẩu',
        ]);

        $user = DB::table('users')->where('username', $request->username)->first();
        if($user){
            if(Hash::check($request->password,$user->password)){
                $request->session()->put('loginIdPay',$user->id);
                return redirect()->route('dashboardPay');
            }else{
                return back()->with('fail','Mật khẩu không chính xác');
            }
        }else{
            return back()->with('fail','Tài khoản không tồn tại!');
        }
    }

    public function dashboard(){
        $data1 = array();
        if(Session::has('loginIdPay')){
            $data1 = DB::table('users')->where('id', Session::get('loginIdPay'))->first();
        }
        return view('webpay/dashboard',compact('data1'));
    }

    public function logout(){
        if(Session::has('loginIdPay')){
            Session::pull('loginIdPay');
            return redirect()->route('loginPay');
        }else{
            return redirect()->route('loginPay');
        }
    } 
    public function recharge(){
        return view('webpay/recharge');
    }


    public function rechargePost(Request $request){
        dd($request);
    }
}
