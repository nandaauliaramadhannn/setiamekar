<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{$judul ?? 'Setia Mekar | Home'}}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/img/setiamekar.jpeg')}}">

        <link rel="stylesheet" href="{{asset('frontend')}}/css/normalize.css">
        <!-- Main CSS -->
        <link rel="stylesheet" href="{{asset('frontend')}}/css/main.css">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{asset('frontend')}}/css/bootstrap.min.css">
        <!-- Animate CSS -->
        <link rel="stylesheet" href="{{asset('frontend')}}/css/animate.min.css">
        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{asset('frontend')}}/css/fontawesome-all.min.css">
        <!-- Flaticon CSS -->
        <link rel="stylesheet" href="{{asset('frontend')}}/fonts/flaticon.css">
        <link rel="stylesheet" href="{{asset('frontend')}}/css/font/flaticon.css">
        <!-- Meanmenu CSS -->
        <link rel="stylesheet" href="{{asset('frontend')}}/css/meanmenu.min.css">
        <!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="{{asset('frontend')}}/css/magnific-popup.css">
        <!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="{{asset('frontend')}}/vendor/OwlCarousel/owl.carousel.min.css">
        <link rel="stylesheet" href="{{asset('frontend')}}/vendor/OwlCarousel/owl.theme.default.min.css">
        <!-- Nivo slider CSS -->
        <link rel="stylesheet" href="{{asset('frontend')}}/vendor/slider/css/nivo-slider.css" />
        <!-- Elements CSS -->
        <link rel="stylesheet" href="{{asset('frontend')}}/css/elements.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{asset('frontend')}}/style.css">
        <!-- Modernizr Js -->
        <script src="{{asset('frontend')}}/js/modernizr-3.5.0.min.js"></script>
</head>
<div id="preloader"></div>
<a href="#wrapper" data-type="section-switch" class="scrollUp">
    <i class="fas fa-angle-double-up"></i>
</a>
<div id="wrapper" class="wrapper">
    @include('layouts.frontend.header')
    @yield('content')
    @include('layouts.frontend.footer')
</div>
<script src="{{asset('frontend')}}/js/jquery-2.2.4.min.js"></script>
    <!-- Plugins js -->
    <script src="{{asset('frontend')}}/js/plugins.js"></script>
    <!-- Popper js -->
    <script src="{{asset('frontend')}}/js/popper.js"></script>
    <!-- Bootstrap js -->
    <script src="{{asset('frontend')}}/js/bootstrap.min.js"></script>
    <!-- Counterup Js -->
    <script src="{{asset('frontend')}}/js/jquery.counterup.min.js"></script>
    <!-- WOW JS -->
    <script src="{{asset('frontend')}}/js/wow.min.js"></script>
    <!-- Waypoints Js -->
    <script src="{{asset('frontend')}}/js/waypoints.min.js"></script>
    <!-- Parallaxie Js -->
    <script src="{{asset('frontend')}}/js/parallaxie.js"></script>
    <!-- Nivo slider js -->
    <script src="{{asset('frontend')}}/vendor/slider/js/jquery.nivo.slider.js"></script>
    <script src="{{asset('frontend')}}/vendor/slider/home.js"></script>
    <!-- Owl Carousel Js -->
    <script src="{{asset('frontend')}}/vendor/OwlCarousel/owl.carousel.min.js"></script>
    <!-- Meanmenu Js -->
    <script src="{{asset('frontend')}}/js/jquery.meanmenu.min.js"></script>
    <!-- Magnific Popup Js -->
    <script src="{{asset('frontend')}}/js/jquery.magnific-popup.min.js"></script>
    <!-- Isotope Js -->
    <script src="{{asset('frontend')}}/js/isotope.pkgd.min.js"></script>
    <!-- Smoothscroll Js -->
    <script src="{{asset('frontend')}}/js/smoothscroll.min.js"></script>
    <script src="{{asset('frontend')}}/js/imagesloaded.pkgd.min.js"></script>
    <script src="{{asset('frontend')}}/js/validator.min.js"></script>

    <!-- Custom Js -->
    <script src="{{asset('frontend')}}/js/main.js"></script>

</body>
</html>
