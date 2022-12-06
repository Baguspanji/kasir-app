<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <!-- <div class="col-4 pt-1">
    <a class="link-secondary" href="#">Subscribe</a>
  </div> -->
            <div class="col-8">
                <a class="blog-header-logo text-dark" href="#">{{ config('app.name', 'Laravel') }}</a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </header>

    <div class="py-1 mb-4 border-bottom">
        <nav class="navbar navbar-expand-lg navbar-light bg-default">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="p-2 nav-link {{ request()->is('home*') ? 'active' : '' }}"
                            href="{{ url('home') }}"><i class="bi bi-house"></i>
                            Beranda</a>

                        <a class="p-2 nav-link {{ request()->is('cashier*') ? 'active' : '' }}"
                            href="{{ route('cashier.index') }}"><i class="bi bi-cart"></i> Kasir</a>

                        <a class="p-2 nav-link {{ request()->is('shopping*') ? 'active' : '' }}"
                            href="{{ route('shopping.index') }}"><i class="bi bi-building"></i>
                            Pembelajaan</a>

                        <div class="nav-item dropdown {{ request()->is('item*') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-basket"></i> Barang
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('item.index') }}">Menu</a></li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('item.index', ['type' => 'storage']) }}">Gudang</a>
                                </li>
                            </ul>
                        </div>

                        @can('is_admin')
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-fill"></i> Admin
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="{{ route('user.index') }}">User</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Pemasukan</a></li>
                                    <li><a class="dropdown-item" href="#">Pengeluaran</a></li>
                                    {{-- <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Master Data</a></li>
                                    <li><a class="dropdown-item" href="#">Pengaturan Toko</a></li> --}}
                                </ul>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
