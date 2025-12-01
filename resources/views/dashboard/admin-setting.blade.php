@extends('dashboard.layouts.index')

@section('content')
<main id="main" class="main">
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    @if($admin->photo)
                        <img src="{{ asset('storage/photo-user/' . $admin->photo) }}" alt="Profile" class="rounded-circle">
                    @else
                        <img src="{{ Helper::userDefaultImage() }}">
                    @endif
                        <h2>{{ $admin->name }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
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
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Profil Saya</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profil</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ganti Password</button>
                            </li>
                        </ul>
                        
                        <div class="tab-content pt-2">
                            <!-- Overview Tab -->
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Detail Profil</h5>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Nama Lengkap</div>
                                    <div class="col-lg-9 col-md-8">{{ $admin->name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ $admin->email }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">No. Handphone</div>
                                    <div class="col-lg-9 col-md-8">{{ $admin->phone }}</div>
                                </div>
                            </div>

                            <!-- Profile Edit Tab -->
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <form action="{{ route('admin-edit', ['id' => $admin->id]) }}" method="post" enctype="multipart/form-data">
                                  @csrf
                                    <div class="row mb-3">
                                        <label for="photo" class="col-md-4 col-lg-3 col-form-label">Foto Profil</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="{{ asset('storage/photo-user/' . $admin->photo) }}" alt="Profile" style="max-width: 100%; height: auto;">
                                            <div class="pt-2">
                                              <input class="form-control" type="file" name="photo" id="Formfile">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                        <div class="col-md-8 col-lg-9">
                                          <input class="form-control" type="text" name="name" value="{{ old('name', $admin->name) }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="phone" class="col-md-4 col-lg-3 col-form-label">No. Handphone</label>
                                        <div class="col-md-8 col-lg-9">
                                          <input class="form-control" type="text" name="phone" value="{{ old('phone', $admin->phone) }}">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                            <!-- Change Password Tab -->
                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <form action="{{ route('admin-pass') }}" method="post" enctype="multipart/form-data">
                                  @csrf
                                    <div class="row mb-3">
                                        <label for="currentPass" class="col-md-4 col-lg-3 col-form-label">Password Lama</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="current_password" type="password" class="form-control" id="currentPass" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                      <label for="password" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                                      <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control" id="password" required>
                                      </div>
                                    </div>
                                    <div class="row mb-3">
                                      <label for="confirmPass" class="col-md-4 col-lg-3 col-form-label">Konfirmasi Password Baru</label>
                                      <div class="col-md-8 col-lg-9">
                                        <input name="password_confirmation" type="password" class="form-control" id="confirmPass" required>
                                      </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Ganti Password</button>
                                    </div>
                                </form>
                            </div>
                        </div><!-- End Bordered Tabs -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
