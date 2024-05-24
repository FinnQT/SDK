@extends('webpay/layout')
@section('title')
    recharge
@endsection
@section('link')
    <link rel="stylesheet" href="{{ asset('assets\clients\popupCharge.css') }}">
    <link rel="stylesheet" href="{{ asset('assets\clients\popupError.css') }}">
    <link rel="stylesheet" href="{{ asset('assets\clients\loader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets\clients\popup.css') }}">
@endsection
@section('body-class', 'hold-transition sidebar-mini sidebar-collapse')
@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid ">
                <div class="row  d-flex justify-content-center">
                    <div class="col-md-6 mt-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Đổi Thẻ cào - Nạp bằng QR code</h3>
                            </div>
                            <form action="" method="POST" id="form-card">
                                <input type="hidden" name="usernameRq" value="{{ $data->username }}" id="hiddenField">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="alert alert-danger" id="messages-fail" style="display: none;"></div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Loại Thẻ</th>
                                                <td>
                                                    <select class="form-control" name="type_pay" id="type-pay"
                                                        style="width:100%;" onchange=handleSelection()>
                                                        <option value="">Loại thẻ</option>
                                                        <option value="CardInputGate">Gate</option>
                                                        <option value="QRCode">QRCode Banking</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Mệnh Giá</th>
                                                <td>
                                                    <div class="group-field-alert  mb-3">
                                                        <select class="form-control" id="blank_selection"
                                                            style="width:100%;">
                                                            <option value="">Vui lòng chọn loại thẻ</option>
                                                        </select>
                                                        <select class="form-control" name="monney_pick" id="droplist_money"
                                                            style="width:100%; display:none;"
                                                            onchange="handleSelectMonney()">
                                                            <option value="">---Chọn mệnh giá---</option>
                                                            <option value="10000">10,000</option>
                                                            <option value="20000">20,000</option>
                                                            <option value="50000">50,000</option>
                                                            <option value="100000">100,000</option>
                                                            <option value="200000">200,000</option>
                                                            <option value="500000">500,000</option>
                                                            <option value="1000000">1,000,000</option>
                                                            <option value="2000000">2,000,000</option>
                                                            <option value="5000000">5,000,000</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                              
                                                <tr>
                                                    <th>Seri</th>
                                                    <td>
                                                        <div class="group-field-alert mb-3">
                                                            <input type="text" class="form-control"
                                                                placeholder="Nhập mã seri" id="seri" name="seri">
                                                            <div id="seri-error" style="color: red"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Pin</th>
                                                    <td>
                                                        <div class="group-field-alert mb-3">
                                                            <input type="text" id="pin" name="pin"
                                                                class="form-control" placeholder="Nhập mã pin">
                                                            <div id="pin-error" style="color: red"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <button type="submit" class="btn btn-primary btn-block float-left">Nạp Ngay</button>
                                </div>
                                @csrf
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>

                {{-- loader --}}
                <div id="loader" class="loader-overlay" style="display: none">
                    <div class="loader-circle"></div>
                </div>

                {{-- popup comfirm --}}
                <div class="overlay" id="overlay">
                    <div class="confirm-box">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>Xác nhận nạp thẻ</div>
                            <span class="close" onclick="closeBox()">&times;<span>
                        </div>
                        <div class="line" style="width: 100%;height: 1px;background-color: #969292;"></div>
                        <table>
                            <th>Thẻ:</th>
                            <td id="popup_type_pay"></td>
                            </tr>
                            <tr>
                                <th>Serial:</th>
                                <td id="popup_seri"></td>
                            </tr>
                            <tr>
                                <th>Mã thẻ:</th>
                                <td id="popup_pin"></td>
                            </tr>
                        </table>
                        <h5>MUỘI SẼ KHÔNG HOÀN TRẢ <br>
                            NẾU THÔNG TIN CỦA HUYNH KHÔNG CHÍNH XÁC
                        </h5>
                        <div class="line" style="width: 100%;height: 1px;background-color: #969292;"></div>
                        <div class="buttons">
                            <button onclick="cancel()">Hủy</button>
                            <button class="btn-confirm" onclick="confirm()">Xác nhận</button>
                        </div>
                    </div>
                </div>

                {{-- popup error --}}
                <div class="error_popup" id="error_popup">
                    <div class="error_popup_box">
                        <div class="d-flex justify-content-between align-items-center">
                            <div style="color: red;">Lỗi thông tin thẻ </div>
                            <span class="close_error" onclick="closeErrorBox()">&times;<span>
                        </div>
                        <div class="line" style="width: 100%;height: 1px;background-color: #969292;"></div>
                        <p id="error_details">mã thẻ lỗi</p>
                        <div class="line" style="width: 100%;height: 1px;background-color: #969292;"></div>
                        <div class="buttons">
                            <button class="btn_confirm_error" onclick="confirm_error()">OK</button>
                        </div>
                    </div>
                </div>
                {{-- popup success --}}
                <div class="container-popup">
                    <div class="background-blur" id="background-blur"></div>
                    <div class="popup" id="popup">
                        <img src="{{ asset('assets\clients\image\accept.png') }}" alt="">
                        <h2>Thành công</h2>
                        <p>Bạn đã nạp thành công, quay lại ví!!</p>
                        <button onclick="closePopup()" class="">oke</button>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

