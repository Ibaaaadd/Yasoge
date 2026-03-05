@extends('layouts.app')

@section('content')
<style>
    .inv-header-card {
        background: linear-gradient(135deg, #1557b0 0%, #2c7be5 60%, #70b0ff 100%);
        border-radius: 14px; padding: 1.5rem 2rem; margin-bottom: 1.75rem;
    }
    .inv-header-card h4 { color: #fff; font-weight: 700; margin: 0; }
    .inv-icon-wrap { width: 52px; height: 52px; border-radius: 50%; background: rgba(255,255,255,.2);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .inv-form-card { border-radius: 14px; border: none; box-shadow: 0 4px 28px rgba(44,123,229,.12); overflow: hidden; }
    .inv-form-section-head { background: #f0f6ff; padding: 1.1rem 1.5rem; border-bottom: 2px solid #d3e4fb;
        display: flex; align-items: center; gap: .65rem; }
    .inv-form-section-head i { color: #2c7be5; font-size: 1.1rem; }
    .inv-form-section-head h5 { margin: 0; font-weight: 700; color: #1a3a5c; font-size: .95rem; }
    .inv-form-body { padding: 1.75rem; }
    .inv-field-label { font-size: .75rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: #6c757d; margin-bottom: .4rem; display: block; }
    .inv-field-label i { color: #2c7be5; }
    .inv-control { border: 1.5px solid #dee2e6 !important; border-radius: 8px !important;
        padding: .6rem 1rem !important; font-size: .93rem !important; transition: border-color .2s, box-shadow .2s; }
    .inv-control:focus { border-color: #2c7be5 !important; box-shadow: 0 0 0 3px rgba(44,123,229,.15) !important; outline: none; }
    .inv-table-wrap { border-radius: 10px; overflow: hidden; border: 1.5px solid #d3e4fb; }
    .inv-table { margin: 0 !important; }
    .inv-table thead tr { background: linear-gradient(90deg, #1a68d1, #5ba8ff); }
    .inv-table thead th { color: #fff !important; font-weight: 600; font-size: .78rem;
        text-transform: uppercase; letter-spacing: .05em; border: none !important; padding: .8rem 1rem; }
    .inv-table tbody td { border-color: #e4eefb !important; padding: .7rem .9rem; vertical-align: middle; }
    .inv-table tbody tr:nth-child(even) { background: #f5f9ff; }
    .inv-table tbody tr:hover { background: #ebf2ff; }
    .qty-wrap { display: flex; align-items: center; border: 1.5px solid #dee2e6; border-radius: 8px;
        overflow: hidden; max-width: 120px; margin: 0 auto; }
    .qty-wrap .qty-btn { background: #f0f6ff; border: none; width: 34px; height: 36px;
        color: #2c7be5; cursor: pointer; transition: background .15s; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; }
    .qty-wrap .qty-btn:hover { background: #dbeafe; }
    .qty-wrap input { border: none; border-left: 1.5px solid #dee2e6; border-right: 1.5px solid #dee2e6;
        border-radius: 0; text-align: center; width: 52px; font-weight: 600; font-size: .88rem; padding: .3rem; }
    .qty-wrap input:focus { outline: none; box-shadow: none; }
    .harga-field { background: #f5f9ff; border: 1.5px solid #d3e4fb; border-radius: 8px;
        padding: .5rem .8rem; font-weight: 600; color: #1a3a5c; font-size: .9rem; width: 100%; }
    .btn-del-row { background: #fff0f0; border: 1.5px solid #ffcccc; color: #e53e3e;
        border-radius: 7px; width: 36px; height: 36px; padding: 0; display: flex;
        align-items: center; justify-content: center; transition: all .15s; }
    .btn-del-row:hover { background: #ffe0e0; border-color: #e53e3e; }
    .btn-add-row { border: 2px dashed #2c7be5; color: #2c7be5; background: transparent;
        border-radius: 8px; padding: .5rem 1.4rem; font-size: .86rem; font-weight: 600;
        cursor: pointer; transition: all .2s; display: inline-flex; align-items: center; gap: .5rem; }
    .btn-add-row:hover { background: #f0f6ff; border-style: solid; color: #1a68d1; }
    .total-card { background: linear-gradient(135deg, #1557b0, #2c7be5);
        border-radius: 12px; padding: 1.4rem 1.5rem; color: white; }
    .total-card .lbl { font-size: .75rem; text-transform: uppercase; letter-spacing: .08em; opacity: .85; margin-bottom: .4rem; }
    .total-card .amt { font-size: 1.75rem; font-weight: 700; }
    .btn-save-inv { background: linear-gradient(135deg, #1557b0, #2c7be5); border: none;
        border-radius: 8px; padding: .7rem 2.2rem; font-size: .95rem; font-weight: 600;
        color: white; transition: all .2s; display: inline-flex; align-items: center; gap: .5rem; }
    .btn-save-inv:hover { background: linear-gradient(135deg, #0e4a97, #1a68d1); transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(44,123,229,.4); color: white; }
    .btn-back-inv { border-radius: 8px; padding: .7rem 1.4rem; font-size: .93rem; font-weight: 600; }
</style>

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="mt-4">

                {{-- Page Header --}}
                <div class="inv-header-card d-flex align-items-center gap-3 mb-4">
                    <div class="inv-icon-wrap">
                        <i class="fas fa-edit fa-lg text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">Edit Invoice Masuk</h4>
                        <nav><ol class="breadcrumb mb-0" style="font-size:.82rem;">
                            <li class="breadcrumb-item"><a href="{{ route('invoiceIn.index') }}" style="color:rgba(255,255,255,.8);text-decoration:none;">Invoice Masuk</a></li>
                            <li class="breadcrumb-item active" style="color:white;">Edit #{{ $invoiceIn->nomor }}</li>
                        </ol></nav>
                    </div>
                </div>

                {{-- Form Card --}}
                <div class="inv-form-card card">
                    <div class="inv-form-section-head">
                        <i class="fas fa-pencil-alt"></i>
                        <h5>Ubah Detail Invoice</h5>
                    </div>
                    <div class="inv-form-body">
                        <form method="POST" action="{{ route('invoiceIn.update', $invoiceIn->id) }}">
                            @csrf
                            @method('PUT')
                            {{-- Header Info --}}
                            <div class="row g-3 mb-4">
                                <div class="col-sm-6">
                                    <label class="inv-field-label"><i class="fas fa-hashtag"></i> Nomor Invoice</label>
                                    <input type="text" name="nomor" id="nomor" class="form-control inv-control"
                                        value="{{ $invoiceIn->nomor }}" required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="inv-field-label"><i class="fas fa-calendar-alt"></i> Tanggal</label>
                                    <input type="date" name="tgl" id="tgl" class="form-control inv-control"
                                        value="{{ $invoiceIn->tgl }}" required>
                                </div>
                            </div>

                            {{-- Items Table --}}
                            <div class="mb-3">
                                <label class="inv-field-label mb-2"><i class="fas fa-boxes"></i> Item Sepatu</label>
                                <div class="inv-table-wrap">
                                    <table class="table inv-table">
                                        <thead>
                                            <tr>
                                                <th style="width:42%">Sepatu</th>
                                                <th class="text-center" style="width:24%">Jumlah</th>
                                                <th class="text-center" style="width:26%">Harga (Rp)</th>
                                                <th class="text-center" style="width:8%"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="items-container">
                                            @foreach ($invoiceIn->items as $index => $item)
                                                <tr class="item-row">
                                                    <td>
                                                        <select name="items[{{ $index }}][sepatu_id]"
                                                            class="form-control inv-control sepatu-select" required>
                                                            <option value="">Pilih item...</option>
                                                            @foreach ($sepatuItems as $sepatu)
                                                                <option value="{{ $sepatu->id }}"
                                                                    data-price="{{ $sepatu->harga }}"
                                                                    {{ $item->sepatu_id == $sepatu->id ? 'selected' : '' }}>
                                                                    {{ $sepatu->kode }} (Stok: {{ $sepatu->current_stock ?? 0 }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="qty-wrap mx-auto">
                                                            <button class="qty-btn" type="button" onclick="changeQuantity(this, -1)">
                                                                <i class="fas fa-minus" style="font-size:.65rem;"></i>
                                                            </button>
                                                            <input type="number" name="items[{{ $index }}][jumlah]"
                                                                class="jumlah-input" min="1"
                                                                value="{{ $item->jumlah }}" required
                                                                oninput="updatePrice(this)" />
                                                            <button class="qty-btn" type="button" onclick="changeQuantity(this, 1)">
                                                                <i class="fas fa-plus" style="font-size:.65rem;"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="items[{{ $index }}][harga]"
                                                            class="harga-field harga-input" required
                                                            value="{{ $item->harga }}" placeholder="0" readonly />
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn-del-row btn" onclick="removeItem(this)">
                                                            <i class="fas fa-trash-alt" style="font-size:.72rem;"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Add Row --}}
                            <div class="mb-4">
                                <button type="button" class="btn-add-row" onclick="addItemRow()">
                                    <i class="fas fa-plus"></i> Tambah Item
                                </button>
                            </div>

                            {{-- Total & Actions --}}
                            <div class="row justify-content-end">
                                <div class="col-md-6 col-lg-5">
                                    <div class="total-card mb-3">
                                        <div class="lbl"><i class="fas fa-calculator me-1"></i> Total Harga</div>
                                        <div class="amt" id="total-price">Rp 0</div>
                                        <input type="hidden" name="total" id="totali">
                                    </div>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('invoiceIn.index') }}" class="btn btn-secondary btn-back-inv">
                                            <i class="fas fa-arrow-left me-1"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn-save-inv btn">
                                            <i class="fas fa-save"></i> Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        let itemCount = {{ count($invoiceIn->items) }};

        const sepatuData = {
            @foreach ($sepatuItems as $sepatu)
            {{ $sepatu->id }}: { price: {{ $sepatu->harga }}, stock: {{ $sepatu->current_stock ?? 0 }}, kode: "{{ addslashes($sepatu->kode) }}" },
            @endforeach
        };

        const s2Config = {
            placeholder: 'Pilih item...', allowClear: true, width: '100%',
            language: { noResults: function() { return 'Tidak ada hasil'; }, searching: function() { return 'Mencari...'; } }
        };

        function getUsedIds(excludeRow) {
            const ids = [];
            document.querySelectorAll('.item-row').forEach(row => {
                if (row !== excludeRow) {
                    const sel = row.querySelector('.sepatu-select');
                    if (sel && sel.value) ids.push(parseInt(sel.value));
                }
            });
            return ids;
        }

        function rebuildDropdown(row) {
            const $sel    = $(row).find('.sepatu-select');
            const curVal  = parseInt($sel.val()) || 0;
            const usedIds = getUsedIds(row);
            let html = '';
            Object.entries(sepatuData).forEach(([id, d]) => {
                const iid = parseInt(id);
                if (usedIds.includes(iid)) return;
                html += `<option value="${iid}" data-price="${d.price}" data-stock="${d.stock}">${d.kode} (Stok: ${d.stock})</option>`;
            });
            try { $sel.select2('destroy'); } catch(e) {}
            $sel[0].innerHTML = '<option value="">Pilih item...</option>' + html;
            if (curVal && !usedIds.includes(curVal)) $sel.val(curVal);
            $sel.select2(s2Config);
        }

        function refreshAllDropdowns() {
            document.querySelectorAll('.item-row').forEach(row => rebuildDropdown(row));
        }

        function updatePrice(element) {
            const row  = element.closest('.item-row');
            const sel  = row.querySelector('.sepatu-select');
            const opt  = sel ? sel.options[sel.selectedIndex] : null;
            const unit = opt ? parseFloat(opt.getAttribute('data-price')) : NaN;
            const qty  = parseInt(row.querySelector('.jumlah-input').value);
            row.querySelector('.harga-input').value = (!isNaN(unit) && !isNaN(qty)) ? (unit * qty * 20).toFixed() : '';
            updateTotalPrice();
        }

        function changeQuantity(button, delta) {
            const input = button.closest('.qty-wrap').querySelector('input[type=number]');
            let v = parseInt(input.value) + delta;
            if (v < 1) v = 1;
            input.value = v;
            updatePrice(input);
        }

        function removeItem(button) {
            const row = button.closest('.item-row');
            try { $(row).find('.sepatu-select').select2('destroy'); } catch(e) {}
            row.remove();
            refreshAllDropdowns();
            updateTotalPrice();
        }

        function addItemRow() {
            const idx = itemCount++;
            const container = document.getElementById('items-container');
            const row = document.createElement('tr');
            row.classList.add('item-row');
            row.innerHTML = `
                <td>
                    <select name="items[${idx}][sepatu_id]" class="form-control inv-control sepatu-select" required></select>
                </td>
                <td>
                    <div class="qty-wrap mx-auto">
                        <button class="qty-btn" type="button" onclick="changeQuantity(this,-1)"><i class="fas fa-minus" style="font-size:.65rem;"></i></button>
                        <input type="number" name="items[${idx}][jumlah]" class="jumlah-input" min="1" value="1" required oninput="updatePrice(this)" />
                        <button class="qty-btn" type="button" onclick="changeQuantity(this,1)"><i class="fas fa-plus" style="font-size:.65rem;"></i></button>
                    </div>
                </td>
                <td>
                    <input type="number" name="items[${idx}][harga]" class="harga-field harga-input" required placeholder="0" readonly />
                </td>
                <td class="text-center">
                    <button type="button" class="btn-del-row btn" onclick="removeItem(this)"><i class="fas fa-trash-alt" style="font-size:.72rem;"></i></button>
                </td>
            `;
            container.appendChild(row);
            rebuildDropdown(row);
        }

        function updateTotalPrice() {
            let total = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const v = parseFloat(row.querySelector('.harga-input').value);
                if (!isNaN(v)) total += v;
            });
            document.getElementById('total-price').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
            document.getElementById('totali').value = total;
        }

        document.addEventListener('DOMContentLoaded', function () {
            $(document).on('change', '.sepatu-select', function() {
                refreshAllDropdowns();
                updatePrice(this);
            });
            refreshAllDropdowns();
            document.querySelectorAll('.item-row').forEach(row => updatePrice(row.querySelector('.sepatu-select')));
        });
    </script>
@endsection