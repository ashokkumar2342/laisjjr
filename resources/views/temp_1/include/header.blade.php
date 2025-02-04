<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Jhajjar | Home</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('temp_1/img/favicon.png') }}">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="{{ asset('temp_1/css/normalize.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('temp_1/css/main.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('temp_1/css/bootstrap.min.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('temp_1/css/animate.min.css') }}">
    <!-- Font-awesome CSS-->
    <link rel="stylesheet" href="{{ asset('temp_1/css/font-awesome.min.css') }}">
    <!-- Owl Caousel CSS -->
    <link rel="stylesheet" href="{{ asset('temp_1/vendor/OwlCarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('temp_1/vendor/OwlCarousel/owl.theme.default.min.css') }}">
    <!-- Main Menu CSS -->
    <link rel="stylesheet" href="{{ asset('temp_1/css/meanmenu.min.css') }}">
    <!-- nivo slider CSS -->
    <link rel="stylesheet" href="{{ asset('temp_1/vendor/slider/css/nivo-slider.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp_1/vendor/slider/css/preview.css') }}" type="text/css" media="screen" />
    <!-- Datetime Picker Style CSS -->
    <link rel="stylesheet" href="{{ asset('temp_1/css/jquery.datetimepicker.css') }}">
    <!-- Magic popup CSS -->
    <link rel="stylesheet" href="{{ asset('temp_1/css/magnific-popup.css') }}">
    <!-- Switch Style CSS -->
    <link rel="stylesheet" href="{{ asset('temp_1/css/hover-min.css') }}">
    <!-- ReImageGrid CSS -->
    <link rel="stylesheet" href="{{ asset('temp_1/css/reImageGrid.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('temp_1/style.css') }}">
    <!-- Modernizr Js -->
    {{-- <script src="{{ asset('temp_1/js/modernizr-2.8.3.min.js') }}"></script> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_asset/dist/css/toastr.min.css')}}">
</head>

<body id="body_id">
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <!-- Main Body Area Start Here -->
    <div id="wrapper">
        <!-- Header Area Start Here -->
        <header>
            <div id="header2" class="header2-area">
                <div class="header-top-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="header-top-left">
                                    <ul>
                                        <li><i class="fa fa-phone" aria-hidden="true"></i><a href="Tel:01251-253118"> 01251-253118 </a></li>
                                        <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="#">dcjjrcr@gmail.com</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="header-top-right">
                                    <ul>
                                        <li>
                                            <div class="apply-btn-area">
                                                <a href="{{ route('admin.login') }}" class="apply-now-btn"><i class="fa fa-lock" aria-hidden="true"></i> Login</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-menu-area bg-textPrimary" id="sticker">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1" style="margin-top: -5px;">
                                <div class="logo-area">
                                    <a href="{{ route('template.index') }}"><img class="img-responsive" src="{{ asset('temp_1/img/0_1HRGov.png')}}" alt="logo" style="height: 60px;width: 60px;"></a>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3" style="margin-top: 15px;">
                                <div class="logo-area">
                                      <strong style="font-size:22px;">L. A. I. S. JHAJJAR</strong>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-8">
                                <nav id="desktop-nav">
                                    <ul>
                                        <li><a href="{{ route('template.index') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                                        <li><a href="{{ route('template.search') }}"><i class="fa fa-search" aria-hidden="true"></i> Search</a></li>
                                        <li>
                                            <a href="{{ route('admin.login') }}"><i class="fa fa-lock" aria-hidden="true"></i> Login</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area Start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul>
                                        <li><a href="{{ route('template.index') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                                        <li><a href="{{ route('template.search') }}"><i class="fa fa-search" aria-hidden="true"></i> Search</a></li>
                                        <li>
                                            <a href="{{ route('admin.login') }}"><i class="fa fa-lock" aria-hidden="true"></i> Login</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area End -->
        </header>