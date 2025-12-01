<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('admin') }}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#banner-nav" data-bs-toggle="collapse" href="#">
      <i class="ri-tv-2-line"></i><span>Banner</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="banner-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="{{route('banner.index')}}">
          <i class="bi bi-circle"></i><span>Tampilkan Banner</span>
        </a>
      </li>
      <li>
        <a href="{{route('banner.create')}}">
          <i class="bi bi-circle"></i><span>Buat Banner</span>
        </a>
      </li>
    </ul>
  </li><!-- End Banner Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#category-nav" data-bs-toggle="collapse" href="#">
      <i class="bx bxs-category-alt"></i><span>Kategori</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="category-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="{{route('category.index')}}">
          <i class="bi bi-circle"></i><span>Tampilkan Kategori</span>
        </a>
      </li>
      <li>
        <a href="{{route('category.create')}}">
          <i class="bi bi-circle"></i><span>Buat Kategori</span>
        </a>
      </li>
    </ul>
  </li><!-- End Category Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#brand-nav" data-bs-toggle="collapse" href="#">
      <i class="ri-vip-crown-2-line"></i><span>Merek</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="brand-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="{{ route('brand.index') }}">
          <i class="bi bi-circle"></i><span>Tampilkan Merek</span>
        </a>
      </li>
      <li>
        <a href="{{route('brand.create')}}">
          <i class="bi bi-circle"></i><span>Tambah Merek</span>
        </a>
      </li>
    </ul>
  </li><!-- End Brand Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#products-nav" data-bs-toggle="collapse" href="#">
      <i class="bx bxs-archive"></i><span>Produk</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="products-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="{{ route('product.index') }}">
          <i class="bi bi-circle"></i><span>Tampilkan Produk</span>
        </a>
      </li>
      <li>
        <a href="{{ route('product.create') }}">
          <i class="bi bi-circle"></i><span>Tambah Produk</span>
        </a>
      </li>
    </ul>
  </li><!-- End Products Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed " href="{{route('order.index')}}">
      <i class="ri-shopping-bag-3-fill"></i>
      <span>Manajemen Pesanan</span>
    </a>
  </li><!-- End Order Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed " href="{{route('orders.report.download')}}">
      <i class="ri-file-download-fill"></i>
      <span>Download Laporan Bulanan</span>
    </a>
  </li><!-- End Download Nav -->
</ul>

</aside>