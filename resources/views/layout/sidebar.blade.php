<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand mt-3">
            <a href="{{ url('/') . '/' . auth()->user()->level }}/dashboard">
                <img src="{{ asset('sinyo.jpeg') }}" width="50px" alt="Logo" class="logo">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('dashboard') }}">
                <img src="{{ asset('sinyo.jpeg') }}" alt="Logo" width="50px" class="logo-sm">
            </a>
        </div>
        <div class="sidebar-brand">
            <a href="{{ url('/') . '/' . auth()->user()->level }}/dashboard">Kedai Terungku</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('dashboard') }}">KD</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown">
                <a href="{{ url(auth()->user()->level . '/dashboard') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Menu</li>
            @if (auth()->user()->level == 'admin')
                <li class="dropdown">
                    <a href="{{ url(auth()->user()->level . '/kategori') }}" class="nav-link"><i
                            class="fas fa-list"></i><span>Kategori</span></a>
                </li>
                <li class="dropdown">
                    <a href="{{ url(auth()->user()->level . '/satuan') }}" class="nav-link"><i
                            class="fas fa-box"></i><span>Satuan</span></a>
                </li>
                <li class="dropdown">
                    <a href="{{ url(auth()->user()->level . '/barang') }}" class="nav-link"><i
                            class="fas fa-boxes"></i><span>Barang</span></a>
                </li>
            @endif
            @if (auth()->user()->level == 'kasir')
                <li class="dropdown">
                    <a href="{{ url(auth()->user()->level . '/penjualan') }}" class="nav-link"><i
                            class="fas fa-shopping-cart"></i><span>Transaksi</span></a>
                </li>
            @endif
            @if (auth()->user()->level == 'admin')
                <li class="dropdown">
                    <a href="{{ url(auth()->user()->level . '/laporan') }}" class="nav-link"><i
                            class="fas fa-file"></i><span>Laporan</span></a>
                </li>
                {{-- <li class="dropdown">
                    <a href="{{ url(auth()->user()->level . '/user') }}" class="nav-link"><i
                            class="fas fa-users"></i><span>User</span></a>
                </li> --}}
            @endif
        </ul>

    </aside>
</div>
