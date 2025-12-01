@extends('dashboard.layouts.index')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Edit Produk</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Produk</a></li>
      <li class="breadcrumb-item active">Edit Produk</li>
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
          
          <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="row mb-3">
              <label for="title" class="col-sm-2 col-form-label">Nama Produk</label>
              <div class="col-sm-10">
                <input id="title" type="text" class="form-control" name="title" value="{{ $product->title }}" required autofocus>
              </div>
            </div>

            <div class="row mb-3">
              <label for="cat_id" class="col-sm-2 col-form-label">Kategori</label>
              <div class="col-sm-10">
                <select id="cat_id" class="form-select" name="cat_id" required>
                  <option value="">Pilih Kategori</option>
                    @foreach($categories as $key=>$cat_data)
                        <option value='{{$cat_data->id}}' {{(($product->cat_id==$cat_data->id)? 'selected' : '')}}>{{$cat_data->title}}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label for="brand_id" class="col-sm-2 col-form-label">Merek</label>
              <div class="col-sm-10">
                <select id="brand_id" class="form-select" name="brand_id" required>
                  <option value="">Pilih Merek</option>
                  @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{ $brand->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label for="description" class="col-sm-2 col-form-label">Deskripsi Produk</label>
              <div class="col-sm-10">
                  <div id="description-editor" style="height: 200px;"></div>
                  <input type="hidden" name="description" id="description">
              </div>
            </div>
            
            <div class="row mb-3">
              <label for="weight" class="col-sm-2 col-form-label">Berat (gram)</label>
              <div class="col-md-6">
                <input id="weight" type="number" class="form-control" name="weight" value="{{ $product->weight }}" required>
              </div>
            </div>
            
            <div class="row mb-3">
              <label for="summary" class="col-sm-2 col-form-label">Ringkasan Produk</label>
              <div class="col-sm-10">
                  <div id="summary-editor" style="height: 100px;"></div>
                  <input type="hidden" name="summary" id="summary">
              </div>
            </div>

            <div class="row mb-3">
                <label for="formFile" class="col-sm-2 col-form-label">Foto Lama</label>
                    <div class="col-sm-10">
                        @if($product->photo)
                            <img src="{{ asset('storage/photo-product/' . $product->photo) }}" alt="{{ $product->title }}" style="max-width:90px; max-height: 120px;">
                        @else
                            <p>Tidak ada gambar</p>
                        @endif
                    </div>
            </div>

            <div class="row mb-3">
              <label for="photo" class="col-sm-2 col-form-label">Foto</label>
              <div class="col-sm-10">
                <input id="photo" type="file" class="form-control" name="photo">
              </div>
            </div>

            <div class="row mb-3">
              <label for="stock" class="col-sm-2 col-form-label">Stok Produk</label>
              <div class="col-md-6">
                <input id="stock" type="number" class="form-control" name="stock" min="0" value="{{ $product->stock }}" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="condition" class="col-sm-2 col-form-label">Kondisi Produk</label>
              <div class="col-md-6">
                <select id="condition" class="form-select" name="condition" required>
                <option value="bekas" {{(($product->condition=='bekas')? 'selected':'')}}>Bekas</option>
              <option value="baru" {{(($product->condition=='baru')? 'selected':'')}}>Baru</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label for="price" class="col-sm-2 col-form-label">Harga</label>
              <div class="col-md-6">
                <input id="price" type="number" class="form-control" name="price" value="{{ $product->price }}" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="discount" class="col-sm-2 col-form-label">Discount</label>
              <div class="col-md-6">
                <input id="discount" type="number" class="form-control" name="discount" value="{{ $product->discount }}">
              </div>
            </div>

            <div class="row mb-3">
              <label for="status" class="col-sm-2 col-form-label">Status</label>
              <div class="col-sm-10">
                <select id="status" class="form-select" name="status" required>
                  <option value="aktif" {{ $product->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                  <option value="nonaktif" {{ $product->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
              </div>
            </div>

            <div class="row mb-0">
              <div class="col-sm-10 offset-md-4">
                <button type="submit" class="btn btn-primary">Selesai</button>
                <a href="{{route('product.index')}}" class="btn btn-secondary">Batal</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

</main><!-- End #main -->
@endsection

@section('scripts')
<script>
    // Inisialisasi Quill untuk Deskripsi
    var descriptionQuill = new Quill('#description-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],        // Tombol untuk teks tebal, miring, garis bawah, coret
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],     // Tombol untuk daftar urut dan tidak urut
                [{ 'script': 'sub'}, { 'script': 'super' }],      // Tombol untuk subscript/superscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],          // Tombol untuk identasi
                [{ 'direction': 'rtl' }],                         // Tombol untuk arah teks
                [{ 'size': ['small', false, 'large', 'huge'] }],  // Ukuran teks
                [{ 'color': [] }, { 'background': [] }],          // Warna teks dan latar belakang
                [{ 'align': [] }],                                // Alignment
                ['clean'],                                        // Tombol untuk menghapus format
                ['link', 'image', 'video']                        // Tombol untuk menyisipkan link, gambar, dan video
            ]
        }
    });
    // Menangkap nilai dari Quill ke input tersembunyi
    descriptionQuill.on('text-change', function() {
        document.querySelector('#description').value = descriptionQuill.root.innerHTML;
    });

    // Inisialisasi Quill untuk Ringkasan
    var summaryQuill = new Quill('#summary-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'color': [] }, { 'background': [] }],
                ['clean']
            ]
        }
    });
    summaryQuill.on('text-change', function() {
        document.querySelector('#summary').value = summaryQuill.root.innerHTML;
    });

    // Saat edit, isi editor dengan konten lama jika ada
    document.addEventListener("DOMContentLoaded", function() {
        descriptionQuill.root.innerHTML = `{!! $product->description !!}`;
        summaryQuill.root.innerHTML = `{!! $product->summary !!}`;
    });
</script>
@endsection
