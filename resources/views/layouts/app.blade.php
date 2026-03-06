<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('logo/Yasoge.png') }}" type="image/x-icon">x
    <!-- Tag untuk Judul -->
    <title>Yasoge</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <style>
        .select2-container--default .select2-selection--single { border: 1.5px solid #dee2e6 !important; border-radius: 8px !important; height: auto !important; padding: .42rem .8rem !important; font-size: .93rem !important; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 1.5 !important; padding-left: 0 !important; color: #212529; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 100% !important; }
        .select2-dropdown { border: 1.5px solid #dee2e6; border-radius: 8px; }
        .select2-container--default .select2-search--dropdown .select2-search__field { border: 1.5px solid #dee2e6; border-radius: 6px; padding: .38rem .7rem; }
        .select2-container--default .select2-results__option--highlighted[aria-selected] { background-color: #495057; }
    </style>

    <!-- Penulisan skrip SweetAlert versi terbaru dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>

    <!-- FontAwesome JS-->
    <script defer src={{ asset('assets/plugins/fontawesome/js/all.min.js') }}></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href={{ asset('assets/css/portal.css') }}>
</head>

<body style="background: #80a2e522">
    <header class="app-header fixed-top">
        <div class="app-header-inner">
            <div class="container-fluid py-2">
                <div class="app-header-content">
                    <div class="row justify-content-between align-items-center">

                        <div class="col-auto">
                            <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    viewBox="0 0 30 30" role="img">
                                    <title>Menu</title>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                        stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
                                </svg>
                            </a>
                        </div><!--//col-->
                        <div class="search-mobile-trigger d-sm-none col">
                            <i class="search-mobile-trigger-icon fa-solid fa-magnifying-glass"></i>
                        </div><!--//col-->
                        <div class="app-search-box col">
                            <form class="app-search-form">
                                <input type="text" placeholder="Search..." name="search"
                                    class="form-control search-input">
                                <button type="submit" class="btn search-btn btn-primary" value="Search"><i
                                        class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div><!--//app-search-box-->


                        <div class="app-utilities col-auto">
                            <div class="app-utility-item app-user-dropdown dropdown">
                                <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown"
                                    href="#" role="button" aria-expanded="false">
                                    @if(Auth::user()->photo)
                                        <img src="{{ asset('foto/' . Auth::user()->photo) }}" alt="user profile" 
                                             style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                    @else
                                        <img src="{{ asset('assets/images/user.png') }}" alt="user profile">
                                    @endif
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                                    <li>
                                        <a class="dropdown-item">
                                            <div class="">{{ Auth::user()->name }}</div>
                                        </a>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user-edit me-1"></i> Edit Profile
                                        </a>
                                        <hr class="dropdown-divider">
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-1"></i> Log Out
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div><!--//app-user-dropdown-->
                        </div><!--//app-utilities-->

                    </div><!--//row-->
                </div><!--//app-header-content-->
            </div><!--//container-fluid-->
        </div><!--//app-header-inner-->
        <div id="app-sidepanel" class="app-sidepanel">
            <div id="sidepanel-drop" class="sidepanel-drop"></div>
            <div class="sidepanel-inner d-flex flex-column">
                <a href="{{ route('dashboard.index') }}" id="sidepanel-close"
                    class="sidepanel-close d-xl-none">&times;</a>
                <div class="app-branding">
                    <a class="app-logo" href="{{ route('dashboard.index') }}">
                        <img class="logo-icon me-2" src="{{ asset('logo/Yasoge.png') }}" alt="logo"
                            style="width: 50px; height: 50px;">
                        <span class="logo-text" style="font-size: 24px;">YASOGE</span>
                    </a>
                </div><!--//app-branding-->

                <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
                    <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}"
                                href="{{ route('dashboard.index') }}">
                                <span class="nav-icon">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house-door"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z" />
                                        <path fill-rule="evenodd"
                                            d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">Dashbord</span>
                            </a><!--//nav-link-->
                        </li><!--//nav-item-->
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link {{ request()->routeIs('sepatu.index') ? 'active' : '' }}"
                                href="{{ route('sepatu.index') }}">
                                <span class="nav-icon">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-folder"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.828 4a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 6.173 2H2.5a1 1 0 0 0-1 .981L1.546 4h-1L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3v1z" />
                                        <path fill-rule="evenodd"
                                            d="M13.81 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4zM2.19 3A2 2 0 0 0 .198 5.181l.637 7A2 2 0 0 0 2.826 14h10.348a2 2 0 0 0 1.991-1.819l.637-7A2 2 0 0 0 13.81 3H2.19z" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">Sepatu</span>
                            </a>
                            <!--//nav-link-->
                        </li><!--//nav-item-->
                        <li class="nav-item has-submenu">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link submenu-toggle {{ request()->routeIs('invoiceIn.*') || request()->routeIs('invoiceOut.*') ? 'active' : '' }}"
                                href="#submenu-1" data-bs-toggle="collapse"
                                data-bs-target="#submenu-1" aria-expanded="{{ request()->routeIs('invoiceIn.*') || request()->routeIs('invoiceOut.*') ? 'true' : 'false' }}" aria-controls="submenu-1">
                                <span class="nav-icon">
                                    <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-files"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                        <path fill-rule="evenodd"
                                            d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z" />
                                        <circle cx="3.5" cy="5.5" r=".5" />
                                        <circle cx="3.5" cy="8" r=".5" />
                                        <circle cx="3.5" cy="10.5" r=".5" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">Invoice</span>
                                <span class="submenu-arrow">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16"
                                        class="bi bi-chevron-down" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </span><!--//submenu-arrow-->
                            </a><!--//nav-link-->
                            <div id="submenu-1" class="collapse submenu submenu-1 {{ request()->routeIs('invoiceIn.*') || request()->routeIs('invoiceOut.*') ? 'show' : '' }}" data-bs-parent="#menu-accordion">
                                <ul class="submenu-list list-unstyled">
                                    <li class="submenu-item"><a
                                            class="submenu-link {{ request()->routeIs('invoiceIn.index') ? 'active' : '' }}"
                                            href="{{ route('invoiceIn.index') }}">Masuk</a></li>
                                    <li class="submenu-item"><a
                                            class="submenu-link {{ request()->routeIs('invoiceOut.index') ? 'active' : '' }}"
                                            href="{{ route('invoiceOut.index') }}">Keluar</a>
                                    </li>
                                </ul>
                            </div>
                        </li><!--//nav-item-->

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('inventory.index') ? 'active' : '' }}"
                                href="{{ route('inventory.index') }}">
                                <span class="nav-icon">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-archive"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V2zm1 3v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V5H1zm3 2a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 7z"/>
                                    </svg>
                                </span>
                                <span class="nav-link-text">Inventory</span>
                            </a>
                        </li><!--//nav-item-->

                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                                href="{{ route('users.index') }}">
                                <span class="nav-icon">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-person"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M12 1H4a1 1 0 0 0-1 1v10.755S4 11 8 11s5 1.755 5 1.755V2a1 1 0 0 0-1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z" />
                                        <path fill-rule="evenodd" d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">Users</span>
                            </a><!--//nav-link-->
                        </li><!--//nav-item-->


                    </ul><!--//app-menu-->
                </nav><!--//app-nav-->
                <div class="app-sidepanel-footer">
                    <nav class="app-nav app-nav-footer">
                        <ul class="app-menu footer-menu list-unstyled">
                            <li class="nav-item">
                                <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                                <a class="nav-link" href="settings.html">
                                    <span class="nav-icon">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z" />
                                            <path fill-rule="evenodd"
                                                d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-text">Settings</span>
                                </a><!--//nav-link-->
                            </li><!--//nav-item-->
                        </ul><!--//footer-menu-->
                    </nav>
                </div><!--//app-sidepanel-footer-->
            </div><!--//sidepanel-inner-->
        </div><!--//app-sidepanel-->
    </header><!--//app-header-->

    <div class="app-wrapper">
        @yield('content')
        <footer class="app-footer">
            <div class="container text-center py-3">
                <small class="copyright">Created
                    <img src="{{ asset('logo/Yasoge.png') }}" alt="Yasoge logo"
                        style="width: 20px; height: auto; color: #fb866a;">
                    by Yasoge @2024
                </small>
            </div>
        </footer><!--//app-footer-->
    </div><!--//app-wrapper-->

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .app-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .app-wrapper>* {
            flex-shrink: 0;
        }

        .app-wrapper>footer {
            margin-top: auto;
        }

        /* ===== BOTTOM NAVIGATION BAR ===== */
        .bottom-navbar {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 65px;
            background: #fff;
            box-shadow: 0 -4px 20px rgba(80, 100, 180, 0.15);
            z-index: 9999;
            border-top: 1px solid #e4eaf0;
        }

        @media (max-width: 1199px) {
            .bottom-navbar {
                display: flex;
                align-items: center;
                justify-content: space-around;
            }
            .app-wrapper {
                padding-bottom: 75px;
            }
        }

        .bottom-navbar .bn-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
            text-decoration: none;
            color: #8a9ab5;
            font-size: 10px;
            font-weight: 500;
            gap: 3px;
            transition: color .2s;
            padding: 6px 0 2px;
            position: relative;
        }

        .bottom-navbar .bn-item svg,
        .bottom-navbar .bn-item i {
            font-size: 20px;
            width: 22px;
            height: 22px;
        }

        .bottom-navbar .bn-item.active,
        .bottom-navbar .bn-item:hover {
            color: #4d7cfe;
        }

        .bottom-navbar .bn-item.active .bn-label,
        .bottom-navbar .bn-item:hover .bn-label {
            color: #4d7cfe;
        }

        /* Center raised button */
        .bottom-navbar .bn-center {
            margin-top: -28px;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .bottom-navbar .bn-center .bn-circle {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4d7cfe 0%, #6a5acd 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(77,124,254,0.45);
            color: #fff;
            transition: transform .2s, box-shadow .2s;
        }

        .bottom-navbar .bn-center.active .bn-circle,
        .bottom-navbar .bn-center:hover .bn-circle {
            transform: scale(1.08);
            box-shadow: 0 6px 22px rgba(77,124,254,0.55);
        }

        .bottom-navbar .bn-center svg {
            width: 24px;
            height: 24px;
            color: #fff;
        }

        .bottom-navbar .bn-center .bn-label {
            color: #4d7cfe;
            font-size: 10px;
            font-weight: 600;
            margin-top: 2px;
        }

        .bottom-navbar .bn-label {
            font-size: 10px;
            margin-top: 1px;
        }

        /* Active dot indicator */
        .bottom-navbar .bn-item.active::after {
            content: '';
            display: block;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #4d7cfe;
            position: absolute;
            bottom: 2px;
        }
    </style>



    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Javascript -->
    <script src="{{ asset('assets/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Letakkan di bagian bawah sebelum penutup tag </body> -->

    <!-- Charts JS -->
    <script src="{{ asset('assets/plugins/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/index-charts.js') }}"></script>

    <!-- Page Specific JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                searching: false,
                info: false,
                lengthChange: false,
                // Disable the search box
            });
        });
    </script>

    <!-- ===== BOTTOM NAVIGATION BAR ===== -->
    <nav class="bottom-navbar">
        {{-- Sepatu --}}
        <a href="{{ route('sepatu.index') }}"
           class="bn-item {{ request()->routeIs('sepatu.index') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 18h20v2H2z"/>
                <path d="M4 18V9a4 4 0 0 1 4-4h4l4 4h4l1 5H4z"/>
                <circle cx="8" cy="13" r="1"/>
            </svg>
            <span class="bn-label">Sepatu</span>
        </a>

        {{-- Invoice In --}}
        <a href="{{ route('invoiceIn.index') }}"
           class="bn-item {{ request()->routeIs('invoiceIn.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <polyline points="12 18 12 12"/>
                <polyline points="9 15 12 12 15 15"/>
            </svg>
            <span class="bn-label">Inv. In</span>
        </a>

        {{-- Dashboard (center raised) --}}
        <a href="{{ route('dashboard.index') }}"
           class="bn-center {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <div class="bn-circle">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z"/>
                    <polyline points="9 21 9 12 15 12 15 21"/>
                </svg>
            </div>
            <span class="bn-label">Home</span>
        </a>

        {{-- Invoice Out --}}
        <a href="{{ route('invoiceOut.index') }}"
           class="bn-item {{ request()->routeIs('invoiceOut.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <polyline points="12 12 12 18"/>
                <polyline points="9 15 12 18 15 15"/>
            </svg>
            <span class="bn-label">Inv. Out</span>
        </a>

        {{-- Inventory --}}
        <a href="{{ route('inventory.index') }}"
           class="bn-item {{ request()->routeIs('inventory.index') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                <polyline points="21 8 21 21 3 21 3 8"/>
                <rect x="1" y="3" width="22" height="5"/>
                <line x1="10" y1="12" x2="14" y2="12"/>
            </svg>
            <span class="bn-label">Inventory</span>
        </a>
    </nav>

</body>

</html>
