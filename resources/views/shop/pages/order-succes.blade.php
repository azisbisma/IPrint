@extends('shop.layouts.index')

@section('content')
<!-- Start Error Area -->
<div class="maill-success">
    <div class="d-table">
      <div class="d-table-cell">
        <div class="container">
          <div class="success-content">
            <i class="lni  lni-heart"></i>
            <h2>Pembelian anda berhasil</h2>
            <p>No. Pesanan : {{ $order }}</p>
            <div class="button">
              <a href="{{route('home')}}" class="btn">Kembali ke Halaman Utama</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Error Area -->
@endsection
@section('scripts')
<script>
    window.onload = function () {
      window.setTimeout(fadeout, 500);
    }

    function fadeout() {
      document.querySelector('.preloader').style.opacity = '0';
      document.querySelector('.preloader').style.display = 'none';
    }
  </script>
@endsection