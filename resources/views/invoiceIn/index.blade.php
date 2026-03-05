@extends('layouts.app')

@section('content')
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="mt-5">
                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: '{{ session('success') }}',
                        });
                    </script>
                @endif
                @if ($errors->any())
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '{{ $errors->first() }}',
                        });
                    </script>
                @endif
                <div class="row g-3 mb-3 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0">Invoice Masuk</h1>
                    </div>
                    <div class="col-auto">
                        <a class="btn app-btn-primary" href="{{ route('invoiceIn.create') }}">
                            <i class="fas fa-plus me-1"></i> New Invoice
                        </a>
                    </div>
                </div>

                {{-- ── Filter & Export Bar ── --}}
                <form method="GET" action="{{ route('invoiceIn.index') }}" id="filter-form">
                    <div class="app-card shadow-sm mb-3">
                        <div class="app-card-body p-3">
                            <div class="row g-2 align-items-end">
                                <div class="col-auto">
                                    <label class="form-label mb-1" style="font-size:.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:#555;">
                                        <i class="fas fa-search me-1"></i> Cari
                                    </label>
                                    <input type="text" id="search-orders" class="form-control form-control-sm" placeholder="ID Invoice..." style="min-width:160px;">
                                </div>
                                <div class="col-auto">
                                    <label class="form-label mb-1" style="font-size:.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:#555;">
                                        <i class="fas fa-calendar me-1"></i> Dari Tanggal
                                    </label>
                                    <input type="date" name="date_from" id="date_from" class="form-control form-control-sm"
                                        value="{{ $dateFrom ?? '' }}">
                                </div>
                                <div class="col-auto">
                                    <label class="form-label mb-1" style="font-size:.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:#555;">
                                        <i class="fas fa-calendar me-1"></i> Sampai Tanggal
                                    </label>
                                    <input type="date" name="date_to" id="date_to" class="form-control form-control-sm"
                                        value="{{ $dateTo ?? '' }}">
                                </div>
                                <div class="col-auto d-flex gap-2">
                                    <button type="submit" class="btn btn-sm btn-primary px-3" style="font-weight:600;">
                                        <i class="fas fa-filter me-1"></i> Filter
                                    </button>
                                    <a href="{{ route('invoiceIn.index') }}" class="btn btn-sm btn-secondary px-3" style="font-weight:600;">
                                        <i class="fas fa-times me-1"></i> Reset
                                    </a>
                                    <a href="{{ route('invoiceIn.export', array_filter(['date_from' => $dateFrom ?? '', 'date_to' => $dateTo ?? ''])) }}"
                                        class="btn btn-sm btn-success px-3" style="font-weight:600;">
                                        <i class="fas fa-file-excel me-1"></i> Export Excel
                                    </a>
                                </div>
                            </div>
                            @if($dateFrom || $dateTo)
                            <div class="mt-2">
                                <span class="badge bg-primary" style="font-size:.8rem;padding:.4em .8em;">
                                    <i class="fas fa-calendar-check me-1"></i>
                                    Menampilkan:
                                    {{ $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('d M Y') : 'Awal' }}
                                    &nbsp;–&nbsp;
                                    {{ $dateTo ? \Carbon\Carbon::parse($dateTo)->format('d M Y') : 'Sekarang' }}
                                    &nbsp;({{ $invoiceIn->count() }} invoice)
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // Client-side search filter on invoice number
                        const searchInput = document.getElementById('search-orders');
                        if (searchInput) {
                            searchInput.addEventListener('input', function () {
                                const q = this.value.toLowerCase();
                                document.querySelectorAll('tbody tr').forEach(row => {
                                    const cell = row.querySelector('td:nth-child(2)');
                                    if (cell) {
                                        row.style.display = cell.textContent.toLowerCase().includes(q) ? '' : 'none';
                                    }
                                });
                            });
                        }
                    });
                </script>

                <div class="tab-content" id="orders-table-tab-content">
                    <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                        <div class="app-card app-card-orders-table shadow-sm mb-5">
                            <div class="app-card-body">
                                <div class="table-responsive" style="padding: 15px">
                                    <style>
                                        .inv-tbl thead tr { background: #343a40 !important; }
                                        .inv-tbl thead th { color: #fff !important; font-weight: 600; font-size: .75rem;
                                            text-transform: uppercase; letter-spacing: .06em; border: none !important;
                                            padding: .85rem 1rem; background: transparent !important; text-align: center; }
                                        .inv-tbl tbody td { border-color: #f1f3f5 !important; padding: .75rem 1rem;
                                            vertical-align: middle; color: #212529; text-align: center; }
                                        .inv-tbl tbody tr:hover { background: #f8f9fa; }
                                        .dt-type-numeric { text-align: center !important; }
                                    </style>
                                    <table id="table" class="table inv-tbl mb-0">
                                        <thead>
                                            <tr>
                                                <th class="cell">
                                                    <div class="" style="text-align:center">No</div>
                                                </th>
                                                <th class="cell">
                                                    <div class="">ID Invoice</div>
                                                </th>
                                                <th class="cell">
                                                    <div class="text-center">Tanggal</div>
                                                </th>
                                                <th class="cell">
                                                    <div class="text-center">Subtotal</div>
                                                </th>
                                                <th class="cell">
                                                    <div class="text-center">Detail</div>
                                                </th>
                                                <th class="cell">
                                                    <div class="text-center">Aksi</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoiceIn as $index => $invoice)
                                                <tr class="text-center">
                                                    <td class="cell">{{ $index + 1 }}</td>
                                                    <td class="cell" style="white-space:nowrap;">{{ $invoice->nomor }}</td>
                                                    <td class="cell">
                                                        <span>{{ \Carbon\Carbon::parse($invoice->tgl)->format('d M Y') }}</span>
                                                        <span class="note">{{ \Carbon\Carbon::parse($invoice->created_at)->format('g:i A') }}</span>
                                                    </td>
                                                    <td class="cell">Rp. {{ number_format($invoice->total) }}</td>
                                                    <td class="cell">
                                                        <a class="btn btn-sm btn-outline-primary px-3" style="border-radius:20px;font-size:.8rem;font-weight:600;" data-bs-toggle="modal"
                                                            data-bs-target="#invoiceModal-{{ $invoice->id }}"><i class="fas fa-eye me-1"></i>Lihat</a>
                                                    </td>
                                                    <td class="cell" style="white-space:nowrap;">
                                                        <a href="{{ route('invoiceIn.print', $invoice->id) }}" target="_blank"
                                                            class="btn btn-sm btn-secondary"
                                                            style="border-radius:20px;font-size:.8rem;font-weight:600;">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                        <form id="deleteForm{{ $invoice->id }}"
                                                            action="{{ route('invoiceIn.destroy', $invoice->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="{{ route('invoiceIn.edit', $invoice->id) }}"
                                                                class="btn btn-warning btn-sm" style="border-radius:20px;">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button"
                                                                onclick="confirmDelete({{ $invoice->id }})"
                                                                class="btn btn-danger btn-sm" style="border-radius:20px;">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

<style>
    .inv-modal-header-in { background: linear-gradient(135deg, #1557b0, #2c7be5); padding: 1.4rem 1.75rem; }
    .inv-modal-header-in .inv-no { color: white; font-size: 1.15rem; font-weight: 700; margin: 0; }
    .inv-badge-pill { display: inline-flex; align-items: center; gap: .3rem;
        background: rgba(255,255,255,.2); color: white; padding: .28rem .7rem;
        border-radius: 20px; font-size: .76rem; font-weight: 600; }
    .inv-modal-tbl thead tr { background: linear-gradient(90deg, #1a68d1, #5ba8ff); }
    .inv-modal-tbl thead th { color: white !important; font-size: .76rem; text-transform: uppercase;
        letter-spacing: .04em; border: none !important; padding: .7rem 1rem; font-weight: 600; }
    .inv-modal-tbl tbody td { padding: .7rem 1rem; border-color: #e4eefb !important; font-size: .9rem; }
    .inv-modal-tbl tbody tr:nth-child(even) { background: #f5f9ff; }
    .inv-footsum { background: linear-gradient(135deg, #1557b0, #2c7be5); border-radius: 10px;
        padding: .9rem 1.25rem; color: white; display: flex; align-items: center; justify-content: space-between; }
    .inv-footsum .fs-lbl { font-size: .72rem; text-transform: uppercase; letter-spacing: .08em; opacity: .82; }
    .inv-footsum .fs-amt { font-size: 1.3rem; font-weight: 700; }
    #invoiceModal-{{ $invoice->id ?? '' }} .modal-content { border-radius: 14px !important; overflow: hidden; border: none !important; }
</style>
                                    @foreach ($invoiceIn as $index => $invoice)
                                        <div class="modal fade" id="invoiceModal-{{ $invoice->id }}" tabindex="-1"
                                            aria-labelledby="invoiceModalLabel-{{ $invoice->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;box-shadow:0 10px 40px rgba(0,0,0,.15);">
                                                    {{-- Styled Header --}}
                                                    <div class="inv-modal-header-in">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <div style="font-size:.68rem;color:rgba(255,255,255,.75);text-transform:uppercase;letter-spacing:.09em;margin-bottom:.3rem;">
                                                                    <i class="fas fa-file-import me-1"></i> Invoice Masuk
                                                                </div>
                                                                <h5 class="inv-no"># {{ $invoice->nomor }}</h5>
                                                                <div class="d-flex flex-wrap gap-2 mt-2">
                                                                    <span class="inv-badge-pill"><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($invoice->tgl)->format('d M Y') }}</span>
                                                                    <span class="inv-badge-pill"><i class="fas fa-box"></i> {{ $invoice->items->count() }} item</span>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn-close btn-close-white mt-1" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                    </div>
                                                    {{-- Body --}}
                                                    <div class="modal-body p-3 p-md-4">
                                                        <div class="table-responsive">
                                                            <table class="table inv-modal-tbl mb-0">
                                                                <thead>
                                                                    <tr class="text-center">
                                                                        <th>Kode Sepatu</th>
                                                                        <th>Jumlah</th>
                                                                        <th>Harga</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($invoice->items as $item)
                                                                        <tr class="text-center">
                                                                            <td>{{ $item->sepatu->kode }}</td>
                                                                            <td><span class="badge bg-light text-dark" style="font-size:.85rem;padding:.4em .7em;">{{ $item->jumlah }}</span></td>
                                                                            <td>Rp {{ number_format($item->harga) }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="inv-footsum mt-3">
                                                            <div class="fs-lbl"><i class="fas fa-calculator me-1"></i> Total Pembayaran</div>
                                                            <div class="fs-amt">Rp {{ number_format($invoice->total) }}</div>
                                                        </div>
                                                    </div>
                                                    {{-- Footer --}}
                                                    <div class="modal-footer border-0 pt-0 px-4 pb-3">
                                                        <a href="{{ route('invoiceIn.print', $invoice->id) }}" target="_blank"
                                                            class="btn btn-primary" style="border-radius:8px;padding:.5rem 1.5rem;font-weight:600;">
                                                            <i class="fas fa-print me-1"></i> Cetak Surat Jalan
                                                        </a>
                                                        <button type="button" class="btn btn-outline-secondary" style="border-radius:8px;padding:.5rem 1.5rem;font-weight:600;" data-bs-dismiss="modal">
                                                            <i class="fas fa-times me-1"></i> Tutup
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div><!--//table-responsive-->
                            </div><!--//app-card-body-->
                        </div><!--//app-card-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(invoiceId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan tindakan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus saja!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + invoiceId).submit();
                }
            });
        }
    </script>
@endsection
