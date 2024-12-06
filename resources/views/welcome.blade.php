<!DOCTYPE html>
<!--
Template Name: Marvin - Responsive Bootstrap 4 Admin Dashboard Template
Author: Hencework
Contact: https://hencework.ticksy.com/

License: You must have a valid license purchased only from templatemonster to legally use the template for your project.
-->
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Marvin I Progress</title>
    <meta name="description" content="A responsive bootstrap 4 admin dashboard template by hencework" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Toggles CSS -->
    <link href="{{ asset('vendors/jquery-toggles/css/toggles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/jquery-toggles/css/themes/toggles-light.css') }}" rel="stylesheet" type="text/css">


    <link href=" {{ asset('vendors/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href=" {{ asset('vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }} " rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/style.css') }}" rel="stylesheet" type="text/css">

    @yield('css')

</head>

<body>


	<!-- HK Wrapper -->
	<div class="hk-wrapper hk-vertical-nav">

        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-xl navbar-light fixed-top hk-navbar">
            <a id="navbar_toggle_btn" class="navbar-toggle-btn nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="menu"></i></span></a>
            <a class="navbar-brand font-weight-700" href="dashboard1.html">
                Marvin
            </a>
            <ul class="navbar-nav hk-navbar-content">
              {{--   <li class="nav-item">
                    <a id="navbar_search_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="search"></i></span></a>
                </li>
                <li class="nav-item">
                    <a id="settings_toggle_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="settings"></i></span></a>
                </li> --}}

                <li class="nav-item dropdown dropdown-authentication">
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media">
                            <div class="media-img-wrap">
                                <div class="avatar">
                                    <img src=" {{ asset('dist/img/avatar12.jpg') }} " alt="user" class="avatar-img rounded-circle">
                                </div>
                                <span class="badge badge-success badge-indicator"></span>
                            </div>
                            <div class="media-body">
                                <span>Madelyn Shane<i class="zmdi zmdi-chevron-down"></i></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                    {{--     <a class="dropdown-item" href="profile.html"><i class="dropdown-icon zmdi zmdi-account"></i><span>Profile</span></a>
                        <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-card"></i><span>My balance</span></a>
                        <a class="dropdown-item" href="inbox.html"><i class="dropdown-icon zmdi zmdi-email"></i><span>Inbox</span></a>
                        <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-settings"></i><span>Settings</span></a>
                        <div class="dropdown-divider"></div>
                        <div class="sub-dropdown-menu show-on-hover">
                            <a href="#" class="dropdown-toggle dropdown-item no-caret"><i class="zmdi zmdi-check text-success"></i>Online</a>
                            <div class="dropdown-menu open-left-side">
                                <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-check text-success"></i><span>Online</span></a>
                                <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-circle-o text-warning"></i><span>Busy</span></a>
                                <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-minus-circle-outline text-danger"></i><span>Offline</span></a>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div> --}}
                        <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-power"></i><span>Log out</span></a>
                    </div>
                </li>
            </ul>
        </nav>
        <form role="search" class="navbar-search">
            <div class="position-relative">
                <a href="javascript:void(0);" class="navbar-search-icon"><span class="feather-icon"><i data-feather="search"></i></span></a>
                <input type="text" name="example-input1-group2" class="form-control" placeholder="Type here to Search">
                <a id="navbar_search_close" class="navbar-search-close" href="#"><span class="feather-icon"><i data-feather="x"></i></span></a>
            </div>
        </form>
        <!-- /Top Navbar -->

        <!-- Vertical Nav -->
        <nav class="hk-nav hk-nav-dark">
            <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
            <div class="nicescroll-bar">
                <div class="navbar-nav-wrap">
                    <ul class="navbar-nav flex-column">

                        <!--Menu -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="feather-icon"><i data-feather="activity"></i></span>
                                <span class="nav-link-text">Tableau de bords</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#dash_drp">
                                <span class="material-icons">
                                    location_city
                                    </span>
                                <span class="nav-link-text"> &nbsp;&nbsp;Province</span>
                            </a>
                            <ul id="dash_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('province.create') }}">Enregistrer Province</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('province.index') }}">Liste Province</a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#commoudept">
                                <span class="material-icons">
                                    location_on
                                    </span>
                                <span class="nav-link-text">&nbsp;&nbsp;Departement ou Commune</span>
                            </a>
                            <ul id="commoudept" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('commoudept.create') }}">Enregistrer Departement ou Commune</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('commoudept.index') }}">Liste Departement ou Commune</a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#arrondissement">
                                <span class="feather-icon"><i data-feather="map"></i></span>
                                <span class="nav-link-text">Arrondissement</span>
                            </a>
                            <ul id="arrondissement" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('arrondissement.create') }}">Enregistrer arrondissement</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('arrondissement.index') }}">Liste arrondissement</a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#commetarrondissement">
                                <span class="material-icons">
                                     chair
                                    </span>
                                <span class="nav-link-text"> &nbsp;&nbsp;Commune et Arrondissement</span>
                            </a>
                            <ul id="commetarrondissement" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('commetarrondissement.create') }}">Enregistrer Commune et Arrondissement</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('commetarrondissement.index') }}">Liste Commune et Arrondissement</a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#siege">
                                <span class="material-icons">
                                     chair
                                    </span>
                                <span class="nav-link-text"> &nbsp;&nbsp;Siege</span>
                            </a>
                            <ul id="siege" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('siege.create') }}">Enregistrer siege</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('siege.index') }}">Liste siege</a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#centrevote">
                                <span class="material-icons">
                                    how_to_vote
                                    </span>
                                <span class="nav-link-text"> &nbsp;&nbsp;Centre de vote</span>
                            </a>
                            <ul id="centrevote" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('centrevote.create') }}">Enregistrer Centre de vote</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('centrevote.index') }}">Liste  Centre de vote</a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#electeur">
                                <span class="feather-icon"><i data-feather="user"></i></span>
                                <span class="nav-link-text">Electeur</span>
                            </a>
                            <ul id="electeur" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('electeur.create') }}">Enregistrer Electeur</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('electeur.index') }}">Liste  Electeur</a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#inscription">
                                <span class="material-icons">
                                    person_add
                                    </span>
                                <span class="nav-link-text">&nbsp;&nbsp;Inscription </span>
                            </a>
                            <ul id="inscription" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('inscription.create') }}">Enregistrer Inscription</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('inscription.index') }}">Liste  Inscription</a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#Changement">
                                <span class="material-icons">
                                    manage_accounts
                                    </span>
                                <span class="nav-link-text">&nbsp;&nbsp;Changement</span>
                            </a>
                            <ul id="Changement" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('changement.create') }}">Enregistrer Changement</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('changement.index') }}">Liste  Changement</a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>


                    </ul>

                </div>
            </div>
        </nav>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->

        <!-- Setting Panel -->
        <div class="hk-settings-panel">
            <div class="nicescroll-bar position-relative">
                <div class="settings-panel-wrap">
                    <div class="settings-panel-head">
                        <a href="javascript:void(0);" id="settings_panel_close" class="settings-panel-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
                    </div>
                    <hr>

                    <h6 class="mb-5">Navigation</h6>
                    <p class="font-14">Menu comes in two modes: dark & light</p>
                    <div class="button-list hk-nav-select mb-10">
                        <button type="button" id="nav_light_select" class="btn btn-outline-light btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-sun-o"></i> </span><span class="btn-text">Light Mode</span></button>
                        <button type="button" id="nav_dark_select" class="btn btn-outline-primary btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-moon-o"></i> </span><span class="btn-text">Dark Mode</span></button>
                    </div>
                    <hr>
                    <h6 class="mb-5">Top Nav</h6>
                    <p class="font-14">Choose your liked color mode</p>
                    <div class="button-list hk-navbar-select mb-10">
                        <button type="button" id="navtop_light_select" class="btn btn-outline-light btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-sun-o"></i> </span><span class="btn-text">Light Mode</span></button>
                        <button type="button" id="navtop_dark_select" class="btn btn-outline-primary btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-moon-o"></i> </span><span class="btn-text">Dark Mode</span></button>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Scrollable Header</h6>
                        <div class="toggle toggle-sm toggle-simple toggle-light toggle-bg-primary scroll-nav-switch"></div>
                    </div>
                    <button id="reset_settings" class="btn btn-primary btn-block btn-reset mt-30">Reset</button>
                </div>
            </div>
            <img class="d-none" src=" {{ asset('dist/img/logo-light.png') }} " alt="brand" />
            <img class="d-none" src="{{ asset('dist/img/logo-dark.png') }}" alt="brand" />
        </div>
        <!-- /Setting Panel -->

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            @yield('content')

            <!-- Footer -->
            <div class="hk-footer-wrap container">
                <footer class="footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <p>Pampered by<a href="https://hencework.com/" class="text-dark" target="_blank">Hencework</a> © 2019</p>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <p class="d-inline-block">Follow us</p>
                            <a href="#" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span class="btn-icon-wrap"><i class="fa fa-facebook"></i></span></a>
                            <a href="#" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span class="btn-icon-wrap"><i class="fa fa-twitter"></i></span></a>
                            <a href="#" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span class="btn-icon-wrap"><i class="fa fa-google-plus"></i></span></a>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- /Footer -->

        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }} "></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('vendors/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Slimscroll JavaScript -->
    <script src="{{ asset('dist/js/jquery.slimscroll.js') }}"></script>

    <!-- FeatherIcons JavaScript -->
    <script src="{{ asset('dist/js/feather.min.js') }}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{ asset('dist/js/dropdown-bootstrap-extended.js') }}"></script>

    <!-- Toggles JavaScript -->
    <script src="{{ asset('vendors/jquery-toggles/toggles.min.js') }}"></script>
    <script src="{{ asset('dist/js/toggle-data.js') }}"></script>


     <!-- Data Table JavaScript -->
     <script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}  "></script>
     <script src="{{ asset('vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
     <script src="{{ asset('vendors/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
     <script src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
     <script src="{{ asset('vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
     <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
     <script src="{{ asset('vendors/jszip/dist/jszip.min.js') }}"></script>
     <script src="{{ asset('vendors/pdfmake/build/pdfmake.min.js') }}"></script>
     <script src="{{ asset('vendors/pdfmake/build/vfs_fonts.js') }}"></script>
     <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
     <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
     <script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
     <script src="{{ asset('dist/js/dataTables-data.js') }}"></script>
         <!-- Init JavaScript -->
    <script src="{{ asset('dist/js/init.js') }}"></script>
@yield('script')
</body>

</html>
