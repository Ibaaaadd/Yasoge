@extends('layouts.app')

@section('content')

<style>
    /* ── User page styles ─────────────────────────────── */
    .badge-role {
        font-size: .74rem; font-weight: 600; padding: .32em .72em;
        border-radius: 20px; letter-spacing: .3px;
    }
    .badge-admin   { background:#d1fae5; color:#065f46; }
    .badge-manager { background:#fef3c7; color:#92400e; }
    .badge-user    { background:#dbeafe; color:#1e40af; }

    #table thead th {
        background: #343a40;
        color: #fff; font-size: .75rem; font-weight: 600;
        text-transform: uppercase; letter-spacing: .06em;
        border: none !important; white-space: nowrap;
        text-align: center; vertical-align: middle; padding: .85rem 1rem;
    }
    #table tbody tr { transition: background .15s; }
    #table tbody tr:hover { background: #f8f9fa; }
    #table tbody td { vertical-align: middle; font-size: .9rem; text-align: center; border-color: #f1f3f5 !important; padding: .75rem 1rem; }

    .btn-action {
        border: none; border-radius: 8px; padding: .28rem .72rem;
        font-size: .8rem; font-weight: 600; cursor: pointer;
        display: inline-flex; align-items: center; gap: 4px; transition: opacity .15s;
    }
    .btn-action:hover { opacity: .82; }
    .btn-edit   { background:#e0f2fe; color:#0369a1; }
    .btn-delete { background:#fee2e2; color:#dc2626; }

    .modal-header-green {
        background: linear-gradient(135deg,#15a362,#0b7044);
        color:#fff; border-radius: .5rem .5rem 0 0;
    }
    .modal-header-green .btn-close { filter: invert(1) grayscale(1); }

    .stat-card {
        border-radius: 14px; padding: 1rem 1.3rem; color: #fff;
        display: flex; align-items: center; gap: 1rem;
        box-shadow: 0 4px 14px rgba(0,0,0,.10);
    }
    .stat-card .stat-icon {
        width: 52px; height: 52px; border-radius: 12px;
        background: rgba(255,255,255,.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; flex-shrink: 0;
    }
    .stat-card .stat-value { font-size: 1.8rem; font-weight: 700; line-height: 1; }
    .stat-card .stat-label { font-size: .82rem; opacity: .85; margin-top: 2px; }
    .stat-green   { background: linear-gradient(135deg,#15a362,#0b7044); }
    .stat-blue    { background: linear-gradient(135deg,#3b82f6,#1d4ed8); }
    .stat-yellow  { background: linear-gradient(135deg,#f59e0b,#b45309); }

    .form-label-fw { font-weight: 600; font-size: .88rem; color:#374151; }
    .form-control, .form-select { border-radius: 8px; font-size: .9rem; border-color:#d1d5db; }
    .form-control:focus, .form-select:focus { border-color:#15a362; box-shadow: 0 0 0 .2rem rgba(21,163,98,.18); }
</style>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="mt-5">

            {{-- ── Alerts ── --}}
            @if (session('success'))
                <script>
                    Swal.fire({ toast:true, position:'top-end', icon:'success',
                        title:'{{ session("success") }}', showConfirmButton:false,
                        timer:3000, timerProgressBar:true });
                </script>
            @endif
            @if ($errors->any())
                <script>
                    Swal.fire({ toast:true, position:'top-end', icon:'error',
                        title:'{{ $errors->first() }}', showConfirmButton:false,
                        timer:4000, timerProgressBar:true });
                </script>
            @endif

            {{-- ── Page header ── --}}
            <div class="row g-3 mb-3 align-items-center justify-content-between">
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#15a362,#0b7044);
                                    display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem;">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h1 class="app-page-title mb-0">Manajemen Users</h1>
                            <p class="text-muted mb-0" style="font-size:.82rem;">Kelola akun pengguna sistem</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="row g-2 justify-content-end align-items-center">
                        <div class="col-auto">
                            <form class="row gx-1 align-items-center" id="search-form"
                                method="GET" action="{{ route('users.search') }}">
                                <div class="col-auto">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0" style="border-radius:8px 0 0 8px;">
                                            <i class="fas fa-search text-muted" style="font-size:.8rem;"></i>
                                        </span>
                                        <input type="text" id="search-orders" name="searchorders"
                                            class="form-control border-start-0 ps-0" placeholder="Cari pengguna..."
                                            style="border-radius:0 8px 8px 0; min-width:180px;">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn app-btn-secondary">Cari</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-auto">
                            <a class="btn app-btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#createUserModal">
                                <i class="fas fa-user-plus me-1"></i> Tambah User
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Stat cards ── --}}
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-4">
                    <div class="stat-card stat-green">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div>
                            <div class="stat-value">{{ $users->count() }}</div>
                            <div class="stat-label">Total Pengguna</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="stat-card stat-blue">
                        <div class="stat-icon"><i class="fas fa-user-shield"></i></div>
                        <div>
                            <div class="stat-value">{{ $users->where('type', 1)->count() }}</div>
                            <div class="stat-label">Admin</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="stat-card stat-yellow">
                        <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
                        <div>
                            <div class="stat-value">{{ $users->where('type', 2)->count() }}</div>
                            <div class="stat-label">Manager</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Table card ── --}}
            <div class="app-card app-card-orders-table shadow-sm mb-5" style="border-radius:14px; overflow:hidden;">
                <div class="app-card-body">
                    <div class="table-responsive" style="padding:16px;">
                        <table id="table" class="table app-table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="width:50px;">No</th>
                                    <th>Pengguna</th>
                                    <th>Email</th>
                                    <th style="width:130px;">Peran</th>
                                    <th style="width:160px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $user)
                                    @php
                                        $roleLabel = match((int)$user->type) {
                                            1 => ['label'=>'Admin',   'class'=>'badge-admin'],
                                            2 => ['label'=>'Manager', 'class'=>'badge-manager'],
                                            default => ['label'=>'User','class'=>'badge-user'],
                                        };
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><span class="fw-semibold">{{ $user->name }}</span></td>
                                        <td>
                                            <span class="text-muted">
                                                <i class="fas fa-envelope me-1" style="font-size:.75rem;"></i>{{ $user->email }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge-role {{ $roleLabel['class'] }}">
                                                {{ $roleLabel['label'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button class="btn-action btn-edit" data-bs-toggle="modal"
                                                    data-bs-target="#editUserModal-{{ $user->id }}">
                                                    <i class="fas fa-pen"></i> Edit
                                                </button>
                                                <form id="deleteForm{{ $user->id }}" method="POST"
                                                    action="{{ route('users.destroy', $user->id) }}"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-action btn-delete"
                                                        onclick="confirmDelete({{ $user->id }})">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ── Edit Modals ── --}}
            @foreach ($users as $user)
                <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1"
                    aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header modal-header-green">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-user-edit"></i>
                                    <h5 class="modal-title fw-bold mb-0" id="editUserModalLabel-{{ $user->id }}">Edit User</h5>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-4 py-3">
                                <form method="POST" action="{{ route('users.update', $user->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label form-label-fw">
                                            <i class="fas fa-user me-1 text-success"></i>Nama
                                        </label>
                                        <input type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ $user->name }}" required autocomplete="name">
                                        @error('name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label form-label-fw">
                                            <i class="fas fa-envelope me-1 text-success"></i>Email
                                        </label>
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ $user->email }}" required autocomplete="email">
                                        @error('email')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label form-label-fw">
                                            <i class="fas fa-shield-alt me-1 text-success"></i>Peran
                                        </label>
                                        <select class="form-select @error('type') is-invalid @enderror" name="type">
                                            <option value="">Pilih Peran</option>
                                            <option value="0" {{ old('type',$user->type)==0?'selected':'' }}>User</option>
                                            <option value="1" {{ old('type',$user->type)==1?'selected':'' }}>Admin</option>
                                            <option value="2" {{ old('type',$user->type)==2?'selected':'' }}>Manager</option>
                                        </select>
                                        @error('type')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="fas fa-save me-1"></i> Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- ── Create Modal ── --}}
            <div class="modal fade" id="createUserModal" tabindex="-1"
                aria-labelledby="createUserModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header modal-header-green">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-user-plus"></i>
                                <h5 class="modal-title fw-bold mb-0" id="createUserModalLabel">Tambah User Baru</h5>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4 py-3">
                            <form method="POST" action="{{ route('users.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label form-label-fw">
                                        <i class="fas fa-user me-1 text-success"></i>Nama
                                    </label>
                                    <input type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="Nama lengkap">
                                    @error('name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label form-label-fw">
                                        <i class="fas fa-envelope me-1 text-success"></i>Email
                                    </label>
                                    <input type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="contoh@email.com">
                                    @error('email')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label form-label-fw">
                                        <i class="fas fa-lock me-1 text-success"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <input id="password" type="text"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="new-password"
                                            placeholder="Masukkan atau generate password">
                                        <button id="generatePasswordButton" class="btn btn-success" type="button"
                                            title="Generate password otomatis">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </div>
                                    @error('password')<span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label form-label-fw">
                                        <i class="fas fa-shield-alt me-1 text-success"></i>Peran
                                    </label>
                                    <select class="form-select @error('type_id') is-invalid @enderror" name="type" required>
                                        <option value="">Pilih Peran</option>
                                        <option value="0">User</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Manager</option>
                                    </select>
                                    @error('type_id')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="fas fa-user-plus me-1"></i> Buat Akun
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const passwordInput  = document.getElementById("password");
        const generateButton = document.getElementById("generatePasswordButton");
        const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";

        generateButton.addEventListener("click", function () {
            let pwd = "";
            for (let i = 0; i < 12; i++) {
                pwd += charset[Math.floor(Math.random() * charset.length)];
            }
            passwordInput.value = pwd;
        });
    });

    function confirmDelete(userId) {
        Swal.fire({
            title: 'Hapus pengguna ini?',
            text: "Data yang dihapus tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + userId).submit();
            }
        });
    }
</script>
@endsection
