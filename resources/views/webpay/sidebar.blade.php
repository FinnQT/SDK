<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 130vh;">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
        <img src="{{ asset('assets\clients\image\logo-ggo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Danh mục</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets\clients\image\hinh-anh-cute-anime-001.jpg') }}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Chu Quyết Thắng</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboardPay') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Trang Chủ
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Nạp Game
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('recharge') }}" class="nav-link">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Nạp Ví
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('account') }}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Tài Khoản
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>
                            Tỉ Giá
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('history') }}" class="nav-link">
                        <i class="nav-icon fas fa-history"></i>
                        <p>
                            Lịch Sử
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logoutPay') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Thoát
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

