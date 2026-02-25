@extends('layouts.app')

@section('content')
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="mt-5">
                <div class="row g-3 mb-4 align-items-center justify-content-between">
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
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0">Sepatu</h1>
                    </div>
                    <div class="col-auto">
                        <div class="page-utilities">
                            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                                <div class="col-auto">
                                    <form class="docs-search-form row gx-1 align-items-center" id="search-form">
                                        <div class="col-auto">
                                            <input type="text" id="search-docs" name="searchdocs"
                                                class="form-control search-docs" placeholder="Search">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn app-btn-secondary">Search</button>
                                        </div>
                                    </form>
                                </div><!--//col-->
                                <div class="col-auto">
                                    <a class="btn app-btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#tambahSepatuModal">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-upload me-2"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                            <path fill-rule="evenodd"
                                                d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                        </svg>Upload File
                                    </a>
                                </div>
                            </div><!--//row-->
                        </div><!--//table-utilities-->
                    </div><!--//col-auto-->
                </div>
            </div><!--//row-->

            {{-- Carousel Showcase --}}
            @if ($sepatu->count() > 0)
            <div class="app-card shadow-sm mb-4 overflow-hidden" style="border-radius: 12px;">
                <div id="sepatuCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3500">
                    <div class="carousel-indicators">
                        @foreach ($sepatu->take(6) as $idx => $slide)
                            <button type="button" data-bs-target="#sepatuCarousel" data-bs-slide-to="{{ $idx }}"
                                class="{{ $idx === 0 ? 'active' : '' }}" aria-label="Slide {{ $idx + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach ($sepatu->take(6) as $idx => $slide)
                            <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                                <div class="carousel-card d-flex align-items-center">
                                    <div class="carousel-img-wrapper">
                                        <img src="{{ asset('foto/' . $slide->gambar) }}" alt="{{ $slide->kode }}">
                                    </div>
                                    <div class="carousel-caption-custom">
                                        <span class="badge bg-primary mb-2">Featured</span>
                                        <h3 class="fw-bold mb-1">{{ $slide->kode }}</h3>
                                        <p class="text-muted mb-2">Rp {{ number_format($slide->harga, 0, ',', '.') }}</p>
                                        <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewSepatuModal_{{ $slide->id }}">
                                            <i class="fa-solid fa-eye me-1"></i> Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#sepatuCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#sepatuCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
            @endif

            <div class="row" id="sepatu-list">
                @foreach ($sepatu as $item)
                    <div class="col-6 col-md-4 col-xl-3 col-xxl-3 mt-4 sepatu-item">
                        <div class="app-card app-card-doc shadow-sm h-100">
                            <div class="app-card-thumb-holder p-3">
                                <div class="app-card-thumb">
                                    <img class="thumb-image" src="{{ asset('foto') }}/{{ $item->gambar }}" alt="{{ $item->nama }}">
                                </div>
                                <a class="app-card-link-mask" href="#file-link" data-bs-toggle="modal"
                                    data-bs-target="#viewSepatuModal_{{ $item->id }}"></a>
                            </div>
                            <div class="app-card-body p-3 has-card-actions">
                                <h4 class="app-doc-title truncate mb-0"><a href="#file-link">{{ $item->kode }}</a></h4>
                                <div class="app-doc-meta">
                                    <ul class="list-unstyled mb-0">
                                        <li><span class="text-muted"></span> {{ $item->nama }}</li>
                                        <li><span class="text-muted">Harga:</span> Rp. {{ $item->harga }}</li>
                                        <li><span class="text-muted">Uploaded:</span>
                                            {{ date('d M Y', strtotime($item->created_at)) }}</li>
                                        @if ($item->updated_at && $item->updated_at != $item->created_at)
                                            <li><span class="text-muted">Updated:</span>
                                                {{ date('d M Y', strtotime($item->updated_at)) }}</li>
                                        @endif
                                    </ul>
                                </div><!--//app-doc-meta-->

                                <div class="app-card-actions">
                                    <div class="dropdown">
                                        <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                class="bi bi-three-dots-vertical" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                            </svg>
                                        </div><!--//dropdown-toggle-->
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#viewSepatuModal_{{ $item->id }}">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                        class="bi bi-eye me-2" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z" />
                                                        <path fill-rule="evenodd"
                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                                    </svg>
                                                    View
                                                </a>
                                            </li>

                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#updateSepatuModal_{{ $item->id }}">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                    class="bi bi-pencil me-2" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('sepatu.download', $item->id) }}">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                        class="bi bi-download me-2" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                        <path fill-rule="evenodd"
                                                            d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                                    </svg>
                                                    Download
                                                </a>
                                            </li>

                                            <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#"
                                                    onclick="event.preventDefault(); confirmDelete('{{ $item->id }}');">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                        class="bi bi-trash me-2" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                        <path fill-rule="evenodd"
                                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                    </svg>
                                                    Delete
                                                </a>
                                            </li>

                                            <form id="delete-form-{{ $item->id }}"
                                                action="{{ route('sepatu.destroy', $item->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                        </ul>
                                    </div><!--//dropdown-->
                                </div><!--//app-card-actions-->
                            </div><!--//app-card-body-->
                        </div><!--//app-card-->
                    </div><!--//col-->
                @endforeach

                <!--Modal Create-->
                <div class="modal fade" id="tambahSepatuModal" tabindex="-1" role="dialog"
                    aria-labelledby="tambahSepatuModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-custom">
                            <div class="modal-header-custom bg-primary text-white">
                                <div class="d-flex align-items-center">
                                    <div class="modal-icon-circle bg-white text-primary me-3">
                                        <i class="fa-solid fa-plus"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold">Tambah Sepatu Baru</h5>
                                        <small class="opacity-75">Isi data produk sepatu</small>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form method="POST" action="{{ route('sepatu.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body p-4">
                                    {{-- Image Preview --}}
                                    <div class="text-center mb-4">
                                        <div class="img-preview-box" id="createPreviewBox">
                                            <i class="fa-solid fa-image fa-3x text-muted"></i>
                                            <p class="text-muted mt-2 mb-0 small">Preview gambar</p>
                                        </div>
                                        <img id="createPreviewImg" class="img-preview-actual d-none" alt="Preview">
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode" required>
                                        <label for="kode"><i class="fa-solid fa-barcode me-2"></i>Kode Sepatu</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="harga" name="harga" step="0.01" placeholder="Harga" required>
                                        <label for="harga"><i class="fa-solid fa-tag me-2"></i>Harga (Rp)</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gambar" class="form-label fw-semibold"><i class="fa-solid fa-camera me-2"></i>Gambar</label>
                                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required
                                            onchange="previewFile(this, 'createPreviewImg', 'createPreviewBox')">
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!--Modal Edit-->
                @foreach ($sepatu as $item)
                    <div class="modal fade" id="updateSepatuModal_{{ $item->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="updateSepatuModalLabel_{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-custom">
                                <div class="modal-header-custom bg-warning text-dark">
                                    <div class="d-flex align-items-center">
                                        <div class="modal-icon-circle bg-white text-warning me-3">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0 fw-bold">Edit Sepatu</h5>
                                            <small class="opacity-75">{{ $item->kode }}</small>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form method="POST" action="{{ route('sepatu.update', $item->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body p-4">
                                        {{-- Current Image --}}
                                        <div class="text-center mb-4">
                                            <img src="{{ asset('foto/' . $item->gambar) }}" class="img-preview-actual" id="editPreviewImg_{{ $item->id }}" alt="{{ $item->kode }}">
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="kode_{{ $item->id }}"
                                                name="kode" value="{{ $item->kode }}" placeholder="Kode" required>
                                            <label for="kode_{{ $item->id }}"><i class="fa-solid fa-barcode me-2"></i>Kode Sepatu</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="harga_{{ $item->id }}"
                                                name="harga" step="0.01" value="{{ $item->harga }}" placeholder="Harga" required>
                                            <label for="harga_{{ $item->id }}"><i class="fa-solid fa-tag me-2"></i>Harga (Rp)</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="gambar_{{ $item->id }}" class="form-label fw-semibold"><i class="fa-solid fa-camera me-2"></i>Ganti Gambar</label>
                                            <input type="file" class="form-control"
                                                id="gambar_{{ $item->id }}" name="gambar" accept="image/*"
                                                onchange="previewFile(this, 'editPreviewImg_{{ $item->id }}', null)">
                                            <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fa-solid fa-floppy-disk me-1"></i> Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!--Modal View-->
                @foreach ($sepatu as $item)
                    <div class="modal fade" id="viewSepatuModal_{{ $item->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="viewSepatuModalLabel_{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content modal-custom overflow-hidden">
                                <div class="row g-0">
                                    <div class="col-md-6 view-modal-img-wrapper">
                                        <img src="{{ asset('foto/' . $item->gambar) }}" alt="{{ $item->kode }}" class="view-modal-img">
                                    </div>
                                    <div class="col-md-6 d-flex flex-column">
                                        <div class="p-4 flex-grow-1">
                                            <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                            <span class="badge bg-success mb-3"><i class="fa-solid fa-shoe-prints me-1"></i> Produk Sepatu</span>
                                            <h3 class="fw-bold mb-1">{{ $item->kode }}</h3>
                                            <h4 class="text-primary fw-bold mb-4">Rp {{ number_format($item->harga, 0, ',', '.') }}</h4>
                                            <hr>
                                            <div class="mb-2">
                                                <small class="text-muted d-block mb-1"><i class="fa-regular fa-calendar me-1"></i> Uploaded</small>
                                                <span class="fw-semibold">{{ date('d M Y, H:i', strtotime($item->created_at)) }}</span>
                                            </div>
                                            @if ($item->updated_at && $item->updated_at != $item->created_at)
                                            <div class="mb-2">
                                                <small class="text-muted d-block mb-1"><i class="fa-regular fa-clock me-1"></i> Updated</small>
                                                <span class="fw-semibold">{{ date('d M Y, H:i', strtotime($item->updated_at)) }}</span>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="p-4 pt-0 d-flex gap-2">
                                            <a href="{{ route('sepatu.download', $item->id) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                                <i class="fa-solid fa-download me-1"></i> Download
                                            </a>
                                            <a href="#" class="btn btn-outline-warning btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#updateSepatuModal_{{ $item->id }}">
                                                <i class="fa-solid fa-pen me-1"></i> Edit
                                            </a>
                                            <a href="#" class="btn btn-outline-danger btn-sm flex-fill" onclick="event.preventDefault(); confirmDelete('{{ $item->id }}');">
                                                <i class="fa-solid fa-trash me-1"></i> Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div><!--//container-fluid-->
        </div><!--//app-content-->
    </div>

    <style>
        /* === CARD === */
        .app-card-doc {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .app-card-doc:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0,0,0,.12) !important;
        }
        .app-card-thumb-holder {
            position: relative;
            height: 200px;
            overflow: hidden;
            background: linear-gradient(135deg, #f0f4ff 0%, #e8ecf5 100%);
            padding: 0 !important;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        .app-card-thumb { width: 100%; height: 100%; }
        .thumb-image {
            width: 100%; height: 100%;
            object-fit: cover; object-position: center;
            transition: transform .4s ease;
        }
        .app-card-doc:hover .thumb-image { transform: scale(1.08); }
        .app-doc-title { font-weight: 700; font-size: 1.05rem; }
        .app-doc-title a { color: #333; text-decoration: none; }
        .app-doc-meta ul li {
            font-size: 0.82rem;
            margin-bottom: 0.2rem;
            color: #6c757d;
        }
        .app-card-actions .dropdown-toggle { color: #b0b0b0; transition: color .2s; }
        .app-card-actions .dropdown-toggle:hover { color: #333; }
        .app-card-body {
            display: flex; flex-direction: column; justify-content: space-between;
        }

        /* === CAROUSEL === */
        .carousel-card {
            height: 260px;
            background: linear-gradient(135deg, #f8f9ff 0%, #eef1f8 100%);
        }
        .carousel-img-wrapper {
            width: 50%; height: 100%;
            overflow: hidden;
        }
        .carousel-img-wrapper img {
            width: 100%; height: 100%;
            object-fit: cover; object-position: center;
            transition: transform .6s ease;
        }
        .carousel-item.active .carousel-img-wrapper img,
        .carousel-item-next .carousel-img-wrapper img { transform: scale(1.03); }
        .carousel-caption-custom {
            width: 50%; padding: 2rem 2.5rem;
            display: flex; flex-direction: column; justify-content: center;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0,0,0,.4);
            border-radius: 50%; padding: 12px;
            background-size: 50%;
        }
        @media (max-width: 768px) {
            .carousel-card { height: 200px; }
            .carousel-img-wrapper { width: 40%; }
            .carousel-caption-custom { width: 60%; padding: 1rem 1.2rem; }
            .carousel-caption-custom h3 { font-size: 1.1rem; }
        }

        /* === MODALS === */
        .modal-custom { border: none; border-radius: 16px; overflow: hidden; }
        .modal-header-custom {
            padding: 1.2rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
        }
        .modal-icon-circle {
            width: 42px; height: 42px;
            border-radius: 50%; display: flex;
            align-items: center; justify-content: center;
            font-size: 1.1rem; flex-shrink: 0;
        }
        .img-preview-box {
            width: 160px; height: 160px; margin: 0 auto;
            border: 2px dashed #dee2e6; border-radius: 12px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            background: #f8f9fa;
        }
        .img-preview-actual {
            max-height: 200px; max-width: 100%;
            object-fit: contain; border-radius: 10px;
            margin: 0 auto; display: block;
            box-shadow: 0 4px 12px rgba(0,0,0,.08);
        }
        .view-modal-img-wrapper {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8ecf5 100%);
            display: flex; align-items: center; justify-content: center;
            min-height: 320px; overflow: hidden;
        }
        .view-modal-img {
            width: 100%; height: 100%;
            object-fit: cover; object-position: center;
        }
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label { color: #5b6bcd; }
        .form-control:focus { border-color: #5b6bcd; box-shadow: 0 0 0 .2rem rgba(91,107,205,.15); }

        /* === ANIMATE CARDS ON LOAD === */
        .sepatu-item {
            animation: fadeInUp .5s ease both;
        }
        .sepatu-item:nth-child(2) { animation-delay: .05s; }
        .sepatu-item:nth-child(3) { animation-delay: .1s; }
        .sepatu-item:nth-child(4) { animation-delay: .15s; }
        .sepatu-item:nth-child(5) { animation-delay: .2s; }
        .sepatu-item:nth-child(6) { animation-delay: .25s; }
        .sepatu-item:nth-child(7) { animation-delay: .3s; }
        .sepatu-item:nth-child(8) { animation-delay: .35s; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>

    <!--Javascript Search-->
    <script>
        document.getElementById('search-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting in the traditional way
            const searchTerm = document.getElementById('search-docs').value.toLowerCase();
            const items = document.querySelectorAll('.sepatu-item');

            items.forEach(item => {
                const kode = item.querySelector('.app-doc-title a').textContent.toLowerCase();
                const nama = item.querySelector('.app-doc-meta').textContent.toLowerCase();
                if (kode.includes(searchTerm) || nama.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>

    <!--Javascript Delete-->
    <script>
        function confirmDelete(itemId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan tindakan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '<i class="fa-solid fa-trash me-1"></i> Ya, hapus!',
                cancelButtonText: '<i class="fa-solid fa-xmark me-1"></i> Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + itemId).submit();
                }
            });
        }

        // Image preview for create/edit modals
        function previewFile(input, imgId, boxId) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById(imgId);
                    img.src = e.target.result;
                    img.classList.remove('d-none');
                    if (boxId) {
                        document.getElementById(boxId).classList.add('d-none');
                    }
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
