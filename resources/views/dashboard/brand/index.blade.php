@extends('dashboard.layouts.index')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Data Merek</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('brand.index') }}">Merek</a></li>
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
          <h5 class="card-title">Merek</h5>
          <p> Merek membantu pelanggan mengenali dan membedakan produk. Ini memudahkan mereka menemukan produk yang mereka cari.</p>

          <!-- Table with stripped rows -->
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Merek</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $brand->title }}</td>
                  <td>
                    @if($brand->status=='aktif')
                      <span class="badge bg-success">{{$brand->status}}</span>
                    @else
                      <span class="badge bg-danger">{{$brand->status}}</span>
                    @endif
                  </td>
                  <td> 
                    <form id="delete-form-{{ $brand->id }}" action="{{ route('brand.destroy', $brand->id) }}" method="POST">
                      <a href="{{route('brand.edit',$brand->id)}}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-post-id="{{ $brand->id }}"><i class="bi bi-trash"></i></button>
                    </form>
                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Hapus Merek</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body" id="deleteModalBody">
                            Apakah Anda yakin ingin menghapus merek ini?
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
                {{ $brands->links() }}
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
    let brandIdToDelete = null;
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; 
        brandIdToDelete = button.getAttribute('data-post-id');
    });
    document.getElementById('confirm-delete').addEventListener('click', function () {
        if (brandIdToDelete) {
            document.getElementById(`delete-form-${brandIdToDelete}`).submit();
        }
    });
</script>
@endsection