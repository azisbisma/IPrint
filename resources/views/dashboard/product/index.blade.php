@extends('dashboard.layouts.index')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Data Produk</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('banner.index') }}">Produk</a></li>
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
          <h5 class="card-title">Produk</h5>
          <p>Manajemen produk untuk menambahkan suatu produk atau mengupdate produk yang tersedia</p>

          <!-- Table with stripped rows -->
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Foto</th>
                <th>Merek</th>
                <th>Status</th>
                <th>Harga</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $product)
                @php
                $cat_info=DB::table('categories')->select('title')->where('id',$product->child_cat_id)->get();
                $brands=DB::table('brands')->select('title')->where('id',$product->brand_id)->get();
                @endphp
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$product->title}}</td>
                  <td>{{$product->cat_info['title']}}</td>
                  <td><img src="{{ asset('storage/photo-product/' . $product->photo) }}" alt="{{ $product->title }}" style="max-width:90px; max: height 120px;"></td>
                  <td> {{ucfirst($product->brand->title)}}</td>
                  <td>
                    @if($product->status=='aktif')
                      <span class="badge bg-success">{{$product->status}}</span>
                    @else
                      <span class="badge bg-danger">{{$product->status}}</span>
                    @endif
                  </td>
                  <td>Rp{{number_format($product->price)}}</td>
                  <td> 
                    <form id="delete-form-{{ $product->id }}" action="{{ route('product.destroy', $product->id) }}" method="POST">
                      <a href="{{route('product.edit',$product->id)}}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-post-id="{{ $product->id }}"><i class="bi bi-trash"></i></button>
                    </form>
                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Hapus Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body" id="deleteModalBody">
                            Apakah Anda yakin ingin menghapus produk ini?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-danger" id="confirm-delete">Hapus</button>
                        </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <!-- End Table with stripped rows -->

          <!-- Tampilkan kontrol pagination -->
          <div class="d-flex justify-content-center">
                {{ $products->links() }}
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
    let productIdToDelete = null;
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; 
        productIdToDelete = button.getAttribute('data-post-id');
    });
    document.getElementById('confirm-delete').addEventListener('click', function () {
        if (productIdToDelete) {
            document.getElementById(`delete-form-${productIdToDelete}`).submit();
        }
    });
</script>
@endsection