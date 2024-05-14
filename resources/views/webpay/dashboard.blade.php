@extends('webpay/layout')
@section('title')
    Dasboard
@endsection

@section('content')
    @include('webpay/menubar')
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-4" style="margin-top: 20px;">
                <h3>welcome to dashboard Pay</h3>
                <hr>
                <table class="table">
                    <tr>
                        <th>Tài khoản</th>
                        <td>{{ $data->username }}</td>
                    </tr>
                    <tr>
                        <th>Số dư</th>
                        <td>{{ $data->balance }} xu</td>
                    </tr>
                    <tr>
                        <th>Thông tin tài khoản</th>
                        <td><a href="{{ route('account') }}">CẬP NHẬT</a></td>
                    </tr>
                    <tr>
                        <th>Lịch sử nạp</th>
                        <td><a href="{{ route('history') }}">XEM</a></td>
                    </tr>
                </table>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('recharge') }}" style="background-color: rgb(203, 203, 249); color: black"
                        class="p-4">nạp ví</a>
                    <a href="" style="background-color: rgb(251, 213, 213); color: black" class="p-4">nạp game</a>
                </div>
            </div>
        </div>
    </div>
@endsection
