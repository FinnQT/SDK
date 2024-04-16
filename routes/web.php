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

Route::prefix('clients')->group( function(){
  Route::get('/login',[AuthManager::class,'login'])->name('login')->middleware('alreadyLoggedIn');
  Route::post('/login',[AuthManager::class,'loginPost'])->name('login.post');
  Route::get('/register',[AuthManager::class,'register'])->name('register')->middleware('alreadyLoggedIn');
  Route::post('/register',[AuthManager::class,'registerPost'])->name('register.post');
  Route::get('/logout',[AuthManager::class,'logout'])->name('logout');
  Route::get('/dashboard',[AuthManager::class,'dashboard'])->name('dashboard')->middleware('isLoggedIn');
  Route::get('/forgot',[AuthManager::class,'forgot'])->name('forgot')->middleware('alreadyLoggedIn');
  Route::post('/forgotvalidate',[AuthManager::class,'forgotPostTest'])->name('forgot.validate');
  Route::post('/forgotnewpass',[AuthManager::class,'forgotPostNewPassword'])->name('forgot.newpass');
});



Route::prefix('webpay')->group( function(){
  Route::get('/login', [WebPayController::class,'login'])->name('loginPay')->middleware('alreadyLoggedInPay');
  Route::post('/login', [WebPayController::class,'loginPost'])->name('loginPay.post');
  Route::get('/dashboard',[WebPayController::class,'dashboard'])->name('dashboardPay')->middleware('isLoggedInPay');  
  Route::get('/logout',[WebPayController::class,'logout'])->name('logoutPay')->middleware('isLoggedInPay');
  Route::get('/recharge',[WebPayController::class,'recharge'])->name('recharge')->middleware('isLoggedInPay');
  Route::post('/rechargeCheck',[WebPayController::class,'rechargecheck'])->name('recharge.check');
  Route::post('/recharge',[WebPayController::class,'rechargePost'])->name('recharge.post');
});

