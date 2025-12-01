
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>IPrint Indonesia</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co.com/p2hYV2S/Logo-Iprint-2.png" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="{{ asset('shop/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('shop/assets/css/LineIcons.3.0.css')}}" />
    <link rel="stylesheet" href="{{ asset('shop/assets/css/tiny-slider.css')}}" />
    <link rel="stylesheet" href="{{ asset('shop/assets/css/glightbox.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('shop/assets/css/main.css')}}" />
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    <!-- Start Header Area -->
    @include('shop.user.layouts.header')
    <!-- End Header Area -->

    <!-- Start Section -->
     @yield('content')
    <!-- End Section -->
    <!-- Start Footer Area -->
    @include('shop.user.layouts.footer')
    <!--/ End Footer Area -->
    @include('shop.user.layouts.notification')

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ========================= JS here ========================= -->
    <script src="{{ asset('shop/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('shop/assets/js/tiny-slider.js')}}"></script>
    <script src="{{ asset('shop/assets/js/glightbox.min.js')}}"></script>
    <script src="{{ asset('shop/assets/js/main.js')}}"></script>
    <script src="{{ asset('shop/assets/js/jquery.min.js')}}"></script>
    @yield('scripts')
</body>

</html>