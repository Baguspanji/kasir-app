<nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">

                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item p-2 mt-1">
                    <a type="button" data-bs-toggle="dropdown" aria-expanded="true" data-bs-display="notif">
                        <div class="border border-gray-800 rounded-4" style="padding: 8px 14px;">
                            <i class="bi bi-bell-fill" style="font-size: 16pt;"></i>
                            <span class="position-absolute translate-middle badge rounded-pill bg-danger"
                                style="top: 10px;">
                                8
                            </span>
                        </div>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" data-bs-popper="notif" style="width: 500px;">
                        <template v-for="(item, index) in listNotif" :key="item.id">
                            <li class="bg-light py-2 px-3 row">
                                <div class="col-11">
                                    <CardMeta :title="item.data.title" :description="item.data.message" />
                                </div>
                                <div class="col-1">
                                    <a href="#">
                                        <IconId :size="25" stroke-width="1" color="#16b3ac" />
                                    </a>
                                </div>
                            </li>
                        </template>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a type="button" class="btn btn-link" data-bs-toggle="dropdown" aria-expanded="true"
                        data-bs-display="static" style="margin: 12px 18px 0 10px; padding: 0;">
                        <img src="https://sadj.reactai.com/mpa/img/demo/avatars/avatar-admin.png"
                            class="profile-image rounded-4">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
                        <li class="dropdown-header bg-trans-gradient">
                            <div class="d-flex flex-row align-items-center color-white">
                                <span class="me-2">
                                    <img src="https://sadj.reactai.com/mpa/img/demo/avatars/avatar-admin.png"
                                        class="rounded-circle profile-image">
                                </span>
                                <div class="info-card-text">
                                    <div class="text-truncate text-truncate-lg fs-small fw-bold">
                                        Admin Kasir
                                    </div>
                                    <span class="text-truncate text-truncate-md opacity-80 fs-xsmall">
                                        Admin
                                    </span>
                                </div>
                            </div>
                        </li>
                        <li class="bg-gradient mt-1">
                            <a href="#" class="dropdown-item py-2">
                                <IconUserCircle :size="18" class="me-2" />Profil
                            </a>
                        </li>
                        <li class="bg-gradient mt-1">
                            <a href="#" class="dropdown-item py-2">
                                <IconKey :size="18" class="me-2" />Ubah Password
                            </a>
                        </li>
                        <li class="bg-gradient">
                            <hr class="dropdown-divider">
                        </li>
                        <li class="bg-gradient logout">
                            <a class="dropdown-item" href="javascript:void()"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <IconLogout :size="18" class="me-2" />Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
