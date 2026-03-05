<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan – {{ $invoice->nomor }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        @page { size: A4 portrait; margin: 0; }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #e8e8e8;
        }

        /* ── Tiap halaman full A4 ── */
        .page {
            width: 210mm;
            height: 297mm;
            padding: 12mm 14mm 10mm 14mm;
            background: #fff;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            page-break-after: always;
        }
        .page:last-child { page-break-after: auto; }

        @media screen {
            body { padding: 30px 0; }
            .page {
                box-shadow: 0 4px 24px rgba(0,0,0,.15);
                margin-bottom: 24px;
            }
        }

        /* ════ COLOR THEMES ════ */
        /* Theme 1 – Biru */
        .theme-blue { --accent: #1557b0; --accent2: #2c7be5; --light: #f0f5ff; --border: #c8d9f5; --badge-bg: #e6eeff; --tfoot-bg: #eef2ff; }
        /* Theme 2 – Hijau Teal */
        .theme-green { --accent: #0d7a5f; --accent2: #18a97f; --light: #f0faf6; --border: #b6e0d2; --badge-bg: #d6f3ea; --tfoot-bg: #e8f8f2; }

        /* ── Header ── */
        .sj-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid var(--accent);
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .sj-brand h1 {
            font-size: 22px;
            font-weight: 900;
            color: var(--accent);
            letter-spacing: 1px;
            text-transform: uppercase;
            line-height: 1.1;
        }
        .sj-brand p { font-size: 9px; color: #666; margin-top: 2px; }
        .sj-doc-info { text-align: right; }
        .sj-doc-info .lbl {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #999;
        }
        .sj-doc-info .doc-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--accent);
            line-height: 1.1;
        }
        .sj-doc-info .doc-num {
            font-size: 11px;
            font-weight: 700;
            color: #333;
            margin-top: 2px;
        }

        /* ── Meta boxes ── */
        .sj-meta {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
        }
        .sj-meta-block {
            flex: 1;
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 7px 10px;
        }
        .sj-meta-block .title {
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--accent);
            font-weight: 700;
            margin-bottom: 3px;
        }
        .sj-meta-block .value { font-size: 11px; font-weight: 700; color: #1a1a1a; }
        .sj-meta-block .sub   { font-size: 9px; color: #666; margin-top: 1px; }

        /* ── Table ── */
        .sj-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .sj-table thead tr {
            background: var(--accent);
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .sj-table thead th {
            color: #fff;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: .05em;
            padding: 7px 8px;
            text-align: center;
            font-weight: 700;
        }
        .sj-table thead th:nth-child(2) { text-align: left; }
        .sj-table tbody tr { border-bottom: 1px solid #e8eef8; }
        .sj-table tbody tr:nth-child(even) { background: var(--light); }
        .sj-table tbody td {
            padding: 6px 8px;
            font-size: 10px;
            color: #333;
            text-align: center;
            vertical-align: middle;
        }
        .sj-table tbody td:nth-child(2) { text-align: left; font-weight: 600; }
        .kode-badge {
            display: inline-block;
            background: var(--badge-bg);
            color: var(--accent);
            border-radius: 4px;
            padding: 2px 7px;
            font-size: 9.5px;
            font-weight: 700;
        }
        .sj-table tfoot td {
            padding: 6px 8px;
            font-weight: 700;
            font-size: 10px;
            color: var(--accent);
            background: var(--tfoot-bg);
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ── Total + Notes row ── */
        .bottom-row {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            align-items: stretch;
        }
        .sj-total-bar {
            flex: 1;
            background: #fff;
            border: 2px solid var(--accent);
            border-radius: 8px;
            padding: 10px 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .sj-total-bar .t-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #555;
        }
        .sj-total-bar .t-amount {
            font-size: 16px;
            font-weight: 800;
            color: var(--accent);
        }
        .sj-notes {
            flex: 1;
            background: #fffbf0;
            border-left: 4px solid #f59e0b;
            border-radius: 0 6px 6px 0;
            padding: 8px 12px;
        }
        .sj-notes .notes-title {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #b45309;
            margin-bottom: 4px;
        }
        .sj-notes p { font-size: 9px; color: #666; line-height: 1.6; }

        /* ── Signatures ── */
        .sj-signatures {
            display: flex;
            justify-content: space-around;
            margin-top: 6px;
        }
        .sj-sig-box { text-align: center; width: 36%; }
        .sj-sig-box .sig-title {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--accent);
            font-weight: 700;
            margin-bottom: 4px;
        }
        .sj-sig-box .sig-line {
            border-bottom: 1.5px solid var(--accent);
            height: 50px;
            margin-bottom: 4px;
        }
        .sj-sig-box .sig-name { font-size: 9px; color: #666; font-style: italic; }

        /* ── Page footer ── */
        .sj-page-footer {
            position: absolute;
            bottom: 8mm;
            left: 14mm;
            right: 14mm;
            border-top: 1px solid var(--border);
            padding-top: 5px;
            display: flex;
            justify-content: space-between;
            font-size: 8px;
            color: #bbb;
        }

        /* ── Print action bar (screen only) ── */
        .print-bar {
            background: #1a1a2e;
            color: #fff;
            padding: 10px;
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            z-index: 999;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
        }
        .print-bar button, .print-bar a {
            background: #fff;
            color: #1a1a2e;
            border: none;
            border-radius: 6px;
            padding: 6px 20px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .print-bar span { font-weight: 700; font-size: 13px; opacity: .85; }

        @media print {
            .print-bar { display: none !important; }
            body { background: #fff; padding: 0; }
            .page { box-shadow: none; margin: 0; }
        }
    </style>
</head>
<body>

<div class="print-bar">
    <span>Surat Jalan &nbsp;|&nbsp; {{ $invoice->nomor }}</span>
    <button onclick="window.print()">🖨️ Cetak / Print</button>
    <a href="{{ route('invoiceIn.index') }}">← Kembali</a>
</div>

@php $grandQty = $invoice->items->sum('jumlah'); @endphp

@foreach (['theme-blue', 'theme-green'] as $theme)
<div class="page {{ $theme }}">

    {{-- Header --}}
    <div class="sj-header">
        <div class="sj-brand">
            <h1>Yasoge</h1>
            <p>Distributor Sepatu &amp; Sandal &nbsp;|&nbsp; Jl. Contoh No. 1, Jakarta, Indonesia</p>
        </div>
        <div class="sj-doc-info">
            <div class="lbl">Dokumen</div>
            <div class="doc-title">Surat Jalan</div>
            <div class="lbl" style="margin-top:4px;">No. Invoice</div>
            <div class="doc-num"># {{ $invoice->nomor }}</div>
        </div>
    </div>

    {{-- Meta --}}
    <div class="sj-meta">
        <div class="sj-meta-block">
            <div class="title">Tanggal Pengiriman</div>
            <div class="value">{{ \Carbon\Carbon::parse($invoice->tgl)->format('d/m/Y') }}</div>
            <div class="sub">{{ \Carbon\Carbon::parse($invoice->tgl)->translatedFormat('l') }}</div>
        </div>
        <div class="sj-meta-block">
            <div class="title">Jumlah Item</div>
            <div class="value">{{ $invoice->items->count() }} Jenis Sepatu</div>
            <div class="sub">Total {{ $grandQty }} pasang</div>
        </div>
        <div class="sj-meta-block">
            <div class="title">Dicetak</div>
            <div class="value">{{ now()->format('d/m/Y') }}</div>
            <div class="sub">{{ now()->format('H:i') }} WIB</div>
        </div>
    </div>

    {{-- Table --}}
    <table class="sj-table">
        <thead>
            <tr>
                <th style="width:30px;">No</th>
                <th>Kode Sepatu</th>
                <th>Jumlah (Pasang)</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $i => $item)
                @php $subtotal = $item->jumlah * $item->harga; @endphp
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
            <tr>
                <td colspan="2" style="text-align:right;">Total</td>
                <td style="text-align:center;">{{ number_format($grandQty) }}</td>
                <td></td>
                <td style="text-align:center;">Rp {{ number_format($invoice->total) }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- Total + Notes --}}
    <div class="bottom-row">
        <div class="sj-total-bar">
            <div class="t-label">Total Pembayaran</div>
            <div class="t-amount">Rp {{ number_format($invoice->total) }}</div>
        </div>
        <div class="sj-notes">
            <div class="notes-title">Keterangan</div>
            <p>Barang telah diterima dalam kondisi baik dan sesuai daftar di atas.<br>
            Periksa barang sebelum menandatangani surat jalan ini.</p>
        </div>
    </div>

    {{-- Signatures --}}
    <div class="sj-signatures">
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

    {{-- Page footer --}}
    <div class="sj-page-footer">
        <span>Surat Jalan dicetak dari sistem Yasoge</span>
        <span>Invoice #{{ $invoice->nomor }} &nbsp;|&nbsp; {{ \Carbon\Carbon::parse($invoice->tgl)->format('d/m/Y') }}</span>
    </div>

</div>
@endforeach

<script>
    window.addEventListener('beforeprint', function () { document.body.style.padding = '0'; });
    window.addEventListener('afterprint',  function () { document.body.style.padding = ''; });
</script>
</body>
</html>