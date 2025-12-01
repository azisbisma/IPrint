@extends('shop.layouts.index')

@section('content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Daftar</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                        <li>Daftar</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Account Register Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <div class="register-form">
                        <div class="title">
                            <h3>Tidak punya akun? Daftar</h3>
                            <p>Pendaftaran memerlukan waktu kurang dari satu menit, tetapi memberi Anda kendali penuh atas pesanan Anda.</p>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('register.submit')}}" class="row" method="post">
                            {{csrf_field()}}
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="reg-fn">Nama</label>
                                    <input class="form-control" type="text" name="name" id="reg-fn" value="{{old('name')}}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="reg-email">E-mail</label>
                                    <input class="form-control" type="email" name="email" id="reg-email" value="{{old('email')}}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="reg-phone">No. Handphone</label>
                                    <input class="form-control" type="text" name="phone" id="reg-phone" value="{{old('phone')}}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="reg-pass">Password</label>
                                    <input class="form-control" type="password" name="password" id="reg-pass">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="reg-pass-confirm">Konfirmasi Password</label>
                                    <input class="form-control" type="password" name="password_confirmation" id="reg-pass-confirm">
                                </div>
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">Daftar</button>
                            </div>
                            <p class="outer-link">Sudah punya akun? <a href="{{route('user.login')}}">Masuk</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Register Area -->
@endsection