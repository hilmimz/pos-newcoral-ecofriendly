<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-1" href="{{ route('home.index') }}"><img style="width: 30px" class="rounded" src="{{ asset('/images/logo.jpg') }}"> Newcoral Ecofriendly</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Seller</div>
                    <a class="nav-link" href="{{ route('inputpenjualan.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-pen"></i></div>
                        Input Penjualan
                    </a>
                    <a class="nav-link" href="{{ route('riwayatpenjualan.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-clock-rotate-left"></i></div>
                        Riwayat Penjualan
                    </a>
                    <a class="nav-link" href="{{ route('terimabarang.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-truck-ramp-box"></i></div>
                        Terima Barang
                    </a>
                    @can('admin')
                    <div class="sb-sidenav-menu-heading">Admin</div>
                    <a class="nav-link" href="{{ route('pengiriman.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-paper-plane"></i></div>
                        Pengiriman Barang
                    </a>
                    <a class="nav-link" href="{{ route('stokbarang.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-cube"></i></div>
                        Stok Barang
                    </a>
                    <a class="nav-link" href="{{ route('daftarpenjual.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Daftar Penjual
                    </a>
                    <a class="nav-link" href="{{ route('penjualan.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Penjualan
                    </a>
                    <a class="nav-link" href="{{ route('barang.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-shirt"></i></div>
                        Daftar Barang
                    </a>
                    <a class="nav-link" href="{{ route('kategori.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-grip"></i></div>
                        Daftar Kategori
                    </a>
                    <a class="nav-link" href="{{ route('bahan.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa-brands fa-pagelines"></i></div>
                        Daftar Bahan
                    </a>
                    <a class="nav-link" href="{{ route('warna.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-palette"></i></div>
                        Daftar Warna
                    </a>
                    <a class="nav-link" href="{{ route('cabang.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-shop"></i></div>
                        Daftar Cabang
                    </a>
                    @endcan
                </div>
            </div>
            <div class="sb-sidenav-footer">
                @auth
                <div class="text-muted"><h6>Logged in as: {{ auth()->user()->nama }}</h6> </div>
                @if (Session::has('cabang'))
                    <div class="text-muted"><h6>Cabang: {{ Session::get('cabang') }}</h6> </div>
                @endif
                @if (auth()->user()->is_admin == 1)
                    <div class="text-muted"><h6>Admin</h6> </div>
                @endif
                <form action="{{ route('login.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm mt-2" >Logout</button>
                </form>
                @endauth
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">