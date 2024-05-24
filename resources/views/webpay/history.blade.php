@extends('webpay/layout')
@section('title')
    Login
@endsection
@section('link')
@endsection
@section('body-class', 'hold-transition sidebar-mini sidebar-collapse')
@section('content')
    <div class="container">
      <div class="history-page text-center row d-flex justify-content-center align-items-center">
        <div  class="col-md-4">
          <h2>LỊCH SỬ</h2>
          <div class="d-flex justify-content-between">
            <a href="{{ route('transactionWallet') }}" style="background-color: rgb(203, 203, 249); color: black"
            class="p-4">Lịch sử nạp ví</a>
            <a href="{{ route('transactionGame') }}" style="background-color: rgb(251, 213, 213); color: black" class="p-4">Lịch sử nạp game</a>
          </div>
        </div>
      </div>
    </div>
@endsection
