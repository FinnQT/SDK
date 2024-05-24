@extends('webpay/layout')
@section('title')
    Login
@endsection
@section('link')
@endsection
@section('body-class', 'hold-transition sidebar-mini sidebar-collapse')
@section('content')
    <div class="container">
        <div class="Details-page d-flex justify-content-center align-content-center">
            <div class=" col-md-6">
                <table class="table">
                    <tr>
                        <th>TÊN ĐĂNG NHẬP:</th>
                        <td id="username">{{ $data->username }}</td>
                    </tr>
                    <tr>
                        <th>EMAIL:</th>
                        <td><input type="text" value="{{ $data->email }}" name="detail_email" id="detail_email" disabled>
                        </td>
                    </tr>
                    <tr>
                        <th>MÃ BẢO VỆ:</th>
                        <td><input type="text" value="{{ $data->protect_code }}" name="detail_protect_code"
                                id="detail_protect_code" disabled></td>
                        <td><a href="">cập nhật</a></td>
                    </tr>
                    <tr>
                        <th>HỌ VÀ TÊN:</th>
                        <form action="" method="POST" id="form-updateName">
                            @csrf
                            <td><input type="text" value="{{ $data->name }}" name="detail_name" id="detail_name"></td>
                            <td><button type="submit">cập nhật</button></td>
                        </form>

                    </tr>
                    <tr>
                        <th>ĐỊA CHỈ</th>
                        <form action="" method="POST" id="form-updateLocation">
                            @csrf
                            <td><input type="text" value="{{ $data->location }}" name="detail_location"
                                    id="detail_location"></td>
                            <td><button type="submit">cập nhật</button></td>
                        </form>
                        < </tr>
                    <tr>
                        <th>SỐ CCCD</th>
                        <form action="" method="POST" id="form-updateCCCD">
                            @csrf
                            <td><input type="text" value="{{ $data->CCCD }}" name="detail_CCCD" id="detail_CCCD"></td>
                            <td><button type="submit">cập nhật</button></td>
                        </form>
                    </tr>
                </table>
            </div>
        </div>
    @endsection
    @section('script')
        <script>
            $(function() {
                $("#form-updateName").submit(function(e) {
                    e.preventDefault();
                    var formData = $('#form-updateName').serialize();
                    $.ajax({
                        url: "{{ route('update.Name') }}",
                        method: "POST",
                        data: formData,
                        dataType: 'json',
                        success: function(res) {
                            if (res.status == 200) {
                                alert("Cập nhật thành công");
                            } else {
                                alert(res.message);
                            }
                        }
                    });
                });

                $("#form-updateLocation").submit(function(e) {
                    e.preventDefault();

                    var formData = $('#form-updateLocation').serialize();
                    $.ajax({
                        url: "{{ route('update.Location') }}",
                        method: "POST",
                        data: formData,
                        dataType: 'json',
                        success: function(res) {
                            if (res.status == 200) {
                                alert("Cập nhật thành công");
        
                            } else {
                                alert(res.message);
                            }
                        }
                    });
                });
                
                $("#form-updateCCCD").submit(function(e) {
                    e.preventDefault();
                    var formData = $('#form-updateCCCD').serialize();
                    $.ajax({
                        url: "{{ route('update.CCCD') }}",
                        method: "POST",
                        data: formData,
                        dataType: 'json',
                        success: function(res) {
                            if (res.status == 200) {
                                alert("Cập nhật thành công");
                            } else {
                                alert(res.message);
                            }
                        }
                    });
                });
            });
        </script>
    @endsection
