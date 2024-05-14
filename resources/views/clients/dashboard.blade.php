@extends('clients/layout')
@section('title')
Dasboard
@endsection
@section('content')
 <div class="container">
  <div class="row">
      <div class="col-md-4 col-md-offset-4" style="margin-top: 20px;">
          <h3>ĐĂNG NHẬP THÀNH CÔNG</h3>
          <hr>
          <table class="table">
              <thead>
                <th>UserName</th>
                <th>Email</th>
                <th>Action</th>
              </thead>
              <tbody>
                <tr>
                  <td>{{ $data->username }}</td>
                  <td>{{ $data->email }}</td>
                  <td><a href="{{ route('logout') }}">Logout</a></td>
                </tr>
              </tbody>
          </table>
      </div>
  </div>
 </div>
 <div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="row border p-3 d-flex justify-content-center align-items-center bg-white m-2 box-login-area" style="max-width: 600px;">
      <div class="mb-4 d-flex justify-content-center align-items-center login-logo">
          <a href="" class="fs-2" style="text-decoration:none; color:black;"><b>ĐĂNG NHẬP</b></a>
      </div>
      <div class="login-card-body mb-4 shadow rounded-4 p-5" style="max-width: 400px;">
          <form action="{{ route('login.post') }}" method="POST">
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
          <div class="btn-group d-flex justify-content-between ">
              <div class="">
                  <a href="{{ route('register') }}" class="btn btn-lg btn-primary fs-6">ĐĂNG KÝ</a>
              </div>
              <div class="">
                  <a href="{{ route('forgot') }}" class="btn btn-lg btn-primary fs-6">QUÊN MẬT KHẨU</a>
              </div>
          </div>
          <div>
              <p class="text-center mt-3">
                  <a href="" style="text-decoration:none; color:black;">Chơi Ngay</a>
              </p>
          </div>
      </div>
  </div>
</div>
@endsection

