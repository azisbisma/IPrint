@extends('dashboard.layouts.index')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Data Kategori</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Kategori</a></li>
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
          <h5 class="card-title">Kategori</h5>
          <p>Kategori membantu dalam mengorganisasi produk, tetapi juga berkontribusi pada pengalaman pengguna yang lebih baik, peningkatan penjualan, dan pemahaman yang lebih baik tentang preferensi pembeli.</p>

          <!-- Table with stripped rows -->
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $category->title }}</td>
                  <td>
                    @if($category->status=='aktif')
                      <span class="badge bg-success">{{$category->status}}</span>
                    @else
                      <span class="badge bg-danger">{{$category->status}}</span>
                    @endif
                  </td>
                  <td> 
                    <form id="delete-form-{{ $category->id }}" action="{{ route('category.destroy', $category->id) }}" method="POST">
                      <a href="{{route('category.edit',$category->id)}}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-post-id="{{ $category->id }}"><i class="bi bi-trash"></i></button>
                    </form>
                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Hapus Kategori</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body" id="deleteModalBody">
                            Apakah Anda yakin ingin menghapus kategori ini?
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
                {{ $categories->links() }}
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
    let categoryIdToDelete = null;
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; 
        categoryIdToDelete = button.getAttribute('data-post-id');
    });
    document.getElementById('confirm-delete').addEventListener('click', function () {
        if (categoryIdToDelete) {
            document.getElementById(`delete-form-${categoryIdToDelete}`).submit();
        }
    });
</script>
@endsection