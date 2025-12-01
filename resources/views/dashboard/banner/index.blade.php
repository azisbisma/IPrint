@extends('dashboard.layouts.index')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Data Banner</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('banner.index') }}">Banner</a></li>
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
          <h5 class="card-title">Banner</h5>
          <p>Banner dirancang untuk menarik perhatian pelanggan potensial, memberikan insentif bagi mereka untuk berbelanja, dan meningkatkan konversi. Selain itu, pastikan banner Anda memiliki desain yang menarik dan mudah dipahami untuk mencapai hasil terbaik.</p>

          <!-- Table with stripped rows -->
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($banners as $banner)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$banner->title}}</td>
                  <td>{{$banner->description}}</td>
                  <td><img src="{{ asset('storage/photo-banner/' . $banner->photo) }}" alt="{{ $banner->title }}" style="max-width:90px; max: height 120px;"></td>
                  <td>
                    @if($banner->status=='aktif')
                      <span class="badge bg-success">{{$banner->status}}</span>
                    @else
                      <span class="badge bg-danger">{{$banner->status}}</span>
                    @endif
                  </td>
                  <td> 
                    <form id="delete-form-{{ $banner->id }}" action="{{ route('banner.destroy', $banner->id) }}" method="POST">
                      <a href="{{route('banner.edit',$banner->id)}}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-post-id="{{ $banner->id }}"><i class="bi bi-trash"></i></button>
                    </form>
                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Hapus Banner</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body" id="deleteModalBody">
                            Apakah Anda yakin ingin menghapus banner ini?
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
                {{ $banners->links() }}
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
    let bannerIdToDelete = null;

    // Capture post ID from the delete button
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        bannerIdToDelete = button.getAttribute('data-post-id');
    });

    // Confirm deletion
    document.getElementById('confirm-delete').addEventListener('click', function () {
        if (bannerIdToDelete) {
            document.getElementById(`delete-form-${bannerIdToDelete}`).submit();
        }
    });
</script>
@endsection