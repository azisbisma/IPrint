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
                        <li>Pengaturan Akun</li>
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
                                                                <h3>Pengaturan Akun</h3>
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
                                                                        <textarea class="form-control" type="text" id="reg-fn" disabled style="height: 150px;">{{$user->address}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                             <!-- Button trigger modal -->
                                                            <button type="button" class="btn edit-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                Edit Profil
                                                            </button>
                                                            <button type="button" class="btn edit-btn" data-bs-toggle="modal" data-bs-target="#passModal">
                                                                Ganti Password
                                                            </button>
                                                            <!-- Edit Profil Modal -->
                                                            <div class="modal fade review-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <form action="{{route('edit.profile',  ['id' => $user->id])}}" method="post" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Profil</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label for="name">Nama</label>
                                                                                    <input class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" id="name">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="email">Email</label>
                                                                                    <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}"  id="email">
                                                                                </div>                                                                                             
                                                                                <div class="form-group">
                                                                                    <label for="phone">No.Handphone</label>
                                                                                    <input class="form-control" type="number" name="phone" value="{{ old('phone', $user->phone) }}"  id="phone">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="formFile">Foto</label>
                                                                                    <input class="form-control" type="file" name="photo" value="{{ old('photo', $user->photo) }}"  id="Formfile">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="review-message">Alamat</label>
                                                                                    <textarea class="form-control" id="review-message" name="address" rows="8" style="height: 100px;">{{ old('name', $user->address) }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer button">
                                                                                <button type="submit" class="btn">Selesai</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <!-- Password Modal -->
                                                            <div class="modal fade review-modal" id="passModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <form action="{{route('change.pass')}}" method="post" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label for="currentPass">Password Lama</label>
                                                                                    <input class="form-control" type="password" name="current_password" id="currentPass">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="password">Password Baru</label>
                                                                                    <input class="form-control" type="password" name="password" id="password">
                                                                                </div>                                                                                             
                                                                                <div class="form-group">
                                                                                    <label for="confirmPass">Konfirmasi Password</label>
                                                                                    <input class="form-control" type="password" name="password_confirmation" id="confirmPass">
                                                                                </div>                                                                            
                                                                            </div>
                                                                            <div class="modal-footer button">
                                                                                <button type="submit" class="btn">Selesai</button>
                                                                            </div>
                                                                        </div>
                                                                    </form> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Review Modal -->
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