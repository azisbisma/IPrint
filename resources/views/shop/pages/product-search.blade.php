@php use Illuminate\Support\Str; @endphp
@extends('shop.layouts.index')  

@section('content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Cari Produk</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="{{route('products')}}">Produk</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Product Grids -->
    <section class="product-grids section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <!-- Start Product Sidebar -->
                    <div class="product-sidebar">
                        <!-- Start Single Widget -->
                        <div class="single-widget">
                            <h3>Kategori</h3>
                                <ul class="list">
                                    @foreach(Helper::getAllCategory() as $cat)
                                        <li>
                                            <a href="{{ route('product-cat', $cat->slug) }}">{{$cat->title}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <!-- End Product Sidebar -->
                </div>
                <div class="col-lg-9 col-12">
                    <div class="product-grids-head">
                        <div class="product-grid-topbar">
                            <div class="row align-items-center">
                                <div class="col-lg-7 col-md-8 col-12">
                                </div>
                                <div class="col-lg-5 col-md-4 col-12">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-grid" type="button" role="tab"
                                                aria-controls="nav-grid" aria-selected="true"><i
                                                    class="lni lni-grid-alt"></i></button>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-grid" role="tabpanel"
                                aria-labelledby="nav-grid-tab">
                                <div class="row">
                                    @if(count($products)>0)
                                        @foreach($products as $product)
                                            <div class="col-lg-4 col-md-6 col-12">
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
                                                        <span class="category">{{\App\Models\Brand::where('id', $product->brand_id)->value('title') }}</span>
                                                        <h4 class="title">
                                                            <a href="{{route('product-detail', $product->slug)}}">{{ Str::limit($product->title, 40) }}</a>
                                                        </h4>
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
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Pagination -->
                                        <div class="pagination left">
                                            <ul class="pagination-list">
                                              {{ $products->links() }}
                                            </ul>
                                        </div>
                                        <!--/ End Pagination -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Product Grids -->
@endsection

@section('scripts')
    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
                    else{
                        ('error',response.msg,'error').then(function(){
							// document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}
@endsection
