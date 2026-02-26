@extends('layouts.app')

@section('content')
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="mt-5">
                @if (session('success'))
                    <script>
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: '{{ session('success') }}',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            showClass: { popup: 'animate__animated animate__slideInRight' },
                            hideClass: { popup: 'animate__animated animate__slideOutRight' }
                        });
                    </script>
                @endif
                @if ($errors->any())
                    <script>
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: '{{ $errors->first() }}',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            showClass: { popup: 'animate__animated animate__shakeX' },
                            hideClass: { popup: 'animate__animated animate__slideOutRight' }
                        });
                    </script>
                @endif
                
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0">Edit Profile</h1>
                    </div>
                </div>

                <div class="tab-content" id="orders-table-tab-content">
                    <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                        <div class="app-card app-card-orders-table shadow-sm mb-5">
                            <div class="app-card-body">
                                <div style="padding: 15px">
                                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <!-- Photo Section -->
                                        <div class="mb-4 text-center">
                                            <div class="mb-3">
                                                @if($user->photo)
                                                    <img id="photoPreview" src="{{ asset('foto/' . $user->photo) }}" 
                                                         alt="User Photo" class="rounded-circle" 
                                                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #dee2e6;">
                                                @else
                                                    <img id="photoPreview" src="{{ asset('assets/images/user.png') }}" 
                                                         alt="User Photo" class="rounded-circle" 
                                                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #dee2e6;">
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="photo" class="btn btn-sm app-btn-primary">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-camera me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                                        <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                                                    </svg>
                                                    Pilih Foto
                                                </label>
                                                <input type="file" id="photo" name="photo" class="d-none" accept="image/*" onchange="previewPhoto(this)">
                                            </div>
                                            <small class="text-muted">Format: JPG, JPEG, PNG, GIF. Max: 2MB</small>
                                        </div>

                                        <hr class="my-4">

                                        <!-- Name Field -->
                                        <div class="form-group row mt-3 mb-3">
                                            <label for="name" class="col-md-3 col-form-label text-md-right">
                                                <div class="fw-bold">Nama <span class="text-danger">*</span></div>
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Email Field -->
                                        <div class="form-group row mt-3 mb-3">
                                            <label for="email" class="col-md-3 col-form-label text-md-right">
                                                <div class="fw-bold">Email <span class="text-danger">*</span></div>
                                            </label>
                                            <div class="col-md-9">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <h5 class="mb-3 fw-bold">Ubah Password (Opsional)</h5>
                                        <p class="text-muted small">Biarkan kosong jika tidak ingin mengubah password</p>

                                        <!-- Password Field -->
                                        <div class="form-group row mt-3 mb-3">
                                            <label for="password" class="col-md-3 col-form-label text-md-right">
                                                <div class="fw-bold">Password Baru</div>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                           id="password" name="password" placeholder="Minimal 8 karakter">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye" id="password-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                @error('password')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Password Confirmation Field -->
                                        <div class="form-group row mt-3 mb-4">
                                            <label for="password_confirmation" class="col-md-3 col-form-label text-md-right">
                                                <div class="fw-bold">Konfirmasi Password</div>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input type="password" class="form-control" 
                                                           id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye" id="password_confirmation-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <!-- Action Buttons -->
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('dashboard.index') }}" class="btn app-btn-secondary">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                                </svg>
                                                Kembali
                                            </a>
                                            <button type="submit" class="btn app-btn-primary">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2 me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                                </svg>
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div><!--//padding-->
                            </div><!--//app-card-body-->
                        </div><!--//app-card-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Preview photo before upload
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photoPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.innerHTML = '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/><path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>';
            } else {
                field.type = 'password';
                icon.innerHTML = '<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>';
            }
        }
    </script>
@endsection
