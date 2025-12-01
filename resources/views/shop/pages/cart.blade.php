@extends('shop.user.layouts.index')

@section('content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Keranjang</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="{{route('products')}}">Shop</a></li>
                        <li>Keranjang</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="cart-list-head">
                <!-- Cart List Title -->
                <div class="cart-list-title">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-12">
                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <p>Nama Produk</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Jumlah Produk</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Total harga</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Diskon</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>Hapus</p>
                        </div>
                    </div>
                </div>
                <!-- End Cart List Title -->
                <!-- Cart Single List list -->
                <div class="cart-single-list">
                    <form action="{{route('cart.update')}}" method="POST">
                        @csrf
                        @if(Helper::getAllProductFromCart())
                            @foreach(Helper::getAllProductFromCart() as $key=>$cart)
                                <div class="row align-items-center">
                                    <div class="col-lg-1 col-md-1 col-12">
                                        <a href="{{route('product-detail', $cart->product['slug'])}}"><img src="{{asset('storage/photo-product/' .$cart->product['photo'])}}" alt="#"></a>
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-12">
                                        <h5 class="product-name"><a href="{{route('product-detail', $cart->product['slug'])}}">
                                            {{$cart->product['title']}}</a></h5>
                                        <p class="product-des">
                                            <span><em>Merek:</em> {{\App\Models\Brand::where('id', $cart->product['brand_id'])->value('title') }}</span>
                                            <span><em>Kondisi:</em> {{$cart->product['condition']}}</span>
                                        </p>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="count-input">
                                            <select name="quant[{{$key}}]" class="form-control quantity" data-cart-id="{{$cart->id}}">
                                                @php
                                                    $maxStock = $cart->product['stock']; // Ambil stok produk dari database
                                                @endphp
                                                @for ($i = 1; $i <= $maxStock; $i++)
                                                    <option value="{{ $i }}" @if($cart->quantity == $i) selected @endif>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <input type="hidden" name="qty_id[]" value="{{$cart->id}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <p>Rp{{ number_format($cart['amount'], 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <p>{{number_format($cart->product['discount'])}}%</p>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-12">
                                        <a class="remove-item" href="{{route('cart-delete',$cart->id)}}"><i class="lni lni-close"></i></a>
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                            <div class="button">
                                <button type="submit" class="btn">Perbarui Keranjang</button>
                            </div>
                        @else
                            <div class="row align-items-center">
                                Keranjang Kosong.
                                <hr> 
                                <div class="button">
                                    <a href="{{route('home')}}" class="btn btn-alt">Lanjutkan Belanja</a>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
                <!-- End Single List list -->
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="left">
                                    <div class="coupon">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul>
                                        @php
											$total_amount=Helper::totalCartPrice();
										@endphp
                                        <li class="last">Sub Total<span class="price order_subtotal" data-price="{{Helper::totalCartPrice()}}">Rp{{number_format($total_amount, 0, ',', '.')}}</span></li>
                                        <li class="last">Total<span class="price" id="order_total_price">Rp{{number_format($total_amount, 0, ',', '.')}}</span></li>
                                    </ul>
                                    <div class="button">
                                        <a href="{{route('checkout')}}" class="btn">Checkout</a>
                                        <a href="{{route('home')}}" class="btn btn-alt">Lanjutkan Belanja</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Shopping Cart -->
@endsection

@section('scripts')

@endsection