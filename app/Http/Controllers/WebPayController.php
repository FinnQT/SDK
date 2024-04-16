<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\RequestData;
use App\Models\ResponseData;
use Illuminate\Support\Facades\Validator;
use App\Models\XMLSerializer;
use Illuminate\Http\Response;
use nusoap_client;


class WebPayController extends Controller
{
    public function login()
    {
        return view('webpay/loginpay');
    }
    function loginPost(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Vui lòng nhập tên tài khoản',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        $user = DB::table('users')->where('username', $request->username)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('loginIdPay', $user->id);
                return redirect()->route('dashboardPay');
            } else {
                return back()->with('fail', 'Mật khẩu không chính xác');
            }
        } else {
            return back()->with('fail', 'Tài khoản không tồn tại!');
        }
    }

    public function dashboard()
    {
        $data1 = array();
        if (Session::has('loginIdPay')) {
            $data1 = DB::table('users')->where('id', Session::get('loginIdPay'))->first();
        }
        return view('webpay/dashboard', compact('data1'));
    }

    public function logout()
    {
        if (Session::has('loginIdPay')) {
            Session::pull('loginIdPay');
            return redirect()->route('loginPay');
        } else {
            return redirect()->route('loginPay');
        }
    }
    public function recharge()
    {
        return view('webpay/recharge');
    }
    //connect server with cardinput
    public function CardInput($typePay, $money, $seri, $pin)
    {
        $client = new nusoap_client('https://sandbox-ops.gate.vn:7001/Igate_WS/Route?wsdl', 'wsdl');
        $client->decode_utf8 = false;
        $err = $client->getError();
        if ($err) {
            return "fasle";
        }
        // Doc/lit parameters get wrapped
        $ServiceName = $typePay;
        $rq = new RequestData();
        $rq->MerchantID = 3485;
        $rq->Username = "chuquyetthang";
        $rq->CardSerial = $seri;
        $rq->CardPIN = $pin;
        $rq->FunctionName = "CardInput";
        $rq->TelcoServiceCode = "10034850002";
        $rq->PartnerTransactionID = rand(10000000, 110000000);

        //$private_key = "1253.key";
        //$private_key_pass = "ce709fb4";
        //$secretkey = "17711e2261c0dd70ea2f4954c39d1dbe";  

        $private_key = base_path('app/Http/Controllers/3485.key');
        $private_key_pass = "f77ee102";
        $secretkey = "1348a8cd0bfb561841d9ec3654595d21";
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

        $result = $client->call('ProcessRequest', $param, '', '', false, true);
        if ($client->fault) {
            return "false";
        } else {
            // Check for errors
            $err = $client->getError();
            if ($err) {
                return "false";
            } else {
                $values = explode('|', $result['return']);
                $data = [
                    'ErrorCode' => isset($values[0]) ? $values[0] : null,
                    'Description' => isset($values[1]) ? $values[1] : null,
                    'TransactionID' => isset($values[2]) ? $values[2] : null,
                    'PartnerTransactionID' => isset($values[3]) ? $values[4] : null,
                    'CardAmount' => isset($values[4]) ? $values[4] : null,
                    'VendorTransactionID' => isset($values[5]) ? $values[5] : null,
                ];
                return $data;
            }
        }
    }
    // validate form
    public function rechargecheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seri' => 'required',
            'pin' => 'required'

        ], [
            'seri.required' => 'Vui lòng nhập mã pin',
            'pin.required' => 'Vui lòng nhập seri'
        ]);

        switch ($request->type_pay) {
            case '':
                return response()->json([
                    'status' => 400,
                    'message_validate' => "Vui lòng chọn loại thẻ"
                ]);
            case 'CardInputGate':
                if (!$request->monney_GATE) {
                    return response()->json([
                        'status' => 400,
                        'message_validate' => "Vui lòng chọn mệnh giá"
                    ]);
                } else {
                    if ($validator->fails()) {
                        return response()->json([
                            'status' => 400,
                            'message' => $validator->getMessageBag()
                        ]);
                    } else {
                        return response()->json([
                            'status' => 200,
                            'message' => 'success'
                        ]);
                    }
                }
            default:
                if (!$request->monney_Fill) {
                    return response()->json([
                        'status' => 400,
                        'message_validate' => "Vui lòng nhập mệnh giá"
                    ]);
                } else {
                    if ($validator->fails()) {
                        return response()->json([
                            'status' => 400,
                            'message' => $validator->getMessageBag()
                        ]);
                    } else {
                        return response()->json([
                            'status' => 200,
                            'message' => 'success'
                        ]);
                    }
                }
        }

    }
    // get response from server
    public function rechargePost(Request $request)
    {
        switch ($request->type_pay) {
            case 'CardInputGate':
                $result = $this->CardInput($request->type_pay, $request->monney_GATE, $request->seri, $request->pin);
                if ($result == "fasle") {
                    return response()->json([
                        "status" => 400,
                        'message_code' => "Có lỗi gì đó trong việc kết nối đến hệ thống server"
                    ]);
                } else if ($result['ErrorCode'] != "00") {
                    return response()->json([
                        "status" => 400,
                        "message_code" => $result['Description']
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'result' => $result
                    ]);
                }
            case'Momo':
                break;
            case'Bank':
                break;
            default:
                break;
        }

    }




    // public function rechargePost(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'seri' => 'required',
    //         'pin' => 'required'

    //     ], [
    //         'seri.required' => 'Vui lòng nhập mã pin',
    //         'pin.required' => 'Vui lòng nhập seri'
    //     ]);

    //     switch ($request->type_pay) {
    //         case '':
    //             return response()->json([
    //                 'status' => 400,
    //                 'message_validate' => "Vui lòng chọn loại thẻ"
    //             ]);
    //         case 'momo':
    //             break;
    //         case 'CardInputGate':
    //             if (!$request->monney_GATE) {
    //                 return response()->json([
    //                     'status' => 400,
    //                     'message_validate' => "Vui lòng chọn mệnh giá"
    //                 ]);
    //             } else {
    //                 if ($validator->fails()) {
    //                     return response()->json([
    //                         'status' => 400,
    //                         'message' => $validator->getMessageBag()
    //                     ]);
    //                 } else {
    //                     $result = $this->CardInput($request->type_pay, $request->monney_GATE, $request->seri, $request->pin);
    //                     if ($result == "fasle") {
    //                         return response()->json([
    //                             "status" => 400,
    //                             'message_code' => "Có lỗi gì đó trong việc kết nối đến hệ thống server"
    //                         ]);
    //                     } else if ($result['ErrorCode'] != "00") {
    //                         return response()->json([
    //                             "status" => 400,
    //                             "message_code" => $result['Description']
    //                         ]);
    //                     } else {

    //                         return response()->json([
    //                             'status' => 200,
    //                             'result' => $result
    //                         ]);
    //                     }
    //                 }
    //             }
    //         default:
    //             break;
    //     }
    // }
}
