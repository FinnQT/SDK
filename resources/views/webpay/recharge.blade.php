@extends('webpay/layout')
@section('title')
    recharge
@endsection
@section('link')
    <link rel="stylesheet" href="{{ asset('assets\clients\popupCharge.css') }}">
@endsection
@section('content')
    @include('webpay/menubar')
    <div class="row d-flex justify-content-center align-items-center">
        <div class="form-card col-md-4 p-5">
            <div class="alert alert-danger" id="messages-fail" style="display: none;">
            </div>
            <form action="" method="POST" id="form-card">
                <div class="group-field-alert  mb-3">
                    <div style="color: gray">
                        <h6>Loại thẻ</h6>
                    </div>
                    <select name="type_pay" id="type-pay" style="width:100%;" onchange=handleSelection()>
                        <option value="">---Loại thẻ---</option>
                        <option value="CardInputGate">Gate</option>
                        <option value="Momo">Momo</option>
                        <option value="Bank">Bank</option>
                    </select>
                </div>
                <div style="color: gray">
                    <h6>Mệnh Giá: Vnđ</h6>
                </div>

                <div class="group-field-alert  mb-3">
                    <select id="blank_selection" style="width:100%;">
                        <option value="">Vui lòng chọn loại thẻ</option>
                    </select>
                    <select name="monney_GATE" id="discount-GATE" style="width:100%; display:none;">
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
                    <div id="fill_money" style="display:none;">
                        <div class="input-group border border-warning rounded-3">
                            <input type="text" name="monney_Fill" class="form-control bg-light fs-6"
                                placeholder="Nhập mệnh giá">
                        </div>
                    </div>
                </div>
                <div class="group-field-alert mb-3">
                    <div style="color: gray">
                        <h6>Seri</h6>
                    </div>
                    <div class="input-group border border-warning rounded-3">
                        <input id="seri" type="text" name="seri" class="form-control bg-light fs-6"
                            placeholder="Nhập mã seri">
                    </div>
                    <div id="seri-error" style="color: red"></div>
                </div>
                <div class="group-field-alert mb-3">
                    <div style="color: gray">
                        <h6>Pin</h6>
                    </div>
                    <div class="input-group border border-warning rounded-3">
                        <input type="text" id="pin" name="pin" class="form-control bg-light fs-6"
                            placeholder="Nhập mã pin">

                    </div>
                    <div id="pin-error" style="color: red"></div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Xác Nhận</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
    <div id="test">hahah</div>
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
@endsection
@section('script')
    <script>
        function handleSelection() {
            var selectedValue = document.getElementById("type-pay").value
            if (selectedValue !== "") {
                document.getElementById("blank_selection").style.display = "none";
                if (selectedValue === "CardInputGate") {
                    document.getElementById("discount-GATE").style.display = "block";
                    document.getElementById("fill_money").style.display = "none";
                }else{
                    document.getElementById("discount-GATE").style.display = "none";
                    document.getElementById("fill_money").style.display = "block";
                }
            }else{
                document.getElementById("blank_selection").style.display = "block";
                document.getElementById("discount-GATE").style.display = "none";
                document.getElementById("fill_money").style.display = "none";
            }
        }
        // Popup confirm form
        function openBox() {
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

        function confirm() {
            var formData = $("#form-card").serialize();
            $.ajax({
                url: "{{ route('recharge.post') }}",
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    if (res.status == 200) {
                        alert(res.result.Description);
                        $('#test').html(res.result.Description);
                        var a = res.ErrorCode;
                        $('#test').html(a);
                    } else {
                        alert('error');
                        $('#test').html(res.message_code);
                    }
                }
            });
            closeBox();
        }

        //function validate form
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
                        if (res.status == 200) {
                            $('#seri-error').empty();
                            $('#pin-error').empty();
                            $('#messages-fail').css('display', 'none');
                            openBox();
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
