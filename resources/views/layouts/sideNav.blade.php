<div class="sidebar bg-dark text-white" id="sidebar">
    <div class="sidebar-header p-4 border-bottom">
        <div class="d-flex align-items-center">
            <i class="fas fa-syringe fa-2x me-3 text-danger"></i>
            <h5 class="mb-0 text-danger">Tren Anabolic</h5>
        </div>
    </div>

    <div class="sidebar-menu p-3">
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="{{ route('dashboard') }}" class="nav-link text-white {{ Request::is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            @if (Auth::user() && Auth::user()->hak_akses != 'member')
            <li class="nav-item mb-2">
                <a href="" class="nav-link text-white {{ Request::is('barang*') ? 'active' : '' }}">
                    <i class="fas fa-box me-2"></i> Produk
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('kategori') }}" class="nav-link text-white {{ Request::is('kategori') ? 'active' : '' }}">
                    <i class="fas fa-tags me-2"></i> Kategori
                </a>
            </li>
            @if (Auth::user() && Auth::user()->hak_akses == 'kasir')
            <li class="nav-item mb-2">
                <a href="{{ route('penjualan') }}" class="nav-link text-white {{ Request::is('transaksi*') ? 'active' : '' }}">
                    <i class="fas fa-tags me-2"></i> Penjualan
                </a>
            </li>
              <li class="nav-item mb-2">
                <a href="{{ route('users') }}" class="nav-link text-white {{ Request::is('user*') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> users
                </a>
            </li>
            @endif
            @if (Auth::user() && Auth::user()->hak_akses == 'admin')
            <li class="nav-item mb-2">
                <a href="{{ route('pembelian') }}" class="nav-link text-white {{ Request::is('transaksi*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart me-2"></i> Pembelian
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('users') }}" class="nav-link text-white {{ Request::is('user*') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Users
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('supplier') }}" class="nav-link text-white {{ Request::is('supllier*') ? 'active' : '' }}">
                    <i class="fas fa-box me-2"></i> Supplier
                </a>
            </li>
            @endif
            @endif
        </ul>

        <div class="mt-auto pt-3 border-top">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.sidebar {
    min-height: 100vh;
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    transition: all 0.3s;
}

.sidebar .nav-link {
    padding: 0.75rem 1rem;
    border-radius: 0.375rem;
    transition: all 0.3s;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active {
    background-color: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
}

.sidebar-menu {
    height: calc(100vh - 100px);
    display: flex;
    flex-direction: column;
}

@media (max-width: 768px) {
    .sidebar {
        margin-left: -250px;
        z-index: 1040;
    }
    .sidebar.active {
        margin-left: 0;
    }
}
</style>
