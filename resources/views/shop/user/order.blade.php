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
                        <li>Pesanan Saya</li>
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
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <div class="dashboard-info">
                                                        <div id="orders" class="user-content">
                                                            <h2>Pesanan Saya</h2>
                                                            @foreach($orders as $order)
                                                                <div class="order-item">
                                                                    <h3>No. Pesanan: {{$order->order_number}}</h3>
                                                                    <table>
                                                                        <tr>
                                                                            <td>Status Pembayaran</td>
                                                                            <td>:</td>
                                                                            <td><span class="badge @if($order->payment_status=='Menunggu Pembayaran') bg-warning text-dark @else bg-success @endif">
                                                                                    {{$order->payment_status}}
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Status</td>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <span class="badge @if($order->status=='Baru') bg-primary @elseif($order->status=='Pesanan Diproses') bg-warning text-dark @elseif($order->status=='Pesanan Dikirim') bg-info @elseif($order->status=='Pesanan Diterima') bg-success @else bg-danger @endif">
                                                                                    {{$order->status}}
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Waktu Pemesanan</td>
                                                                            <td>:</td>
                                                                            <td>{{ $order->created_at->translatedFormat('d F Y, H:i') }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                @if($order->status == 'Baru' || $order->status == 'Pesanan Diproses')
                                                                                    <form action="{{ route('order.cancel', $order->id) }}" method="POST" style="display: inline;">
                                                                                        @csrf
                                                                                        <button type="submit" class="btn btn-danger">Batalkan Pesanan</button>
                                                                                    </form>
                                                                                @elseif($order->status == 'Pesanan Dikirim')
                                                                                    <form action="{{ route('order.confirm', $order->id) }}" method="POST" style="display: inline;">
                                                                                        @csrf
                                                                                        <button type="submit" class="btn btn-success">Pesanan Diterima</button>
                                                                                    </form>
                                                                                @endif
                                                                                @if($order->payment_status == 'Menunggu Pembayaran' && $order->status != 'Batal')
                                                                                    <form action="{{ route('order.pay', $order->id) }}" method="POST" style="display: inline;">
                                                                                        @csrf
                                                                                        <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                                                                                    </form>
                                                                                @elseif($order->status == 'Batal')
                                                                                    <p>Pesanan Dibatalkan</p>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Preview</th>
                                                                                <th>Produk</th>
                                                                                <th>Jumlah Produk</th>
                                                                                <th>Harga Produk</th>
                                                                                <th>Total</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($order->products as $item)
                                                                                <tr>
                                                                                    <td><img src="{{ asset('storage/photo-product/' . $item->photo) }}" alt="{{ $item->title }}" style="max-width:90px; max-height:120px;"></td>
                                                                                    <td>{{ $item->title }}</td>
                                                                                    <td>{{ $item->pivot->quantity }}</td>
                                                                                    <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                                                                    <td>Rp{{number_format($order->total_amount, 0, ',', '.')}}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <hr />
                                                            @endforeach
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