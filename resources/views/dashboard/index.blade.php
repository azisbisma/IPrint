@extends('dashboard.layouts.index')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <form action="{{ route('admin') }}" method="GET"> <!-- Make sure to set the correct route -->
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                          <h6>Filter</h6>
                      </li>
                      <li>
                          <button type="submit" name="filter" value="hari" class="dropdown-item {{ $filter == 'hari' ? 'active' : '' }}">Hari Ini</button>
                      </li>
                      <li>
                          <button type="submit" name="filter" value="bulan" class="dropdown-item {{ $filter == 'bulan' ? 'active' : '' }}">Bulan Ini</button>
                      </li>
                      <li>
                          <button type="submit" name="filter" value="tahun" class="dropdown-item {{ $filter == 'tahun' ? 'active' : '' }}">Tahun Ini</button>
                      </li>
                  </ul>
                  </form>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Penjualan <span>| {{ ucfirst($filter) }}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $totalOrders }}</h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

              <div class="filter">
                <form action="{{ route('admin') }}" method="GET"> <!-- Make sure to set the correct route -->
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>
                        <li>
                            <button type="submit" name="filter" value="hari" class="dropdown-item {{ $filter == 'hari' ? 'active' : '' }}">Today</button>
                        </li>
                        <li>
                            <button type="submit" name="filter" value="bulan" class="dropdown-item {{ $filter == 'bulan' ? 'active' : '' }}">This Month</button>
                        </li>
                        <li>
                            <button type="submit" name="filter" value="tahun" class="dropdown-item {{ $filter == 'tahun' ? 'active' : '' }}">This Year</button>
                        </li>
                    </ul>
                </form>
              </div>

                <div class="card-body">
                  <h5 class="card-title">Pendapatan <span>| {{ ucfirst($filter) }}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="ps-3">
                      <h6>Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

              <div class="filter">
                <form action="{{ route('admin') }}" method="GET"> <!-- Make sure to set the correct route -->
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>
                        <li>
                            <button type="submit" name="filter" value="hari" class="dropdown-item {{ $filter == 'hari' ? 'active' : '' }}">Today</button>
                        </li>
                        <li>
                            <button type="submit" name="filter" value="bulan" class="dropdown-item {{ $filter == 'bulan' ? 'active' : '' }}">This Month</button>
                        </li>
                        <li>
                            <button type="submit" name="filter" value="tahun" class="dropdown-item {{ $filter == 'tahun' ? 'active' : '' }}">This Year</button>
                        </li>
                    </ul>
                </form>
              </div>

                <div class="card-body">
                  <h5 class="card-title">Customer <span>| {{ ucfirst($filter) }}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $totalUsers }}</h6>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <div class="col-12">
              <div class="card">
                  <div class="card-body">
                      <h5 class="card-title">Laporan Pendapatan <span>Tahun Ini</span></h5>

                      <!-- Line Chart -->
                      <div id="reportsChart"></div>

                      <script>
                          document.addEventListener("DOMContentLoaded", () => {
                              new ApexCharts(document.querySelector("#reportsChart"), {
                                  series: [{
                                      name: 'Pendapatan',
                                      data: @json($monthlyRevenue)
                                  }],
                                  chart: {
                                      height: 350,
                                      type: 'line',
                                      toolbar: {
                                          show: false
                                      },
                                  },
                                  markers: {
                                      size: 4
                                  },
                                  colors: ['#4154f1'],
                                  fill: {
                                      type: "gradient",
                                      gradient: {
                                          shadeIntensity: 1,
                                          opacityFrom: 0.3,
                                          opacityTo: 0.4,
                                          stops: [0, 90, 100]
                                      }
                                  },
                                  dataLabels: {
                                      enabled: false
                                  },
                                  stroke: {
                                      curve: 'smooth',
                                      width: 2
                                  },
                                  xaxis: {
                                      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                                  },
                                  tooltip: {
                                      x: {
                                          format: 'MM'
                                      },
                                  }
                              }).render();
                          });
                      </script>
                      <!-- End Line Chart -->

                  </div>
              </div>
            </div>



            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Pesanan <span></span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">No. Pesanan</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Status Pembayaran</th>
                        <th scope="col">Total</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($orders as $order)
                        <tr>
                          <th scope="row">{{$order->order_number}}</a></th>
                          <td>{{$order->name}}</td>
                          <td>
                            @if($order->payment_status=='Menunggu Pembayaran')
                              <span class="badge bg-warning text-dark">{{$order->payment_status}}</span>
                            @else
                              <span class="badge bg-success">{{$order->payment_status}}</span>
                            @endif
                          </td>
                          <td>Rp{{number_format($order->total_amount, 0, ',', '.')}}</td>
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
                        </tr>
                      @empty
                        <tr>
                          <td>Tidak ada pesanan</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->

            <!-- Top Selling -->
            <div class="col-12">
              <div class="card top-selling overflow-auto">
                <div class="card-body pb-0">
                  <h5 class="card-title">Stock Produk Dibawah 5</h5>
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col"></th>
                        <th scope="col">Produk</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($products as $product)
                        <tr>
                          <th scope="row"><img src="{{ asset('storage/photo-product/' . $product->photo) }}" alt="{{ $product->title }}"></th>
                          <td>{{$product->title}}</td>
                          <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                          <td class="fw-bold">{{$product->stock}}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Top Selling -->

          </div>
        </div><!-- End Left side columns -->
      </div>
    </section>

  </main><!-- End #main -->



@endsection