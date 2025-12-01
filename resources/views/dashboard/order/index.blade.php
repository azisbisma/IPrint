@extends('dashboard.layouts.index')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Pesanan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Pesanan</a></li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      @include('dashboard.layouts.notification')
    </div>
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Semua Pesanan</h5>
          <p></p>

          <!-- Table with stripped rows -->
            <table class="table datatable">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No. Pesanan</th>
                    <th>Nama</th>
                    <th>Total</th>
                    <th>Status Pembayaran</th>
                    <th>Status</th>
                    <th>Lihat</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($orders as $order)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$order->order_number}}</td>
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
                         <a href="{{ route('order.show', $order->id) }}" class="btn btn-info"><i class="bi bi-eye-fill"></i></a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td>Tidak ada pesanan</td>
                    </tr>
                  @endforelse
                </tbody>
            </table>
          <!-- End Table with stripped rows -->

           <!-- Tampilkan kontrol pagination -->
           <div class="d-flex justify-content-center">
            
            </div>
        </div>
      </div>
    </div>
  </div>
</section>

</main><!-- End #main -->
@endsection

@section('scripts')
<script>
    let orderIdToDelete = null;
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; 
        orderIdToDelete = button.getAttribute('data-post-id');
    });
    document.getElementById('confirm-delete').addEventListener('click', function () {
        if (orderIdToDelete) {
            document.getElementById(`delete-form-${orderIdToDelete}`).submit();
        }
    });
</script>
@endsection