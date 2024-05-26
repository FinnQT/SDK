<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\WebPayController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('template_custome', function () {
  return view('register_layout');
});
Route::get('admin', function () {
  return view('admin/admin');
});
Route::prefix('clients')->group( function(){
  Route::get('/login',[AuthManager::class,'login'])->name('login')->middleware('alreadyLoggedIn');
  Route::post('/login',[AuthManager::class,'loginPost'])->name('login.post');
  Route::get('/register',[AuthManager::class,'register'])->name('register')->middleware('alreadyLoggedIn');
  Route::post('/register',[AuthManager::class,'registerPost'])->name('register.post');
  Route::get('/logout',[AuthManager::class,'logout'])->name('logout');
  Route::get('/dashboard',[AuthManager::class,'dashboard'])->name('dashboard')->middleware('isLoggedIn');
  Route::get('/forgot',[AuthManager::class,'forgot'])->name('forgot')->middleware('alreadyLoggedIn');
  Route::post('/forgot/validate',[AuthManager::class,'forgotPostTest'])->name('forgot.validate');
  Route::post('/forgot/newpass',[AuthManager::class,'forgotPostNewPassword'])->name('forgot.newpass');
 
});



Route::prefix('webpay')->group( function(){
  Route::get('/login', [WebPayController::class,'login'])->name('loginPay')->middleware('alreadyLoggedInPay');
  Route::post('/login', [WebPayController::class,'loginPost'])->name('loginPay.post');
  Route::get('/dashboard',[WebPayController::class,'dashboard'])->name('dashboardPay')->middleware('isLoggedInPay');  
  Route::get('/logout',[WebPayController::class,'logout'])->name('logoutPay')->middleware('isLoggedInPay');
  Route::get('/recharge',[WebPayController::class,'recharge'])->name('recharge')->middleware('isLoggedInPay');
  Route::post('/recharge/checkValidate',[WebPayController::class,'rechargecheck'])->name('recharge.check');
  Route::post('/recharge',[WebPayController::class,'rechargePost'])->name('recharge.post');
  Route::get('/history',[WebPayController::class,'history'])->name('history')->middleware('isLoggedInPay');  
  Route::get('/account',[WebPayController::class,'account'])->name('account')->middleware('isLoggedInPay');  
  // exchange rate
  Route::get('/exchange_rate',[WebPayController::class,'exchange_rate'])->name('exchange_rate')->middleware('isLoggedInPay');  

  //update info user
  Route::post('/account/updateName',[WebPayController::class,'updateName'])->name('update.Name');
  Route::post('/account/updateLocation',[WebPayController::class,'updateLocation'])->name('update.Location');
  Route::post('/account/updateCCCD',[WebPayController::class,'updateCCCD'])->name('update.CCCD');

  //generate qr code
  Route::get('/recharge/qrcode',[WebPayController::class,'qrCode'])->name('qrcode');
  
  // execute recharge
  Route::get('/recharge/transactionSuccess/{id}',[WebPayController::class,'transactionSuccess'])->name('transactionSuccess');
  Route::get('/recharge/timeouts/{id}',[WebPayController::class,'timeouts'])->name('timeouts');




  // history
  Route::get('/history/transactionWallet',[WebPayController::class,'transactionWallet'])->name('transactionWallet')->middleware('isLoggedInPay');
  Route::get('/history/transactionGame',[WebPayController::class,'transactionGame'])->name('transactionGame')->middleware('isLoggedInPay');




});