@endsection
@section('script')
    <script>
        //handle selection type pay-----------------------------------------------------------------------
        function handleSelection() {
            var selectedValue = document.getElementById("type-pay").value
            if (selectedValue !== "") {
                document.getElementById("blank_selection").style.display = "none";
                if (selectedValue === "CardInputGate") {
                    $('#seri-error').empty();
                    $('#pin-error').empty();
                    $('#messages-fail').css('display', 'none');
                    document.getElementById("droplist_money").style.display = "block";
                    document.getElementById("droplist_money").value = "";
                    document.getElementById("seri").style.pointerEvents = "auto";
                    document.getElementById("seri").style.opacity  = "1";
                    document.getElementById("pin").style.pointerEvents = "auto";
                    document.getElementById("pin").style.opacity  = "1";
                } else {
                    $('#messages-fail').css('display', 'none');
                    document.getElementById("droplist_money").value = "";
                    document.getElementById("droplist_money").style.display = "block";
                    document.getElementById("seri").style.pointerEvents ='none';
                    document.getElementById("seri").style.opacity  ='0.2';
                    document.getElementById("pin").style.pointerEvents ='none';
                    document.getElementById("pin").style.opacity ='0.2';
                }
            } else {
                $('#seri-error').empty();
                $('#pin-error').empty();
                $('#messages-fail').css('display', 'none');
                document.getElementById("blank_selection").style.display = "block";
                document.getElementById("droplist_money").style.display = "none";
            }
        }

        function handleSelectMonney() {
            var selectedValue = document.getElementById("droplist_money").value;
            if (selectedValue !== "") {
                $('#messages-fail').css('display', 'none');
            }
        }
        //error popup
        function openErrorBox(error) {
            document.getElementById("error_popup").style.display = "block";
            document.getElementById("error_details").textContent = error;
        }

        function closeErrorBox() {
            document.getElementById("error_popup").style.display = "none";
        }

        function confirm_error() {
            closeErrorBox();
        }
        // pop up success
        function closePopup() {
            let popup = document.getElementById("popup");
            let backgroundblur = document.getElementById("background-blur");
            popup.classList.remove("open-popup");
            backgroundblur.classList.remove("open-background-blur");
            window.location.href = "{{ route('dashboardPay') }}";
        }

        function openPopup() {
            $('#popup').addClass("open-popup");
            $('#background-blur').addClass("open-background-blur");
        }
        // Popup confirm form----------------------------------------------------------------------
        function openBox() {
            document.getElementById("overlay").style.display = "block";
            const type_pay = document.getElementById("type-pay");
            const selectedOptionName = type_pay.options[type_pay.selectedIndex].text;
            document.getElementById("popup_type_pay").innerText = selectedOptionName;
            const seri = document.getElementById("seri");
            document.getElementById("popup_seri").innerText = seri.value;
            const pin = document.getElementById("pin");
            document.getElementById("popup_pin").innerText = pin.value;
            document.getElementById("overlay").style.display = "block";
        }

        function closeBox() {
            document.getElementById("overlay").style.display = "none";
        }

        function cancel() {
            closeBox();
        }

        //confirm payment
        function confirm() {
            var formData = $("#form-card").serialize();
            $("#loader").show();
            $.ajax({
                url: "{{ route('recharge.post') }}",
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    if (res.status == 200) {
                        $("#loader").hide();
                        if (res.type_pay == "CardInputGate") {
                            openPopup();
                        } else if (res.type_pay == "QRCODE") {
                            $("#loader").hide();
                            var dataRes = res.result;
                            var url = "{{ route('qrcode') }}?dataList=" + encodeURIComponent(JSON.stringify(
                                dataRes));
                            window.location.href = url;
                        }
                    } else {
                        $("#loader").hide();
                        openErrorBox(res.message_code);
                    }
                }
            });
            closeBox();
        }
        //function validate form add to card-----------------------------------------------------------------
        $(function() {
            $("#form-card").submit(function(e) {
                e.preventDefault();
                var formData = $("#form-card").serialize();
                $.ajax({
                    url: "{{ route('recharge.check') }}",
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(res) {
                        $('#seri-error').empty();
                        $('#pin-error').empty();
                        $('#messages-fail').css('display', 'none');
                        if (res.status == 200) {
                            if (res.type_pay == "CardInputGate") {
                                openBox();
                            } else {
                                confirm();
                            }
                        } else {
                            if (res.message_validate) {
                                $('#messages-fail').html(res.message_validate);
                                $('#messages-fail').css('display', 'block');
                            } else {
                                $('#messages-fail').css('display', 'none');
                                if (res.message.seri) {
                                    $('#seri-error').html(res.message.seri[0]);
                                } else {
                                    $('#seri-error').empty();
                                }
                                if (res.message.pin) {
                                    $('#pin-error').html(res.message.pin[0]);
                                } else {
                                    $('#pin-error').empty();
                                }
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
