@php use Illuminate\Support\Str; @endphp
        <!-- Start Header Middle -->
        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-7">
                        <!-- Start Header Logo -->
                        <a class="navbar-brand" href="{{route('home')}}">
                            <img src="https://i.ibb.co.com/jyk0jjT/Logo-Iprint-1.png" alt="Logo-Iprint-1">
                        </a>
                        <!-- End Header Logo -->
                    </div>
                    <div class="col-lg-5 col-md-7 d-xs-none">
                        <!-- Start Main Menu Search -->
                        <div class="main-menu-search">
                            <!-- navbar search start -->
                            <div class="navbar-search search-style-5">
                                <div class="search-input">
                                        <form action="{{ route('search') }}" method="GET">
                                        <input type="text" name="search" class="form-control" placeholder="Cari Produk" value="{{ request()->query('search') }}">
                                    </div>
                                    <div class="search-btn" type="submit">
                                        <button><i class="lni lni-search-alt"></i></button>
                                    </form>
                                    </div>
                            </div>
                            <!-- navbar search Ends -->
                        </div>
                        <!-- End Main Menu Search -->
                    </div>
                    <div class="col-lg-4 col-md-2 col-5">
                        <div class="middle-right-area">
                            <div class="">
                                <i class=""></i>
                                <h3>
                                    <span></span>
                                </h3>
                            </div>
                            @auth
                                <div class="navbar-cart">
                                    <div class="cart-items">
                                        <a href="javascript:void(0)" class="main-btn">
                                            <i class="lni lni-cart"></i>
                                            <span class="total-items">{{Helper::cartCount()}}</span>
                                        </a>
                                        <div class="shopping-item">
                                            <div class="dropdown-cart-header">
                                                <span>{{Helper::cartCount()}} Item</span>
                                            </div>
                                            <ul class="shopping-list">
                                                {{-- {{Helper::getAllProductFromCart()}} --}}
                                                    @foreach(Helper::getAllProductFromCart() as $cartItem)
                                                        <li>
                                                            <a href="{{route('cart-delete',$cartItem->id)}}" class="remove cart_delete" title="Remove this item" data-id="{{$cartItem->rowId}}"><i class="lni lni-close"></i></a>
                                                            <div class="cart-img-head">
                                                                <a class="cart-img" href="{{route('product-detail', $cartItem->product['slug'])}}"><img src="{{asset('storage/photo-product/' .$cartItem->product['photo'])}}" alt="#"></a>
                                                            </div>
                                                            <div class="content">
                                                                <h4><a href="{{route('product-detail', $cartItem->product['slug'])}}">{{ Str::limit($cartItem->product['title'], 40) }}</a></h4>
                                                                <p class="quantity">{{$cartItem->quantity}}x - <span class="amount">Rp{{number_format($cartItem->price, 0, ',', '.')}}</span></p>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                            </ul>
                                            <div class="bottom">
                                                <div class="total">
                                                    <span>Total :</span>
                                                    <span class="total-prc">Rp{{number_format(Helper::totalCartPrice(), 0, ',', '.')}}</span>
                                                </div>
                                                <div class="button">
                                                    <a href="{{route('cart')}}" class="btn animate">Lihat Keranjang</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="user">
                                        <a href="javascript:void(0)" class="main-btn">
                                            <i class="lni lni-user"></i>
                                        </a>
                                        <div class="user-item">
                                            <div class="dropdown-user-header">
                                                <span>Halo, {{ Auth::user()->name }}</span>
                                            </div>
                                            <ul class="user-list">
                                                <li><a href="{{route('customer.dashboard')}}">Akun Saya</a></li>
                                                <li><a href="{{route('customer.order')}}">Pesanan Saya</a></li>
                                                <li><a href="{{route('customer.setting')}}">Pengaturan Akun</a></li>
                                                <li><a href="{{route('user.logout')}}">Keluar</a></li>
                                            </ul>   
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="navbar-cart">
                                    <div class="login">
                                        <a href="javascript:void(0)" class="main-btn">
                                            <i class="lni lni-users"></i>
                                        </a>
                                        <span>Masuk Akun</span>
                                        <div class="login-item">
                                            <div class="dropdown-login-header">
                                                <span>Daftar jika belum memiliki akun</span>
                                            </div>
                                            <ul class="login-list">
                                                <li><a href="{{route('user.login')}}">Masuk</a></li>
                                                <li><a href="{{route('user.register')}}">Daftar</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Middle -->
        <!-- Start Header Bottom -->
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="nav-inner">
                        <!-- Start Mega Category Menu -->
                        <div class="mega-category-menu">
                            <span class="cat-button"><i class="lni lni-menu"></i>Kategori</span>
                                <ul class="sub-category">
                                    @foreach(Helper::getAllCategory() as $cat)
                                        <li><a href="{{ route('product-cat', $cat->slug) }}">{{$cat->title}}</a></li>
                                    @endforeach
                                </ul>
                        </div>
                        <!-- End Mega Category Menu -->
                        <!-- Start Navbar -->
                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a href="{{route('home')}}" aria-label="Toggle navigation">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('products')}}" aria-label="Toggle navigation">Semua Produk</a>
                                    </li>
                                </ul>
                            </div> <!-- navbar collapse -->
                        </nav>
                        <!-- End Navbar -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Nav Social -->
                    <!-- End Nav Social -->
                </div>
            </div>
        </div>
        <!-- End Header Bottom -->

