@extends('shop.user.layouts.index')

@section('content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Pembayaran</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                        <li>Checkout</li>
                        <li>Pembayaran</li>
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
                    <div id="orders" class="user-content">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah Produk</th>
                                    <th>Harga Produk</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($order->products as $item)
                                <tr>
                                    <td><img src="{{ asset('storage/photo-product/' . $item->photo) }}" alt="{{ $item->title }}" style="max-width:90px; max-height:120px;"></td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->pivot->quantity}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>
                                        <span class="badge @if($order->payment_status=='Menunggu Pembayaran') bg-warning text-dark @else bg-success @endif">
                                            {{$order->payment_status}}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Cart List Title -->
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="left">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul>
                                        <li class="last">Total<span class="price" id="order_total_price">Rp{{number_format($order->total_amount, 0, ',', '.')}}</span></li>
                                    </ul>
                                    <div class="button">
                                        <button class="btn" id="pay-button">Bayar Sekarang</button>
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
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
              /* You may add your own implementation here */
            //   alert("payment success!"); 
                window.location.href = "/customer/order/history"
                console.log(result);
            },
            onPending: function(result){
              /* You may add your own implementation here */
             // alert("wating your payment!"); console.log(result);
                window.location.href = "/customer/order/history"
                console.log(result);
            },
            onError: function(result){
              /* You may add your own implementation here */
              alert("Pembayaran gagal"); console.log(result);
            },
            onClose: function(){
              /* You may add your own implementation here */
              alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
@endsection
