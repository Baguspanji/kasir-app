<nav id="sidebar" class="">
    {{-- <div class="custom-menu">
        <button type="button" id="sidebarCollapse" @click="toggle" class="btn btn-primary">
            <i class="bi bi-chevron-left"></i>
            <i class="bi bi-chevron-right"></i>
        </button>
    </div> --}}
    <div class="py-2">
        <h1 class="px-4">
            <a href="{{ url('/') }}">
                <div class="d-flex">
                    <img src="{{ asset('assets/images/dummy-image.png') }}" class="logo-img border-4"
                        style="height: 60px;">
                </div>
            </a>
        </h1>
        <hr>
        <ul class="sidebar-nav">
            <li class="sidebar-item {{ request()->is('home*') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="sidebar-link">
                    <i class="bi bi-house-door-fill"></i><span class="ms-3">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('item*') ? 'active' : '' }}">
                <a href="{{ route('item.index') }}" class="sidebar-link">
                    <i class="bi bi-box-seam-fill"></i><span class="ms-3">Item</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('cashier*') ? 'active' : '' }}">
                <a href="{{ route('cashier.index') }}" class="sidebar-link">
                    <i class="bi bi-coin"></i><span class="ms-3">Kasir</span>
                </a>
            </li>
            <li
                class="sidebar-item {{ request()->is('transaction*') && !request()->is('transaction/income*') ? 'active' : '' }}">
                <a href="{{ route('transaction.index') }}" class="sidebar-link">
                    <i class="bi bi-file-earmark-ruled-fill"></i><span class="ms-3">Transaksi</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('transaction/income*') ? 'active' : '' }}">
                <a href="{{ route('transaction.income') }}" class="sidebar-link">
                    <i class="bi bi-file-earmark-ruled-fill"></i><span class="ms-3">Pendapatan</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('setting*') ? 'active' : '' }}">
                <a href="{{ route('setting') }}" class="sidebar-link">
                    <i class="bi bi-gear-fill"></i><span class="ms-3">Pengaturan</span>
                </a>
            </li>
        </ul>

        <div class="footer">
            <p>

            </p>
        </div>
    </div>
</nav>
