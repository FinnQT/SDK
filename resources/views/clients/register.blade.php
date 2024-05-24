@extends('layout')
@section('title')
    Register
@endsection
@section('link')
    <link rel="stylesheet" href="{{ asset('assets\clients\popup.css') }}">
@endsection
@section('body-class', 'hold-transition register-page')
@section('content')
    <div class="register-box">
        <div class="register-logo">
            <a href=""><b>ĐĂNG KÝ</b></a>
        </div>
        <div class="card shadow rounded p-1">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Đăng ký 1 tài khoản mới</p>
                <form action="{{ route('register.post') }}" method="post" id="form-register">
           
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Nhập tên tài khoản" name="username"
                                value="{{ old('username') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div id="username-error" style="color: red"></div>
                    </div>
                  
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Nhập mật khẩu" name="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div id="password-error" style="color: red"></div>
                    </div>
              
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" name="cpassword">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div id="cpassword-error" style="color: red"></div>
                    </div>
             
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Nhập mã bảo vệ (bảo mật cấp 2)"
                                name="protect_code">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div id="protect_code-error" style="color: red"></div>
                    </div>
               
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Nhập email" name="email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div id="email-error" style="color: red"></div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mb-2">Đăng Ký</button>
                    @csrf
                </form>
                <p class="text-center">
                    <a href="{{ route('login') }}"><b>Quay lại</b></a>
                </p>
            </div>
        </div>
    </div>
    {{-- pop up success --}}
    <div class="container-popup">
        <div class="background-blur" id="background-blur"></div>
        <div class="popup" id="popup">
            <img src="{{ asset('assets\clients\image\accept.png') }}" alt="">
            <h2>Thành công</h2>
            <p>Bạn đăng ký thành công, quay lại trang đăng nhập!!</p>
            <button onclick="closePopup()" class="">oke</button>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function closePopup() {
            let popup = document.getElementById("popup");
            let backgroundblur = document.getElementById("background-blur");
            popup.classList.remove("open-popup");
            backgroundblur.classList.remove("open-background-blur");
            window.location.href = "{{ route('login') }}";
        }
        function openPopup() {
            $('#popup').addClass("open-popup");
            $('#background-blur').addClass("open-background-blur");
        }
        $(function() {
            $("#form-register").submit(function(e) {
                e.preventDefault();
                var formData = $('#form-register').serialize();
                $.ajax({
                    url: "{{ route('register.post') }}",
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == 200) {
                            openPopup();
                            $('#messages-fail').css('display', 'none');
                        } else {
                            if (res.messages) {
                                $('#messages-fail').html(res.messages);
                                $('#messages-fail').css('display', 'block');
                            } else {
                                $('#messages-fail').css('display', 'none');
                                if (res.message.username) {
                                    $('#username-error').html(res.message.username[0]);
                                } else {
                                    $('#username-error').empty();
                                }
                                if (res.message.password) {
                                    $('#password-error').html(res.message.password[0]);
                                } else {
                                    $('#password-error').empty();
                                }

                                if (res.message.cpassword) {
                                    $('#cpassword-error').html(res.message.cpassword[0]);
                                } else {
                                    $('#cpassword-error').empty();
                                }

                                if (res.message.protect_code) {
                                    $('#protect_code-error').html(res.message.protect_code[0]);
                                } else {
                                    $('#protect_code-error').empty();
                                }
                                if (res.message.email) {
                                    $('#email-error').html(res.message.email[0]);
                                } else {
                                    $('#email-error').empty();
                                }
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
