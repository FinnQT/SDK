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
@endsection

