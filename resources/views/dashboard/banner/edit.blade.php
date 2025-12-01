@extends('dashboard.layouts.index')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Banner</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('banner.index') }}">Banner</a></li>
                <li class="breadcrumb-item active">Edit Banner</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Data Banner</h5>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-octagon me-1"></i>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{route('banner.update',$banner->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row mb-3">
                    <label for="inputTitle" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputTitle" name="title" value="{{$banner->title}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="textarea" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="textarea" name="description">{{$banner->description}}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="formFile" class="col-sm-2 col-form-label">Upload Foto Baru</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="formFile" name="photo">
                        </div>
                </div>

                <div class="row mb-3">
                    <label for="formFile" class="col-sm-2 col-form-label">Foto Lama</label>
                        <div class="col-sm-10">
                            @if($banner->photo)
                                <img src="{{ asset('storage/photo-banner/' . $banner->photo) }}" alt="Old Banner Image" style="max-height: 200px;">
                            @else
                                <p>Tidak ada gambar</p>
                            @endif
                        </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select class="form-select" aria-label="Default select example" name="status">
                            <option value="aktif" {{(($banner->status=='aktif') ? 'selected' : '')}}>Aktif</option>
                            <option value="nonaktif" {{(($banner->status=='nonaktif') ? 'selected' : '')}}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">Selesai</button>
                        <a href="{{route('banner.index')}}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
