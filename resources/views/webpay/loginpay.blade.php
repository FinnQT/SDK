@extends('webpay/layout')
@section('title')
    Login
@endsection
@section('link')
@endsection
@section('content')
@include('webpay/menubar')
@include('webpay/bannerslide')
    <div class="container d-flex justify-content-center align-items-center">
        <div class="row p-3 d-flex justify-content-center align-items-center bg-white m-2 box-login-area" style="max-width: 600px;">
            
            <div class="mb-4 d-flex justify-content-center align-items-center login-logo">
                <a href="" class="fs-2" style="text-decoration:none; color:black;"><b>ĐĂNG NHẬP</b></a>
            </div>
            <div class="login-card-body mb-4 shadow rounded-4 p-5" style="max-width: 400px;">
                <form action="{{ route('loginPay.post') }}" method="POST">
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::has('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                    @endif
                    <div class="group-field-alert  mb-3">
                        <div style="color: gray"><h6>Tài Khoản</h6></div>
                        <div class="input-group border border-warning rounded-3">
                            <input type="text" name="username" value="{{ old('username') }}"
                                class="form-control bg-light fs-6" placeholder="NHẬP TÀI KHOẢN" style="border:none;">
                            <div class="input-group-append"> 
                                <div class="input-group-text" style="height:100%; border: none;">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        @error('username')
                            <span style="color: red";>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="group-field-alert mb-3">
                        <div style="color: gray"><h6>Mật Khẩu</h6></div>
                        <div class="input-group border border-warning rounded-3">
                            <input type="password" name="password" class="form-control bg-light fs-6"
                                placeholder="NHẬP MẬT KHẨU" style="border:none;">
                            <div class="input-group-append">
                                <div class="input-group-text" style="height:100%; border: none;">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        @error('password')
                            <span style="color: red";>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">ĐĂNG NHẬP</button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection
