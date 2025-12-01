<!DOCTYPE html>
<html class="no-js" lang="zxx">

<!-- Start Head -->
 @include('shop.layouts.head')
<!-- End Head -->

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
    <header class="header navbar-area" id="header-ajax">
        @include('shop.layouts.header')
    </header>
    <!-- End Header Area -->

    <!-- Start Content Area -->
    @yield('content')
    <!-- End Content Area -->

    <!-- Start Footer Area -->
    @include('shop.layouts.footer')
    <!--/ End Footer Area -->
    @include('shop.layouts.notification')

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