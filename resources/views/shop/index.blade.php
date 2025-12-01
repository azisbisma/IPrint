@php use Illuminate\Support\Str; @endphp
@extends('shop.layouts.index')

@section('content')
    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-16 custom-padding-right">
                    <div class="slider-head">
                        <!-- Start Hero Slider -->
                        @if(count($banners) > 0)
                                <div class="hero-slider">
                                    <!-- Start Single Slider -->
                                    @foreach($banners as $key => $banner)
                                    <div class="single-slider {{ $key == 0 ? 'active' : '' }}"
                                        style="background-image: url('{{ asset('storage/photo-banner/' . $banner->photo) }}')">
                                        <div class="content">
                                            <h2>
                                            {{ $banner->title }}
                                            </h2>
                                            <p>{{ $banner->description }}</p>
                                            <div class="button">
                                                <a href="{{route('products')}}" class="btn">Belanja Sekarang</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <!-- End Single Slider -->
                                </div>
                        @endif
                        <!-- End Hero Slider -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Area -->

    <!-- Start Product Area -->
    <section class="trending-product section" style="margin-top: 12px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Produk Produk IPrint</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($products as $product)
                @php
                    $cat_info=DB::table('categories')->select('title')->where('id',$product->child_cat_id)->get();
                    $brands=DB::table('brands')->select('title')->where('id',$product->brand_id)->get();
                @endphp
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Start Single Product -->
                        <div class="single-product">
                            <div class="product-image">
                                <img src="{{ asset('storage/photo-product/' . $product->photo) }}" alt="{{ $product->name }}">
                                    @if($product->discount)
                                        <span class="sale-tag">{{$product->discount}} % Off</span>
                                    @endif
                                    <div class="button">
                                        <a href="{{route('add-to-cart',$product->slug)}}" id="add_to_cart" data-quantity="1" class="btn add_to_cart cart"><i class="lni lni-cart"></i><br>Tambah Keranjang</a>
                                    </div>
                            </div>
                            <div class="product-info">
                                <span class="category">{{$product->cat_info['title']}}</span>
                                <h4 class="title">
                                    <a href="{{route('products')}}">{{ Str::limit($product->title, 40) }}</a>
                                </h4>
                                <span class="category">{{ucfirst($product->brand->title)}}</span>
                                <div class="price">
                                    @if($product->discount)
                                        <span class="discount-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span>Rp{{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                                    @else
                                        <span>Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product -->
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Product Area -->

@endsection
@section('scripts')
<script type="text/javascript">
        //========= Hero Slider 
        tns({
            container: '.hero-slider',
            slideBy: 'page',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 0,
            items: 1,
            nav: false,
            controls: true,
            controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
        });

        //======== Brand Slider
        tns({
            container: '.brands-logo-carousel',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 15,
            nav: false,
            controls: false,
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 3,
                },
                768: {
                    items: 5,
                },
                992: {
                    items: 6,
                }
            }
        });
    </script>
@endsection
