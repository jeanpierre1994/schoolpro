<nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-blue-template text-white fixed-top">
    <!-- Container wrapper -->
    <div class="container-fluid text-white">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
            aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Brand -->
        <a class="navbar-brand text-white" href="{{route('index')}}">
            <!--<img src="https://mdbcdn.b-cdn.net/img/logo/mdb-transaprent-noshadows.webp" height="25"
                alt="MDB Logo" loading="lazy" />-->
                School Pro
        </a>
        <!-- Search form -->
        <form class="d-none d-md-flex input-group w-auto my-auto">
            <input autocomplete="off" type="search" class="form-control rounded"
                placeholder='Recherche...' style="min-width: 225px;" />
            <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
        </form>

        <!-- Right links -->
        <ul class="navbar-nav ms-auto d-flex flex-row">
            <!-- Notification dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow" href="#"
                    id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell text-warning"></i>
                    <span class="badge rounded-pill badge-notification bg-danger">1</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                    <li>
                        <a class="dropdown-item" href="#">Some news</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">Another news</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </li>
                </ul>
            </li>

            <!-- Icon -->
            <li class="nav-item">
                <a class="nav-link me-3 me-lg-0" href="#">
                    <i class="fas fa-fill-drip text-warning"></i>
                </a>
            </li>
            <!-- Icon -->
            <li class="nav-item me-3 me-lg-0">
                <a class="nav-link" href="#">
                    <i class="fab fa-github text-warning"></i>
                </a>
            </li>

            <!-- Icon dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow" href="#" id="navbarDropdown"
                    role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                    <i class="flag-united-kingdom flag text-warning m-0"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="#"><i class="flag-france flag"></i>Français
                            <i class="fa fa-check text-success ms-2"></i></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"><i class="flag-poland flag"></i>Polski</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"><i class="flag-china flag"></i>中文</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"><i class="flag-japan flag"></i>日本語</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"><i class="flag-germany flag"></i>Deutsch</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"><i class="flag-france flag"></i>Français</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"><i class="flag-spain flag"></i>Español</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"><i class="flag-russia flag"></i>Русский</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"><i class="flag-portugal flag"></i>Português</a>
                    </li>
                </ul>
            </li>

            <!-- Avatar -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#"
                    id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img (31).webp" class="rounded-circle"
                        height="22" alt="Avatar" loading="lazy" />
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                    <li>
                        <a class="dropdown-item" href="#">Mon profile</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">Edition Profil</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('signout')}}">Se déconnecter</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- Container wrapper -->
</nav>