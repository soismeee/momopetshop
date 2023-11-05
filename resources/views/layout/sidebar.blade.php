<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ url('/home') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="/assets/images/logo_momopetshop.png" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/logo_momopetshop.png" alt="" height="28">
            </span>
        </a>

        <a href="{{ url('/home') }}" class="logo logo-light">
            <span class="logo-lg">
                <img src="/assets/images/logo_momopetshop.png" alt="" height="30">
            </span>
            <span class="logo-sm">
                <img src="/assets/images/logo_momopetshop.png" alt="" height="26">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
        <i class="bx bx-menu align-middle"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Dashboard</li>

               <li>
                    <a href="{{ url('/home') }}">
                        <i class="bx bx-home-alt icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                @can('Admin')
                <li>
                    <a href="{{ route('usr.index') }}">
                        <i class="bx bx-user-circle icon nav-icon"></i>
                        <span class="menu-item" data-key="t-pengguna">Pengguna</span>
                    </a>
                </li>
                @endcan

                @can('Customer')
                <li>
                    <a href="{{ route('ck') }}">
                        <i class="bx bx-shopping-bag icon nav-icon"></i>
                        <span class="menu-item" data-key="t-keranjang">Keranjang</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-receipt icon nav-icon"></i>
                        <span class="menu-item" data-key="t-transaksi">Daftar Orders</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('co') }}" data-key="t-inbox">Daftar Order</a></li>
                        <li><a href="{{ route('ctt') }}" data-key="t-read-email">Daftar Treatment</a></li>
                    </ul>
                </li>  
                @endcan

                @if (Gate::check('Admin') || Gate::check('Karyawan'))
                    
                <li class="menu-title" data-key="t-applications">Master</li>

                {{-- <li>
                    <a href="{{ route('dc') }}">
                        <i class="bx bx-user-voice icon nav-icon"></i>
                        <span class="menu-item" data-key="t-customers">Data Pelanggan</span>
                    </a>
                </li> --}}

                <li>
                    <a href="{{ route('dh.index') }}">
                        <i class="bx bx-bath icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Data Hewan</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-file icon nav-icon"></i>
                        <span class="menu-item" data-key="t-tables">Data Kategori</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('dkh.index') }}" data-key="t-basic-tables">Kategori Jenis Hewan</a></li>
                        <li><a href="{{ route('dkph.index') }}" data-key="t-basic-tables">Kategori Peralatan Hewan</a></li>
                        <li><a href="{{ route('dkp.index') }}" data-key="t-advanced-tables">Kategori Pakan</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-server icon nav-icon"></i>
                        <span class="menu-item" data-key="t-tables">Data Master</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('dph.index') }}" data-key="t-basic-tables">Peralatan Hewan</a></li>
                        <li><a href="{{ route('dp.index') }}" data-key="t-advanced-tables">Pakan</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-cuboid icon nav-icon"></i>
                        <span class="menu-item" data-key="t-icons">Data Pembelian</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('pb') }}" data-key="t-evaicons">Barang</a></li>
                        <li><a href="{{ url('ph') }}" data-key="t-boxicons">Hewan</a></li>
                    </ul>
                </li>
                
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-file-find icon nav-icon"></i>
                        <span class="menu-item" data-key="t-tables">Stok Opname</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('sopp') }}" data-key="t-basic-tables">Peralatan dan pakan</a></li>
                        <li><a href="{{ route('soh') }}" data-key="t-advanced-tables">Hewan</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('dt.index') }}">
                        <i class="bx bx-paste icon nav-icon"></i>
                        <span class="menu-item" data-key="t-todo">Data Treatment</span>
                    </a>
                </li>

                <li class="menu-title" data-key="t-layouts">Invoice</li>
                
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-receipt icon nav-icon"></i>
                        <span class="menu-item" data-key="t-invoices">Invoices</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('do') }}" data-key="t-invoice-list">Data Order</a></li>
                        <li><a href="{{ route('dit') }}" data-key="t-invoice-detail">Treatment</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-file icon nav-icon"></i>
                        <span class="menu-item" data-key="t-utility">laporan</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('lo') }}" data-key="t-error-404">Laporan Penjualan</a></li>
                        <li><a href="{{ route('lt') }}" data-key="t-error-500">Laporan Treatment</a></li>
                    </ul>
                </li>
                @endif

                @can('Customer')
                <li class="menu-title" data-key="t-applications">Semua produk</li>
                
                <li>
                    <a href="{{ route('ch') }}">
                        <i class="bx bx-bath icon nav-icon"></i>
                        <span class="menu-item" data-key="t-in_hewan">Hewan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('cph') }}">
                        <i class="bx bx-box icon nav-icon"></i>
                        <span class="menu-item" data-key="t-in_peralatan_hewan">Peralatan Hewan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('cp') }}">
                        <i class="bx bx-food-menu icon nav-icon"></i>
                        <span class="menu-item" data-key="t-in_pakan">Pakan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('ct') }}">
                        <i class="bx bx-check-square icon nav-icon"></i>
                        <span class="menu-item" data-key="t-in_treatment">Treatment</span>
                    </a>
                </li>
                @endcan

                <li>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalLogout">
                        <i class="bx bx-log-out icon nav-icon"></i>
                        <span class="menu-item" data-key="t-horizontal">Keluar</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->