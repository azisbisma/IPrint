@extends('dashboard.layouts.index')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Pesanan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Pesanan</a></li>
      <li class="breadcrumb-item"><a>Pesanan {{$order->order_number}}</a></li>
    </ol>
  </nav>
</div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
            <!-- Order Information -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Informasi Pesanan</h5>
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th>No. Pesanan</th>
                        <th>Nama</th>
                        <th>Total</th>
                        <th>Status Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>{{$order->order_number}}</th>
                        <td>{{$order->name}}</td>
                        <td>Rp{{number_format($order->total_amount, 0, ',', '.')}}</td>
                        <td>
                            @if($order->payment_status=='Menunggu Pembayaran')
                                <span class="badge bg-warning text-dark">{{$order->payment_status}}</span>
                            @else
                                <span class="badge bg-success">{{$order->payment_status}}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge
                            @if($order->status=='Baru')
                            bg-primary
                            @elseif($order->status=='Pesanan Diproses')
                            bg-warning text-dark
                            @elseif($order->status=='Pesanan Dikirim')
                            bg-info
                            @elseif($order->status=='Pesanan Diterima')
                            bg-success
                            @else
                            bg-danger
                            @endif">
                            {{$order->status}}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('order.downloadPDF', ['id' => $order->id]) }}" class="btn btn-light" title="Download PDF"><i class="bi bi-download"></i></a>
                            <a href="{{ route('orders.sendInvoice', ['id' => $order->id]) }}" class="btn btn-light" title="Kirim Invoice ke Email"><i class="bi bi-envelope"></i></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!-- End Order Information -->
            <!-- Shipping Information -->
            <div class="col-12">
              <div class="card top-selling overflow-auto">
                <div class="card-body pb-0">
                  <h5 class="card-title">Informasi Pengiriman</h5>
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>No. Handphone</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Kode Pos</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{{$order->name}}}</td>
                        <td>{{{$order->phone}}}</td>
                        <td>{{{$order->email}}}</td>
                        <td>{{{$order->address}}}</td>
                        <td>{{{$order->postcode}}}</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!-- End Shipping Information -->
            <!-- Product Information -->
            <div class="col-12">
              <div class="card top-selling overflow-auto">
                <div class="card-body pb-0">
                  <h5 class="card-title">Informasi Produk</h5>
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Foto Produk</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($order->products as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <th><img src="{{ asset('storage/photo-product/' . $item->photo) }}" alt="{{ $item->title }}"></th>
                                <td>{{$item->title}}</td>
                                <td>{{$item->pivot->quantity}}</td>
                                <td>Rp{{number_format($item->price, 0, ',', '.')}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!-- End Product Information -->
          </div>
        </div><!-- End Left side columns -->
        <!-- Right side columns -->
        <div class="col-lg-4">
          <!-- News & Updates Traffic -->
          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title"></h5>
              <table class="table table-borderless">
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>{{ $order->created_at->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jam</strong></td>
                            <td>{{ $order->created_at->translatedFormat('H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <td><strong>Subtotal</strong></td>
                            <td>Rp{{number_format($order->sub_total, 0, ',', '.')}}</td>
                        </tr>
                        @if($order->coupon>0)
                        <tr>
                            <td><strong>Potongan Harga</strong></td>
                            <td>Rp{{number_format($order->coupon, 0, ',', '.')}}</td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong><strong>Total</strong></td>
                            <td>Rp{{number_format($order->total_amount, 0, ',', '.')}}</td>
                        </tr>
                        <tr>
                            <td><strong><strong>Status</strong></td>
                            <td>
                                <form action="{{ route('order.status') }}" method="post">
                                  @csrf
                                  <input type="hidden" name="order_id" value="{{ $order->id }}">
                                  <select class="form-select" name="status" aria-label="Default select example">
                                      <option value="Baru" 
                                          {{ ($order->status == 'Pesanan Diproses' || $order->status == 'Pesanan Dikirim' || $order->status == 'Pesanan Diterima') ? 'disabled' : '' }} 
                                          {{ $order->status == 'Baru' ? 'selected' : '' }}>
                                          Baru
                                      </option>
                                      <option value="Pesanan Diproses" 
                                          {{ ($order->status == 'Pesanan Dikirim' || $order->status == 'Batal' || $order->status == 'Pesanan Diterima') ? 'disabled' : '' }} 
                                          {{ $order->status == 'Pesanan Diproses' ? 'selected' : '' }}>
                                          Pesanan Diproses
                                      </option>
                                      <option value="Pesanan Dikirim" 
                                          {{ ($order->status == 'Batal'|| $order->status == 'Baru' || $order->status == 'Pesanan Diterima') ? 'disabled' : '' }} 
                                          {{ $order->status == 'Pesanan Dikirim' ? 'selected' : '' }}>
                                          Pesanan Dikirim
                                      </option>
                                      <option value="Pesanan Diterima" 
                                          {{ ($order->status == 'Batal'|| $order->status == 'Baru' || $order->status == 'Pesanan Diproses' || $order->status == 'Pesanan Dikirim') ? 'disabled' : '' }}
                                          {{ $order->status == 'Pesanan Diterima' ? 'selected' : '' }}>
                                          Pesanan Diterima
                                      </option>
                                      <option value="Batal" 
                                          {{ ($order->status == 'Pesanan Dikirim' || $order->status == 'Pesanan Diterima') ? 'disabled' : '' }} 
                                          {{ $order->status == 'Batal' ? 'selected' : '' }}>
                                          Batal
                                      </option>
                                  </select>
                                  <br>
                                  <button class="btn btn-success">Perbarui</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                @if($order->payment_status === 'Menunggu Pembayaran')
                                    <button class="btn btn-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteOrderModal" 
                                            onclick="setDeleteAction('{{ route('order.destroy', ['id' => $order->id]) }}')">
                                        Hapus Pesanan
                                    </button>
                                @else
                                    <button class="btn btn-secondary" disabled>Tidak Dapat Dihapus</button>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                  </table>
              </div><!-- End sidebar recent posts-->

            </div>
          </div><!-- End News & Updates -->
        </div><!-- End Right side columns -->

      </div>
    </section>

</main><!-- End #main -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteOrderModalLabel">Konfirmasi Hapus Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus pesanan ini? Tindakan ini tidak dapat dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteOrderForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function setDeleteAction(url) {
        const deleteForm = document.getElementById('deleteOrderForm');
        deleteForm.action = url;
    }
</script>

@endsection
