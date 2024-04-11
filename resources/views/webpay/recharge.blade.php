@extends('webpay/layout')
@section('title')
    recharge
@endsection

@section('content')
    @include('webpay/menubar')
    <div class="row d-flex justify-content-center align-items-center">
        <div class="form-napvi col-md-4 p-5">
            <form action="{{ route('recharge.post') }}" method="POST">
                <div class="group-field-alert  mb-3">
                    <div style="color: gray">
                        <h6>Loại thẻ</h6>
                    </div>
                    <select name="type-pay" id="type-pay" style="width:100%;" onchange=handleSelection()>
                        <option value="none">---Loại thẻ---</option>
                        <option value="gate">Gate</option>
                        <option value="momo">Momo</option>
                        <option value="telco">Telco</option>
                    </select>
                </div>
                <div style="color: gray">
                    <h6>Mệnh Giá: Vnđ</h6>
                </div>
                
                <div class="group-field-alert  mb-3" >
                    <select name="blank_selection" id="blank_selection" style="width:100%;">
                        <option value="">Vui lòng chọn loại thẻ</option>
                    </select>
                    <select name="pick_money" id="pick_money" style="width:100%; display:none;">
                        <option value="0">---Chọn mệnh giá---</option>
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
                        <div class="input-group border border-warning rounded-3" >
                            <input type="text" name="fill_money" class="form-control bg-light fs-6"
                                placeholder="Nhập mệnh giá">
                        </div>
                    </div>
                </div>
                <div class="group-field-alert mb-3">
                    <div style="color: gray">
                        <h6>Seri</h6>
                    </div>
                    <div class="input-group border border-warning rounded-3">
                        <input type="text" name="seri" class="form-control bg-light fs-6" placeholder="Nhập seri">
                    </div>
                </div>
                <div class="group-field-alert mb-3">
                    <div style="color: gray">
                        <h6>Pin</h6>
                    </div>
                    <div class="input-group border border-warning rounded-3">
                        <input type="text" name="pin" class="form-control bg-light fs-6" placeholder="Nhập Seri">
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Xác Nhận</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function handleSelection() {
            var selectedValue = document.getElementById("type-pay").value
            if (selectedValue === "none") {
                document.getElementById("blank_selection").style.display = "block";
                document.getElementById("pick_money").style.display = "none";
                document.getElementById("fill_money").style.display = "none";
            } else if (selectedValue === "gate") {
                document.getElementById("blank_selection").style.display = "none";
                document.getElementById("pick_money").style.display = "block";
                document.getElementById("pick_money").value= "0";
                document.getElementById("fill_money").style.display = "none";
            } else {
                document.getElementById("blank_selection").style.display = "none";
                document.getElementById("pick_money").style.display = "none";
                document.getElementById("fill_money").style.display = "block";
                document.getElementById("pick_money").value= "0";
            }
        }
    </script>
@endsection
