<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">
    <meta name="author" content="Alejandro RH">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - SGB Backpanel</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('img/LOGO-SGB.png') }}" rel="icon" type="image/png">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('img/LOGO-SGB.png') }}" alt="Logo SGB" class="img-fluid"
                        style="width: 30px; height: auto;">
                </div>
                <div class="sidebar-brand-text text-nowrap ml-3">
                    <div class="d-flex flex-column">
                        <span>Solid Gold</span>
                        <span>Berjangka</span>
                    </div>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Nav::isRoute('home') }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{ __('Beranda') }}</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                {{ __('Menu') }}
            </div>

            <!-- Nav Item - News -->
            <li class="nav-item {{ Nav::isRoute('produk.*') }}">
                <a class="nav-link" href="{{ route('produk.index') }}">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>{{ __('Produk') }}</span>
                </a>
            </li>

            <!-- Nav Item - News -->
            <li class="nav-item {{ Nav::isRoute('video.*') }}">
                <a class="nav-link" href="{{ route('video.index') }}">
                    <i class="fa-solid fa-video"></i>
                    <span>{{ __('Video') }}</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                {{ __('Website') }}
            </div>

            <!-- Nav Item - Settings -->
            <li class="nav-item {{ Nav::isRoute('settings.*') }}">
                <a class="nav-link" href="{{ route('settings.index') }}">
                    <i class="fa-solid fa-gears"></i>
                    <span>{{ __('Settings') }}</span>
                </a>
            </li>

            <!-- Nav Item - Settings -->
            <li class="nav-item {{ Nav::isRoute('legalitas.*') }}">
                <a class="nav-link" href="{{ route('legalitas.index') }}">
                    <i class="fa-solid fa-file-contract"></i>
                    <span>{{ __('Legalitas') }}</span>
                </a>
            </li>

            <!-- Nav Item - Informasi -->
            <li class="nav-item {{ Nav::isRoute('informasi.*') }}">
                <a class="nav-link" href="{{ route('informasi.index') }}">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>{{ __('Informasi') }}</span>
                </a>
            </li>

            <!-- Nav Item - Kantor Cabang -->
            <li class="nav-item {{ Nav::isRoute('kantor-cabang.*') }}">
                <a class="nav-link" href="{{ route('kantor-cabang.index') }}">
                    <i class="fa-solid fa-building"></i>
                    <span>{{ __('Kantor Cabang') }}</span>
                </a>
            </li>

            <!-- Nav Item - Wakil Pialang -->
            <li class="nav-item {{ Nav::isRoute('wakil-pialang.*') }}">
                <a class="nav-link" href="{{ route('wakil-pialang.index') }}">
                    <i class="fa-solid fa-people-group"></i>
                    <span>{{ __('Wakil Pialang') }}</span>
                </a>
            </li>

            @if (auth()->user()->role == 'superadmin')
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <div class="sidebar-heading">
                    {{ __('Pengguna') }}
                </div>

                <!-- Nav Item - User -->
                <li class="nav-item {{ Nav::isRoute('user.*') }}">
                    <a class="nav-link" href="{{ route('user.index') }}">
                        <i class="fa-solid fa-users"></i>
                        <span>{{ __('Manajemen Pengguna') }}</span>
                    </a>
                </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 text-gray-600 small">{{ Auth::user()->name }}</span>
                                <figure class="img-profile rounded-circle avatar font-weight-bold"
                                    data-initial="{{ Auth::user()->name[0] }}"></figure>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('Profile') }}
                                </a>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item text-danger font-weight-bold"
                                    data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                    {{ __('Logout') }}
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('main-content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Maintained by SG Berjangka. &copy;{{ now()->year }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    @yield('scripts')
</body>

</html>
