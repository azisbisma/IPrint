@extends('shop.user.layouts.index')

@section('content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Dashboard</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="{{route('customer.dashboard')}}">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Dashboard Area -->
    <section class="user-dashboard section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <!-- Start Dashboard Sidebar -->
                    <div class="user-sidebar">
                        <!-- Start Dashboard Widget -->
                        <div class="single-widget">
                            <div class="user-profile">
                                @if(auth()->user()->photo)
                                    <img src="{{ asset('storage/photo-user/' . $user->photo) }}" alt="">
                                @else
                                    <img src="{{Helper::userDefaultImage()}}">
                                @endif
                                <h3>{{$user->name}}</h3>
                                <p>{{$user->email}}</p>
                            </div>
                            <ul class="list">
                                <li>
                                    <a href="{{route('customer.dashboard')}}">Dashboard </a>
                                </li>
                                <li>
                                    <a href="{{route('customer.order')}}">Pesanan Saya</a>
                                </li>
                                <li>
                                    <a href="{{route('customer.setting')}}">Pengaturan Akun</a>
                                </li>
                                <li>
                                    <a href="{{route('user.logout')}}">Keluar</a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Dashboard Widget -->
                    </div>
                    <!-- End Product Sidebar -->
                </div>
                <div class="col-lg-9 col-12">
                    <div class="product-grids-head">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-grid">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <!-- Start Dashboard -->
                                        <div class="dashboard">
                                            <div class="row align-items-center">
                                                <div class="col-lg-4 col-md-12 col-12">
                                                    <div class="user-image">
                                                        @if(auth()->user()->photo)
                                                            <img src="{{ asset('storage/photo-user/' . $user->photo) }}" alt="">
                                                        @else
                                                            <img src="{{Helper::userDefaultImage()}}">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-12">
                                                    <div class="dashboard-info">
                                                        <div class="user-form">
                                                            <div class="title">
                                                                <h3>Informasi Akun</h3>
                                                            </div>
                                                            <form class="row" method="post">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label for="reg-fn">Nama</label>
                                                                        <input class="form-control" type="text" value="{{$user->name}}" id="reg-fn" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label for="reg-email">E-mail</label>
                                                                        <input class="form-control" type="email" value="{{$user->email}}" id="reg-email" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label for="reg-phone">No. Headphone</label>
                                                                        <input class="form-control" type="text" value="{{$user->phone}}" id="reg-phone" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label for="reg-fn">Alamat</label>
                                                                        <input class="form-control" type="text" id="reg-fn" value="{{$user->address}}" disabled style="height: 100px;">
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Dashboard -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Dashboard Area -->
@endsection