<div class="d-flex" style="position: relative;
                          padding-left:20px;
                          padding-right:20px;
                          background-color:aqua">
                          
    <div class="dropdown text-left">
      <button class="btn btn-secondary " type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-bars"></i>
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Trang chủ</a></li>
        <li><a class="dropdown-item" href="#">Nạp game</a></li>
        <li><a class="dropdown-item" href="{{ route('recharge')}}">Nạp ví</a></li>
        <li><a class="dropdown-item" href="#">Tài khoản</a></li>
        <li><a class="dropdown-item" href="#">Tỉ giá</a></li>
        <li><a class="dropdown-item" href="#">Lịch sử</a></li>
        <li><a class="dropdown-item" href="{{ route('logoutPay')}}">Thoát</a></li>
      </ul>
    </div>
      <div class="" style="position: absolute ;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);">
        LOGO game
      </div>
</div>