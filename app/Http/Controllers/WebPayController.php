<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\RequestData;
use App\Models\XMLSerializer;
use nusoap_client;


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

        $client = new nusoap_client('https://sandbox-ops.gate.vn:7001/Igate_WS/Route?wsdl', 'wsdl');
        $client->decode_utf8 = false;
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
        }
        // Doc/lit parameters get wrapped

        $ServiceName = "CardInputGate";

        $rq = new RequestData();
        $rq->MerchantID = 1328;
        $rq->Username = "afelix";
        $rq->CardSerial = "FC00000000";
        $rq->CardPIN = "1111111111";
        $rq->FunctionName = "CardInput";
        $rq->TelcoServiceCode = "10010080002";
        $rq->PartnerTransactionID = rand(10000000, 110000000);

        //$private_key = "1253.key";
        //$private_key_pass = "ce709fb4";
        //$secretkey = "17711e2261c0dd70ea2f4954c39d1dbe";  

        $private_key = base_path('app/Http/Controllers/1328.key');
        $private_key_pass = "279020dc";
        $secretkey = "3fbf7b1d2c373bb02422e5165dd32b8f";
        //var_dump($rq);
        $OriginalData = sprintf("%d%s%s%s%s%s", $rq->MerchantID, $rq->Username, $rq->CardSerial, $rq->CardPIN, $rq->TelcoServiceCode, $secretkey);



        if (openssl_sign($OriginalData, $Signature, array(file_get_contents($private_key), $private_key_pass))) {
            $Signature = base64_encode($Signature);
        }

        $rq->Signature = $Signature;


        $xmlSerializer = new XMLSerializer();
        $request = $xmlSerializer->generateValidXmlFromObj($rq, "RequestData");

        $param = array(
            'arg0' => $ServiceName,
            'arg1' => $request
        );
        echo $request, "<br>";
        //print_r($param);

        $result = $client->call('ProcessRequest', $param, '', '', false, true);
        // Check for a fault
        if ($client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        } else {
            // Check for errors
            $err = $client->getError();
            if ($err) {
                // Display the error
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                // Display the result
                
                //print_r($result);	
                echo '<h2>OriginalData</h2><pre>';
                print_r($OriginalData);
                echo '<h2>Result</h2><pre>';
                print_r($result);
                echo '</pre>';
            }
        }
        echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
        echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';

        return $client->response;
        //echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
    }
}
