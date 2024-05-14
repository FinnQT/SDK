@extends('webpay/layout')
@section('title')
    Dasboard
@endsection
@section('content')
    @include('webpay/menubar')
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-4" style="margin-top: 20px;">
                <h1>Received Request Data</h1>
                <h2>Headers</h2>
                <pre>{{ json_encode($requestData['headers'], JSON_PRETTY_PRINT) }}</pre>
                <h2>Body</h2>
                <pre>{{ json_encode($requestData['body'], JSON_PRETTY_PRINT) }}</pre>
                <h2>Request Method</h2>
                <p>{{ $requestData['method'] }}</p>
                <h2>Request URL</h2>
                <p>{{ $requestData['url'] }}</p>
                <h2>Full URL</h2>
                <p>{{ $requestData['fullUrl'] }}</p>
            </div>
        </div>
    </div>
@endsection
