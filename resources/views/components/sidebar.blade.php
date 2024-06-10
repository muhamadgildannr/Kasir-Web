<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <!-- Brand Logo -->
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">Kasir Online</a>
        </div>
        <!-- Small Brand Logo -->
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">KO</a>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Dashboard -->
            <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <!-- User Management (for Administrator) -->
            @if (Auth::user()->role == 'admin')
                <li class="{{ Request::is('user*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user') }}">
                        <i class="fas fa-user"></i> <span>Akun Pengguna</span>
                    </a>
                </li>
            @endif
            <!-- Sales Management -->
            <li class="menu-header">Manajemen Penjualan</li>
            <li class="{{Request::is('top-up*') ? 'active' : ''}}">
                <a class="nav-link" href="{{ url('/top-up') }}">
                    <i class="fas fa-money-bill"></i><span>Top Up Saldo</span>
                </a>
            </li>
            <!-- Penjualan -->
            <li class="{{ Request::is('penjualan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('penjualan') }}">
                    <i class="fas fa-money-bill"></i> <span>Transaksi Penjualan</span>
                </a>
            </li>
            
            <!-- Stok Management -->
            <li class="menu-header">Manajemen Stok</li>
            <!-- Stok -->
            <li class="{{ Request::is('stock') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('stock') }}">
                    <i class="fas fa-box"></i> <span>Stok Barang</span>
                </a>
            </li>
            <!-- Logs Management -->
            <li class="menu-header">Manajemen Log</li>
            <!-- Stock Logs -->
            <li class="dropdown {{ Request::is('stock_log*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-recycle"></i><span>Log Stok</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- Stok Masuk -->
                    <li class="{{ Request::is('stock_log/in*') ? 'active' : '' }}">
                        <a class="nav-link" href="/stock_log/in">Log Stok Masuk</a>
                    </li>
                    <!-- Stok Keluar -->
                    <li class="{{ Request::is('stock_log/out*') ? 'active' : '' }}">
                        <a class="nav-link" href="/stock_log/out">Log Stok Keluar</a>
                    </li>
                </ul>
            </li>
            <!-- Riwayat Transaksi -->
            <li class="{{ Request::is('history*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('penjualan.history') }}">
                    <i class="fas fa-credit-card"></i> <span>Riwayat Transaksi</span>
                </a>
            </li>
            
        </ul>
    </aside>
</div>
