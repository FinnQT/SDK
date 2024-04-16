@extends('clients/layout')
@section('title')
    Register
@endsection
@section('link')
    <link rel="stylesheet" href="{{ asset('assets\clients\popup.css') }}">
@endsection
@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border p-3 d-flex justify-content-center align-items-center bg-white  m-2 box-login-area"
            style="max-width: 600px;">
            <div class="mb-4 d-flex justify-content-center align-items-center login-logo">
                <a href="" class="fs-2" style="text-decoration:none; color:black;"><b>ĐĂNG KÝ</b></a>
            </div>
            <div class="login-card-body mb-4 shadow rounded-4 p-5" style="max-width: 400px;">
                <form action="{{ route('register.post') }}" method="POST" id="form-register">
                    <div class="alert alert-danger" id="messages-alert" style="display: none;"></div>
                    <div class="group-field-alert mb-3">
                        <div class="input-group border border-warning rounded-3">
                            <input type="text" name="username" value="{{ old('username') }}"
                                class="form-control bg-light fs-6" placeholder="NHẬP TÀI KHOẢN" style="border:none;">
                            <div class="input-group-append">
                                <div class="input-group-text" style="height:100%; border: none;">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div id="username-error" style="color: red"></div>
                    </div>
                    <div class="group-field-alert mb-3">
                        <div class="input-group border border-warning rounded-3">
                            <input type="password" name="password" class="form-control bg-light fs-6"
                                placeholder="NHẬP MẬT KHẨU" style="border:none;">
                            <div class="input-group-append">
                                <div class="input-group-text" style="height:100%; border: none;">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div id="password-error" style="color: red"></div>
                    </div>
                    <div class="group-field-alert mb-3">
                        <div class="input-group border border-warning rounded-3">
                            <input type="password" name="cpassword" class="form-control bg-light fs-6"
                                placeholder="NHẬP LẠI MẬT KHẨU" style="border:none;">
                            <div class="input-group-append">
                                <div class="input-group-text" style="height:100%; border: none;">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div id="cpassword-error" style="color: red"></div>
                    </div>
                    <div class="group-field-alert mb-3">
                        <div class="input-group border border-warning rounded-3">
                            <input type="password" name="protect_code" class="form-control bg-light fs-6"
                                placeholder="NHẬP MÃ BẢO VỆ" style="border:none;">
                            <div class="input-group-append">
                                <div class="input-group-text" style="height:100%; border: none;">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div id="protect_code-error" style="color: red"></div>
                    </div>
                    <div class="group-field-alert mb-3">
                        <div class="input-group border border-warning rounded-3">
                            <input type="email" name="email" class="form-control bg-light fs-6" placeholder="NHẬP EMAIL"
                                style="border:none;">
                            <div class="input-group-append">
                                <div class="input-group-text" style="height:100%; border: none;">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div id="email-error" style="color: red"></div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">ĐĂNG KÝ</button>
                    </div>
                    @csrf
                </form>
                <div>
                    <p class="text-center mt-3">
                        <a href="{{ route('login') }}" style="text-decoration:none; color:black;">Quay Lại</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-popup">
        <div class="backgroud-blur" id="background-blur"></div>
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
        $(function() {
            $("#form-register").submit(function(e) {
                e.preventDefault();
                var formData = $('#form-register').serializ();
                $.ajax({
                    url: "{{ route('register.post') }}",
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == 200) {
                            $('#popup').addClass("open-popup");
                            $('#background-blur').addClass("open-background-blur");
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
