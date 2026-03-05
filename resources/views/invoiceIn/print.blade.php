<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan – {{ $invoice->nomor }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            background: #fff;
        }

        /* ── Page wrapper ── */
        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 14mm 16mm 14mm 16mm;
            position: relative;
        }

        /* ── Header ── */
        .sj-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #1557b0;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .sj-brand h1 {
            font-size: 24px;
            font-weight: 900;
            color: #1557b0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .sj-brand p {
            font-size: 10.5px;
            color: #555;
            margin-top: 3px;
        }
        .sj-doc-info {
            text-align: right;
        }
        .sj-doc-info .label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #888;
        }
        .sj-doc-info .doc-title {
            font-size: 18px;
            font-weight: 800;
            color: #1557b0;
            line-height: 1.1;
        }
        .sj-doc-info .doc-num {
            font-size: 12px;
            font-weight: 700;
            color: #333;
            margin-top: 3px;
        }

        /* ── Meta box ── */
        .sj-meta {
            display: flex;
            gap: 16px;
            margin-bottom: 18px;
        }
        .sj-meta-block {
            flex: 1;
            background: #f0f5ff;
            border: 1px solid #c8d9f5;
            border-radius: 6px;
            padding: 10px 14px;
        }
        .sj-meta-block .title {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #1557b0;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .sj-meta-block .value {
            font-size: 12.5px;
            font-weight: 600;
            color: #1a1a1a;
        }
        .sj-meta-block .sub {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
        }

        /* ── Table ── */
        .sj-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        .sj-table thead tr {
            background: #1557b0;
        }
        .sj-table thead th {
            color: #fff;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .06em;
            padding: 8px 10px;
            text-align: center;
            font-weight: 700;
        }
        .sj-table thead th:first-child { text-align: center; width: 40px; }
        .sj-table thead th:nth-child(2) { text-align: left; }
        .sj-table tbody tr { border-bottom: 1px solid #e8eef8; }
        .sj-table tbody tr:nth-child(even) { background: #f7f9ff; }
        .sj-table tbody td {
            padding: 8px 10px;
            font-size: 11.5px;
            color: #333;
            text-align: center;
            vertical-align: middle;
        }
        .sj-table tbody td:nth-child(2) { text-align: left; font-weight: 600; }
        .sj-table tbody td .kode-badge {
            display: inline-block;
            background: #e6eeff;
            color: #1557b0;
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 700;
        }

        /* ── Total bar ── */
        .sj-total-bar {
            background: linear-gradient(135deg, #1557b0, #2c7be5);
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color: #fff;
            border-radius: 8px;
            padding: 12px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }
        .sj-total-bar .t-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .1em;
            opacity: .85;
        }
        .sj-total-bar .t-amount {
            font-size: 18px;
            font-weight: 800;
        }

        @media print {
            .sj-total-bar {
                background: #fff !important;
                border: 2px solid #1557b0 !important;
                color: #1557b0 !important;
            }
            .sj-total-bar .t-label { color: #555 !important; opacity: 1; }
            .sj-total-bar .t-amount { color: #1557b0 !important; }
        }

        /* ── Notes ── */
        .sj-notes {
            background: #fffbf0;
            border-left: 4px solid #f59e0b;
            border-radius: 0 6px 6px 0;
            padding: 10px 14px;
            margin-bottom: 22px;
        }
        .sj-notes .notes-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #b45309;
            margin-bottom: 4px;
        }
        .sj-notes p { font-size: 11px; color: #555; line-height: 1.5; }

        /* ── Signature section ── */
        .sj-signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .sj-sig-box {
            text-align: center;
            width: 28%;
        }
        .sj-sig-box .sig-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #555;
            margin-bottom: 4px;
        }
        .sj-sig-box .sig-line {
            border-bottom: 1.5px solid #1557b0;
            height: 55px;
            margin-bottom: 4px;
        }
        .sj-sig-box .sig-name {
            font-size: 10.5px;
            color: #333;
            font-style: italic;
        }

        /* ── Footer ── */
        .sj-footer {
            position: absolute;
            bottom: 12mm;
            left: 16mm;
            right: 16mm;
            border-top: 1px solid #d0daf0;
            padding-top: 7px;
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #999;
        }

        /* ── Print action bar (screen only) ── */
        .print-bar {
            background: #1557b0;
            color: #fff;
            text-align: center;
            padding: 12px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999;
            display: flex;
            justify-content: center;
            gap: 14px;
        }
        .print-bar button, .print-bar a {
            background: #fff;
            color: #1557b0;
            border: none;
            border-radius: 6px;
            padding: 7px 22px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .print-bar span { font-size: 14px; font-weight: 700; opacity: .9; align-self: center; }

        @media print {
            .print-bar { display: none !important; }
            body { padding: 0; }
            .page { padding: 10mm 14mm; }
            .sj-footer { position: fixed; bottom: 6mm; }
        }
    </style>
</head>
<body>

{{-- ── Action Bar (screen only) ── --}}
<div class="print-bar" id="printBar">
    <span>Surat Jalan &nbsp;|&nbsp; {{ $invoice->nomor }}</span>
    <button onclick="window.print()">
        🖨️ Cetak / Print
    </button>
    <a href="{{ route('invoiceIn.index') }}">
        ← Kembali
    </a>
</div>

<div class="page" style="margin-top: 55px;">

    {{-- ── Header ── --}}
    <div class="sj-header">
        <div class="sj-brand">
            <h1>Yasoge</h1>
            <p>Distributor Sepatu &amp; Sandal</p>
            <p style="margin-top:2px; color:#888;">Jl. Contoh No. 1, Jakarta, Indonesia</p>
        </div>
        <div class="sj-doc-info">
            <div class="label">Dokumen</div>
            <div class="doc-title">Surat Jalan</div>
            <div class="label" style="margin-top:6px;">No. Invoice</div>
            <div class="doc-num"># {{ $invoice->nomor }}</div>
        </div>
    </div>

    {{-- ── Meta Info ── --}}
    <div class="sj-meta">
        <div class="sj-meta-block">
            <div class="title">Tanggal Pengiriman</div>
            <div class="value">{{ \Carbon\Carbon::parse($invoice->tgl)->translatedFormat('d F Y') }}</div>
            <div class="sub">{{ \Carbon\Carbon::parse($invoice->tgl)->translatedFormat('l') }}</div>
        </div>
        <div class="sj-meta-block">
            <div class="title">Jumlah Item</div>
            <div class="value">{{ $invoice->items->count() }} Jenis Sepatu</div>
            <div class="sub">Total {{ $invoice->items->sum('jumlah') }} pasang</div>
        </div>
        <div class="sj-meta-block">
            <div class="title">Dicetak</div>
            <div class="value">{{ now()->format('d/m/Y') }}</div>
            <div class="sub">{{ now()->format('H:i') }} WIB</div>
        </div>
    </div>

    {{-- ── Items Table ── --}}
    <table class="sj-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Sepatu</th>
                <th>Jumlah (Pasang)</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $grandQty = 0; @endphp
            @foreach ($invoice->items as $i => $item)
                @php
                    $grandQty += $item->jumlah;
                    $subtotal = $item->jumlah * $item->harga;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><span class="kode-badge">{{ $item->sepatu->kode ?? '-' }}</span></td>
                    <td>{{ number_format($item->jumlah) }}</td>
                    <td>Rp {{ number_format($item->harga) }}</td>
                    <td>Rp {{ number_format($subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background:#eef2ff; font-weight:700;">
                <td colspan="2" style="text-align:right; padding: 8px 10px; font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#1557b0;">Total</td>
                <td style="text-align:center; padding:8px 10px;">{{ number_format($grandQty) }}</td>
                <td></td>
                <td style="text-align:center; padding:8px 10px;">Rp {{ number_format($invoice->total) }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- ── Total Bar ── --}}
    <div class="sj-total-bar">
        <div>
            <div class="t-label">Total Pembayaran</div>
        </div>
        <div class="t-amount">Rp {{ number_format($invoice->total) }}</div>
    </div>

    {{-- ── Notes ── --}}
    <div class="sj-notes">
        <div class="notes-title">Keterangan</div>
        <p>Barang yang telah diterima dalam kondisi baik dan sesuai dengan daftar di atas.<br>
        Harap periksa barang sebelum menandatangani surat jalan ini.</p>
    </div>

    {{-- ── Signature Section ── --}}
    <div class="sj-signatures" style="justify-content: space-around;">
        <div class="sj-sig-box">
            <div class="sig-title">Pengirim</div>
            <div class="sig-line"></div>
            <div class="sig-name">( ______________________ )</div>
        </div>
        <div class="sj-sig-box">
            <div class="sig-title">Penerima</div>
            <div class="sig-line"></div>
            <div class="sig-name">( ______________________ )</div>
        </div>
    </div>

</div>

{{-- ── Page Footer ── --}}
<div class="sj-footer" style="@media print { position: fixed; }">
    <span>Surat Jalan dicetak dari sistem Yasoge</span>
    <span>Invoice #{{ $invoice->nomor }} &nbsp;|&nbsp; {{ \Carbon\Carbon::parse($invoice->tgl)->format('d/m/Y') }}</span>
</div>

<script>
    // Auto adjust margin when print bar is shown/hidden
    window.addEventListener('beforeprint', function () {
        document.querySelector('.page').style.marginTop = '0';
    });
    window.addEventListener('afterprint', function () {
        document.querySelector('.page').style.marginTop = '55px';
    });
</script>
</body>
</html>
