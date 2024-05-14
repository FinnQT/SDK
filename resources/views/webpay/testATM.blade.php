@extends('webpay/layout')
@section('title')
    Login
@endsection
@section('link')
@endsection
@section('content')
    @include('webpay/menubar')
    @include('webpay/bannerslide')
    <div class="container">
        <div class="history-page text-center row d-flex justify-content-center align-items-center">
            <div class="col-md-4">
              <h1>Thông Tin Request dạng JSON</h1>
              <pre>{{ $jsonRequest }}</pre>
            </div>
        </div>
    </div>
@endsection
