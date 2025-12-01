@extends('shop.user.layouts.index')

@section('content')
<!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">checkout</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="{{route('products')}}">Produk</a></li>
                        <li>Checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!--====== Checkout Form Steps Part Start ======-->

    <section class="checkout-wrapper section">
        <div class="container">
        @php
            $total_amount=Helper::totalCartPrice();
        @endphp
        @if ($total_amount > 0)
            <form class="form" method="POST" action="{{route('order')}}">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="checkout-steps-form-style-1">
                            <ul id="accordionExample">
                                <li>
                                    <h6 class="title collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="true" aria-controls="collapseFour">Alamat Pengiriman</h6>
                                    <section class="checkout-steps-form-content collapse show" id="collapseFour"
                                        aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>Nama</label>
                                                    <div class="row">
                                                        <div class="col-md-12 form-input form">
                                                            <input type="text" name="name" value="{{ $user->name }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Email</label>
                                                    <div class="form-input form">
                                                        <input type="email" name="email" value="{{ $user->email }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>No.Handphone</label>
                                                    <div class="form-input form">
                                                        <input type="number" name="phone" value="{{ $user->phone }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>Alamat</label>
                                                    <div class="form-input form">
                                                        <input type="text" name="address" style="height:100px;" value="{{ $user->address }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Kode Pos</label>
                                                    <div class="form-input form">
                                                        <input type="number" name="postcode">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="checkout-sidebar">                          
                            <div class="checkout-sidebar-price-table mt-30">
                                <input type="hidden" name="sub_total" value="{{Helper::totalCartPrice()}}">
                                <input type="hidden" name="total_amount" value="{{ $total_amount }}">
                                <h5 class="title">Rincian Pembayaran</h5>

                                <div class="sub-total-price">
                                    <div class="total-price">
                                        <p class="value"> Total Harga Produk</p>
                                        <p class="price order_subtotal" name="sub_total" data-price="{{Helper::totalCartPrice()}}">Rp{{number_format(Helper::totalCartPrice(), 0, ',', '.')}}</p>
                                    </div>
                                </div>
                                <div class="total-payable">
                                    <div class="payable-price">
                                        <p class="value">Total Pembayaran:</p>  
                                        <p class="price" name="total_amount" id="order_total_price">Rp{{number_format($total_amount, 0, ',', '.')}}</p>
                                    </div>
                                </div>
                                <div class="price-table-btn button">
                                    <button type="submit" class="btn btn-alt">Bayar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form> 
        @else
            <div class="shopping-cart section">
                <div class="container">
                    <div class="cart-list-head">
                        <!-- Cart List Title -->
                        <div class="cart-list-title">
                            <div id="orders" class="user-content">
                                <div class="text-center">
                                    <h4>Tidak ada produk yang dipesan, silahkan tambahkan produk.</h4>
                                    <br><br>
                                    <div class="price-table-btn button">
                                        <a href="{{route('home')}}" class="btn btn-a">Lanjutkan Belanja</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Cart List Title -->
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>
    <!--====== Checkout Form Steps Part Ends ======-->
@endsection
