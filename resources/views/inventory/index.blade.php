@extends('layouts.app')

@section('content')
<style>
    .inv-page-header {
        background: linear-gradient(135deg, #1a6b3a 0%, #28a745 60%, #5dd879 100%);
        border-radius: 12px; padding: 1.4rem 1.75rem;
        margin-bottom: 1.5rem;
    }
    .inv-page-header h4 { color: #fff; font-weight: 700; margin: 0; font-size: 1.25rem; }
    .inv-icon-wrap { width: 44px; height: 44px; border-radius: 10px; background: rgba(255,255,255,.2);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #fff; }
    .inv-card { border-radius: 12px; border: 1px solid #e9ecef;
        box-shadow: 0 1px 6px rgba(0,0,0,.06); overflow: hidden; background: #fff; }
    .inv-tbl thead tr { background: #343a40 !important; }
    .inv-tbl thead th { color: #fff !important; font-weight: 600; font-size: .75rem;
        text-transform: uppercase; letter-spacing: .06em; border: none !important; padding: .85rem 1rem;
        background: transparent !important; }
    .inv-tbl tbody td { border-color: #f1f3f5 !important; padding: .75rem 1rem; vertical-align: middle; color: #212529; }
    .inv-tbl tbody tr:hover { background: #f8f9fa; }
    .stat-card { border-radius: 10px; padding: 1.1rem 1.4rem; background: #fff;
        border: 1px solid #e9ecef; flex: 1; min-width: 160px; }
    .stat-card .lbl { font-size: .7rem; text-transform: uppercase; letter-spacing: .07em;
        color: #6c757d; margin-bottom: .35rem; }
    .stat-card .val { font-size: 1.9rem; font-weight: 700; color: #212529; }
    .stat-card .ico { font-size: 1.2rem; margin-bottom: .5rem; }
</style>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="mt-4">

            @if (session('success'))
                <script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session('success') }}' });</script>
            @endif

            {{-- Page Header --}}
            <div class="inv-page-header d-flex align-items-center gap-3 mb-4">
                <div class="inv-icon-wrap">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div>
                    <h4 class="mb-1">Inventory Stok Sepatu</h4>
                    <nav><ol class="breadcrumb mb-0" style="font-size:.8rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" style="color:rgba(255,255,255,.8);text-decoration:none;">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="color:#fff;">Inventory</li>
                    </ol></nav>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="d-flex flex-wrap gap-3 mb-4">
                <div class="stat-card">
                    <div class="ico text-secondary"><i class="fas fa-boxes"></i></div>
                    <div class="lbl">Total Item</div>
                    <div class="val">{{ $inventory->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="ico" style="color:#2c7be5;"><i class="fas fa-arrow-down"></i></div>
                    <div class="lbl">Total Masuk</div>
                    <div class="val" style="color:#2c7be5;">{{ $inventory->sum('stock_in') }}</div>
                </div>
                <div class="stat-card">
                    <div class="ico" style="color:#e67e22;"><i class="fas fa-arrow-up"></i></div>
                    <div class="lbl">Total Keluar</div>
                    <div class="val" style="color:#e67e22;">{{ $inventory->sum('stock_out') }}</div>
                </div>
                <div class="stat-card">
                    <div class="ico" style="color:#28a745;"><i class="fas fa-check-circle"></i></div>
                    <div class="lbl">Stok Saat Ini</div>
                    <div class="val" style="color:#28a745;">{{ $inventory->sum('current_stock') }}</div>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="inv-card">
                <div class="px-4 py-3" style="border-bottom:1px solid #e9ecef;">
                    <h6 class="mb-0 fw-semibold text-secondary" style="font-size:.82rem;text-transform:uppercase;letter-spacing:.06em;">
                        <i class="fas fa-list me-2"></i>Daftar Stok
                    </h6>
                </div>
                <div class="p-3 p-md-4">
                    <div class="table-responsive">
                        <table id="table" class="table inv-tbl mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Kode Sepatu</th>
                                    <th>Harga Satuan</th>
                                    <th>Stok Masuk</th>
                                    <th>Stok Keluar</th>
                                    <th>Stok Tersedia</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventory as $index => $item)
                                    <tr class="text-center">
                                        <td class="text-muted">{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $item->kode }}</td>
                                        <td>Rp {{ number_format($item->harga) }}</td>
                                        <td style="color:#2c7be5;">
                                            <i class="fas fa-arrow-down me-1" style="font-size:.75rem;"></i>{{ $item->stock_in }}
                                        </td>
                                        <td style="color:#e67e22;">
                                            <i class="fas fa-arrow-up me-1" style="font-size:.75rem;"></i>{{ $item->stock_out }}
                                        </td>
                                        <td class="fw-bold">{{ $item->current_stock }}</td>
                                        <td>
                                            @if($item->current_stock > 10)
                                                <span class="badge" style="background:#e6f4ea;color:#1e7e34;font-weight:600;border-radius:6px;padding:.35em .75em;font-size:.75rem;">
                                                    <i class="fas fa-check-circle me-1"></i>Tersedia
                                                </span>
                                            @elseif($item->current_stock > 0)
                                                <span class="badge" style="background:#fff8e1;color:#946300;font-weight:600;border-radius:6px;padding:.35em .75em;font-size:.75rem;">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>Hampir Habis
                                                </span>
                                            @else
                                                <span class="badge" style="background:#fde8e8;color:#c0392b;font-weight:600;border-radius:6px;padding:.35em .75em;font-size:.75rem;">
                                                    <i class="fas fa-times-circle me-1"></i>Habis
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 d-flex flex-wrap gap-3 pt-3" style="border-top:1px solid #f1f3f5;">
                        <span style="font-size:.78rem;color:#6c757d;display:flex;align-items:center;gap:5px;">
                            <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#1e7e34;"></span> Stok &gt; 10 — Tersedia
                        </span>
                        <span style="font-size:.78rem;color:#6c757d;display:flex;align-items:center;gap:5px;">
                            <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#946300;"></span> Stok 1–10 — Hampir Habis
                        </span>
                        <span style="font-size:.78rem;color:#6c757d;display:flex;align-items:center;gap:5px;">
                            <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#c0392b;"></span> Stok 0 — Habis
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
