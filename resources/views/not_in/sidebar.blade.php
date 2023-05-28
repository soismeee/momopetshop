<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="/" class="logo logo-dark">
            <span class="logo-sm">
                <img src="/assets/images/logo_momopetshop.png" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/logo_momopetshop.png" alt="" height="28">
            </span>
        </a>

        <a href="index.html" class="logo logo-light">
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
                    <a href="{{ url('/') }}">
                        <i class="bx bx-home-alt icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <li class="menu-title" data-key="t-applications">Semua produk</li>
                
                <li>
                    <a href="{{ route('h') }}">
                        <i class="bx bx-basketball icon nav-icon"></i>
                        <span class="menu-item" data-key="t-notin_hewan">Hewan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('ph') }}">
                        <i class="bx bx-file-find icon nav-icon"></i>
                        <span class="menu-item" data-key="t-notin_peralatan_hewan">Peralatan Hewan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('p') }}">
                        <i class="bx bx-calendar-event icon nav-icon"></i>
                        <span class="menu-item" data-key="t-notin_pakan">Pakan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('t') }}">
                        <i class="bx bx-check-square icon nav-icon"></i>
                        <span class="menu-item" data-key="t-notin_treatment">Treatment</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->