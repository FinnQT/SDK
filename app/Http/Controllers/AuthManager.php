<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthManager extends Controller
{
    public function login(){
       
        return view('clients/login');
    }
    public function register(){
        return view('clients/register');
    }

    public function loginPost(Request $request){


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
                $request->session()->put('loginUsername',$user->username);
                return redirect()->route('dashboard');
            }else{
                return back()->with('fail','Mật khẩu không chính xác');
            }
        }else{
            return back()->with('fail','Tài khoản không tồn tại!');
        }
    }

    public function registerPost(Request $request){
        $validator =Validator::make($request->all(),[
            'username'=>'required|unique:users|min:6|max:12|regex:/^[a-zA-Z0-9\s]+$/',
            'password'=>'required|min:6|max:12|regex:/^(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]+$/',
            'cpassword'=>'required|same:password',
            'email'=>'required|email|unique:users',
            'protect_code'=>'required|min:6|max:12|regex:/^(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]+$/'
        ],[
            'username.required'=>'Vui lòng nhập tên tài khoản',
            'username.min'=>'Tài khoản chứa tối thiểu 6 kí tự',
            'username.max'=>'Tài khoản chứa tối đa 12 kí tự',
            'username.regex'=>'Tài khoản không được chứa ký tự đặc biệt',
            'username.unique'=>'Tên tài khoản tồn tại',
            'password.required'=>'Vui lòng nhập mật khẩu',
            'password.min'=>'Mật khẩu chứa tối thiểu 6 kí tự',
            'password.max'=>'Mật khẩu chứa tối đa 12 kí tự',
            'password.regex'=>'Mật khẩu phải chứa chữ cái in hoa, không chứa ký tự đặc biệt',
            'cpassword.required'=>'Vui lòng nhập lại mật khẩu',
            'cpassword.same'=>'Mật khẩu không trùng khớp',
            'email.required'=>'Vui lòng nhập email',
            'email.email'=>'email đã được sử dụng',
            'email.unique'=>'Email đã tồn tại',
            'protect_code.required'=>'Vui lòng nhập mã bảo vệ',
            'protect_code.min'=>'Mã bảo vệ chứa tối thiểu 6 kí tự',
            'protect_code.max'=>'Mã bảo vệ chứa tối đa 12 kí tự',
            'protect_code.regex'=>'Mã bảo vệ chứa chữ cái in hoa, không chứa ký tự đặc biệt',

        ]);
        
        if($validator->fails()){
           
            return response()->json([
                'status'=>400,
                'message'=>$validator->getMessageBag()
            ]);
        }else{
            
            $username=$request->username;
            $email=$request->email;
            $password=Hash::make($request->password);
            $protect_code=$request->protect_code;
            $uuid= (string) Uuid::uuid4();
            $created_at = now(); 
            
            $res=DB::table('users')->insert([
                'uuid'=>$uuid,
                'username'=>$username,
                'email'=>$email,
                'password'=>$password,
                'protect_code'=>$protect_code,
                'created_at'=> $created_at
        ]);
        if($res){
            // return back()->with('success','Bạn đăng ký thành công');
            return response()->json([
                'status'=>200,
                'messages'=>'Đăng ký thành công'
            ]);
        }else{
            // return back()->with('fail','Có lỗi đã xảy ra');
            return response()->json([
                'status'=>400,
                'messages'=>'Đăng ký lỗi'
            ]);
        }
        }
    }

    //go to dashboard
    public function dashboard(){
        $data = array();
        if(Session::has('loginUsername')){
            $data = DB::table('users')->where('username', Session::get('loginUsername'))->first();
        }
        return view('clients/dashboard',compact('data'));
    }
    public function logout(){
        if(Session::has('loginUsername')){
            Session::pull('loginUsername');
            return redirect()->route('login');
        }
        return redirect()->route('login');
    } 

    public function forgot(){
        return view('clients/forgot');
    }


    public function forgotPostTest(Request $request){
        $validator =Validator::make($request->all(),[
            'username'=>'required',
            'protect_code'=>'required'
        ],[
            'username.required'=>'Vui lòng nhập tên tài khoản',
            'protect_code.required'=>'Vui lòng nhập mã bảo vệ',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>$validator->getMessageBag()
            ]);
        }else{

            $user = DB::table('users')->where('username', $request->username)->first();
            if($user){
                if($request->protect_code==$user->protect_code){
                    $username=$user->username;
                    
                    return response()->json([
                        'username'=>$username,
                        'status'=>200,
                        'messages'=>'Xác nhận thành công',
                    ]);
                }else{
                    return response()->json([
                        'status'=>400,
                        'messages'=>'Sai mã bảo vệ',
                        'message'=>$validator->getMessageBag()
                    ]);
                }
            }else{
                return response()->json([
                    'status'=>400,
                    'messages'=>'Không tồn tại user',
                    'message'=>$validator->getMessageBag()

                ]);
            }
        }
    }
    public function forgotPostNewPassword(Request $request){
        $validator =Validator::make($request->all(),[
            'password'=>'required|min:6|max:12|regex:/^(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]+$/',
            'cpassword'=>'required|same:password',
        ],[
            'password.required'=>'Vui lòng nhập mật khẩu',
            'password.min'=>'Mật khẩu chứa tối thiểu 6 kí tự',
            'password.max'=>'Mật khẩu chứa tối đa 12 kí tự',
            'password.regex'=>'Mật khẩu phải chứa chữ cái in hoa, không chứa ký tự đặc biệt',
            'cpassword.required'=>'Vui lòng nhập lại mật khẩu',
            'cpassword.same'=>'Mật khẩu không trùng khớp',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>$validator->getMessageBag()
            ]);
        }else{
            $password=Hash::make($request->password);
            $affected = DB::table('users')
              ->where('username', $request->hidden_value)
              ->update(['password' => $password]);
            if($affected){ 
                return response()->json([
                    'status'=>200,
                    'messages'=>'Đăng ký thành công'
                ]);
            }else{
                return response()->json([
                    'status'=>400,
                    'messages'=>'Đăng ký lỗi'
                ]);
            }
        }
    }
}
