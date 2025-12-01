@extends('dashboard.layouts.index')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Update Kategori</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Kategori</a></li>
                <li class="breadcrumb-item active">Update Kategori</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Update Data Kategori</h5>

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

            <form action="{{ route('category.update', $category->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="inputTitle" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputTitle" name="title" value="{{ old('title', $category->title) }}" required>
                    </div>
                </div>

                <fieldset class="row mb-3">
                  <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" id="gridRadios1" value="aktif" {{ old('status', $category->status) == 'aktif' ? 'checked' : '' }}>
                      <label class="form-check-label" for="gridRadios1">
                        Aktif
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" id="gridRadios2" value="nonaktif" {{ old('status', $category->status) == 'nonaktif' ? 'checked' : '' }}>
                      <label class="form-check-label" for="gridRadios2">
                        Nonaktif
                      </label>
                    </div>
                  </div>
                </fieldset>

                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('category.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
