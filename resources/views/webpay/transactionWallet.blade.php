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
      <div class="transactionWallet text-center row d-flex justify-content-center align-items-center">
        <div  class="col-md-8">
          <h2>LỊCH SỬ NẠP VÍ</h2>
    
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>STT</th>
                  <th>Mã GD</th>
                  <th>Loại</th>
                  <th>Serial</th>
                  <th>Mệnh giá</th>
                  <th>Trạng thái</th>
                  <th>Nội dung</th>
                  <th>Thời gian</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($transaction as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->transactionID }}</td>
                    <td>{{ $transaction->type_pay }}</td>
                    <td>{{ $transaction->serial }}</td>
                    <td>{{ $transaction->ammount }}</td>
                    <td>  {{ $transaction->status == 1 ? 'Thành công' : ($transaction->status == 0 ? 'Đang xử lý' : 'Thất bại') }}</td>
                    <td>{{ $transaction->desc }}</td>
                    <td>{{ $transaction->time }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
      </div>
    </div>
@endsection
