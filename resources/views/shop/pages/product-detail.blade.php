@extends('shop.layouts.index')  

@section('content')
<!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Detail Produk</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="{{route('products')}}">Produk</a></li>
                        <li>Detail Produk</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Item Details -->
    <section class="item-details section">
        <div class="container">
            <div class="top-area">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-images">
                            <main id="gallery">
                                <div class="main-img">
                                    <img src="{{ asset('storage/photo-product/' . $product->photo) }}" id="current" alt="{{ $product->name }}">
                                </div>
                            </main>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-info">
                            <h2 class="title">{{$product->title}}</h2>
                            <p class="category"><i class="lni lni-tag"></i> Kategori :<a href="javascript:void(0)">{{\App\Models\Category::where('id', $product->cat_id)->value('title') }}</a></p>
                            <p class="category"><i class="lni lni-tag"></i> Merek :<a href="javascript:void(0)">{{\App\Models\Brand::where('id', $product->brand_id)->value('title') }}</a></p>
                            <h3 class="price"> 
                                @if($product->discount)
                                    <span class="discount-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                    Rp{{ number_format($product->discounted_price, 0, ',', '.') }}
                                @else
                                    Rp{{ number_format($product->price, 0, ',', '.') }} 
                                @endif
                            </h3>
                            <form action="{{route('single-add-to-cart')}}" method="POST">
                                @csrf
                                <input type="hidden" name="slug" value="{{$product->slug}}">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group quantity">
                                            <label for="color">Quantity</label>
                                            <select class="form-control" name="quantity">
                                                @for ($i = 1; $i <= $product->stock; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-content">
                                    <div class="row align-items-end">
                                        <div class="col-lg-4 col-md-4 col-12">
                                            <div class="button cart-button">
                                                <button class="btn" style="width: 100%;">Tambah Keranjang</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-details-info">
                <div class="single-block">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="info-body custom-responsive-margin">
                                <h4>Deskripsi</h4>
                                <p>{!! $product->description !!}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="info-body">
                                <h4>Tentang Produk</h4>
                                <p>{!! $product->summary !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Item Details -->
@endsection
