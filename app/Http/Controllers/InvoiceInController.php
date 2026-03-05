<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\InvoiceIn;
use App\Models\InvoiceInItem;
use App\Models\InvoiceOutItem;
use App\Models\Sepatu;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;

class InvoiceInController extends Controller
{
    public function index(Request $request)
    {
        $query = InvoiceIn::with('items.sepatu');

        $dateFrom = $request->input('date_from');
        $dateTo   = $request->input('date_to');

        if ($dateFrom) {
            $query->whereDate('tgl', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('tgl', '<=', $dateTo);
        }

        $invoiceIn = $query->orderBy('tgl', 'desc')->get();

        return view('invoiceIn.index', compact('invoiceIn', 'dateFrom', 'dateTo'));
    }

    public function export(Request $request)
    {
        $query = InvoiceIn::with('items.sepatu');

        $dateFrom = $request->input('date_from');
        $dateTo   = $request->input('date_to');

        if ($dateFrom) {
            $query->whereDate('tgl', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('tgl', '<=', $dateTo);
        }

        $invoices = $query->orderBy('tgl', 'desc')->get();

        // ── Build spreadsheet ──────────────────────────────────────────────
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Invoice Masuk');

        // ── Title row ──
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'Laporan Invoice Masuk - Yasoge');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF1557B0']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(22);

        // Period sub-title
        $period = ($dateFrom ? Carbon::parse($dateFrom)->format('d/m/Y') : 'Awal')
                . ' s/d '
                . ($dateTo   ? Carbon::parse($dateTo)->format('d/m/Y')   : 'Sekarang');
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', 'Periode: ' . $period);
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF555555']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // ── Header row (row 4) ──
        $headers = ['No', 'ID Invoice', 'Tanggal', 'Kode Sepatu', 'Jumlah (Pasang)', 'Harga Satuan (Rp)', 'Subtotal (Rp)'];
        foreach ($headers as $col => $label) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . '4';
            $sheet->setCellValue($cell, $label);
        }
        $sheet->getStyle('A4:G4')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1557B0']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFCCCCCC']]],
        ]);
        $sheet->getRowDimension(4)->setRowHeight(18);

        // ── Data rows ──
        $row = 5;
        $no  = 1;
        foreach ($invoices as $inv) {
            $firstRow = $row;
            $isFirst  = true;
            foreach ($inv->items as $item) {
                $sheet->setCellValue('A' . $row, $isFirst ? $no : '');
                $sheet->setCellValue('B' . $row, $isFirst ? $inv->nomor : '');
                $sheet->setCellValue('C' . $row, $isFirst ? Carbon::parse($inv->tgl)->format('d/m/Y') : '');
                $sheet->setCellValue('D' . $row, $item->sepatu->kode ?? '-');
                $sheet->setCellValue('E' . $row, $item->jumlah);
                $sheet->setCellValue('F' . $row, $item->harga);
                $sheet->setCellValue('G' . $row, $item->jumlah * $item->harga);

                $bgColor = ($no % 2 === 0) ? 'FFF0F5FF' : 'FFFFFFFF';
                $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                    'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bgColor]],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFD0D8EE']]],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getStyle("E{$row}:G{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $isFirst = false;
                $row++;
            }

            // Subtotal row per invoice
            $sheet->setCellValue('F' . $row, 'Total ' . $inv->nomor);
            $sheet->setCellValue('G' . $row, $inv->total);
            $sheet->getStyle("F{$row}:G{$row}")->applyFromArray([
                'font'      => ['bold' => true, 'color' => ['argb' => 'FF1557B0']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE6EEFF']],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFD0D8EE']]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ]);
            $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE6EEFF']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFD0D8EE']]],
            ]);
            $row++;
            $no++;
        }

        // Grand total
        $sheet->setCellValue('F' . $row, 'GRAND TOTAL');
        $sheet->setCellValue('G' . $row, $invoices->sum('total'));
        $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
            'font'      => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1557B0']],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF1557B0']]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        ]);

        // ── Column widths ──
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getColumnDimension('D')->setWidth(22);
        $sheet->getColumnDimension('E')->setWidth(16);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(22);

        // Number format for currency columns
        $sheet->getStyle('F5:G' . $row)->getNumberFormat()->setFormatCode('#,##0');

        // ── Stream response ──
        $filename = 'invoice-masuk-' . now()->format('Ymd-His') . '.xlsx';
        $writer   = new Xlsx($spreadsheet);

        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control'       => 'max-age=0',
        ]);
    }

    public function printSuratJalan($id)
    {
        $invoice = InvoiceIn::with('items.sepatu')->findOrFail($id);
        return view('invoiceIn.print', compact('invoice'));
    }

    private function getStockMap(): array
    {
        $stockIn  = InvoiceInItem::select('sepatu_id', DB::raw('SUM(jumlah) as total'))->groupBy('sepatu_id')->pluck('total', 'sepatu_id');
        $stockOut = InvoiceOutItem::select('sepatu_id', DB::raw('SUM(jumlah) as total'))->groupBy('sepatu_id')->pluck('total', 'sepatu_id');
        $map = [];
        foreach (Sepatu::pluck('id') as $id) {
            $map[$id] = ($stockIn[$id] ?? 0) - ($stockOut[$id] ?? 0);
        }
        return $map;
    }

    public function create()
    {
        $stockMap    = $this->getStockMap();
        $sepatuItems = Sepatu::all()->map(function ($s) use ($stockMap) {
            $s->current_stock = $stockMap[$s->id] ?? 0;
            return $s;
        });

        $dateStr      = now()->format('dmy');
        $prefix       = 'YSG-IN-' . $dateStr . '-';
        $count        = InvoiceIn::where('nomor', 'like', $prefix . '%')->count();
        $defaultNomor = $prefix . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        $defaultTgl   = now()->format('Y-m-d');

        return view('invoiceIn.create', compact('sepatuItems', 'defaultNomor', 'defaultTgl'));
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirimkan melalui request
        $validatedData = $request->validate([
            'nomor' => 'required',
            'tgl' => 'required|date',
            'total' => 'required',
            'items' => 'required|array|min:1',
            'items.*.sepatu_id' => 'required|exists:sepatu,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
        ]);

        $invoiceIn = InvoiceIn::create([
            'nomor' => $validatedData['nomor'],
            'tgl' => $validatedData['tgl'],
            'total' => $validatedData['total']
        ]);

        foreach ($validatedData['items'] as $item) {
            InvoiceInItem::create([
                'invoice_in_id' => $invoiceIn->id,
                'sepatu_id' => $item['sepatu_id'],
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'],
            ]);
        }

        // Redirect ke halaman index invoice dengan pesan sukses
        return redirect()->route('invoiceIn.index')->with('success', 'Invoice berhasil disimpan.');
    }

    public function edit($id)
    {
        $invoiceIn   = InvoiceIn::findOrFail($id);
        $stockMap    = $this->getStockMap();
        $sepatuItems = Sepatu::all()->map(function ($s) use ($stockMap) {
            $s->current_stock = $stockMap[$s->id] ?? 0;
            return $s;
        });
        return view('invoiceIn.edit', compact('invoiceIn', 'sepatuItems'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang dikirimkan melalui request
        $validatedData = $request->validate([
            'nomor' => 'required',
            'tgl' => 'required|date',
            'total' => 'required',
            'items' => 'required|array|min:1',
            'items.*.sepatu_id' => 'required|exists:sepatu,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
        ]);

        // Temukan invoice berdasarkan ID
        $invoiceIn = InvoiceIn::findOrFail($id);

        // Update data invoice
        $invoiceIn->update([
            'nomor' => $validatedData['nomor'],
            'tgl' => $validatedData['tgl'],
            'total' => $validatedData['total']
        ]);

        // Hapus item lama
        InvoiceInItem::where('invoice_in_id', $invoiceIn->id)->delete();

        // Tambahkan item baru dari request
        foreach ($validatedData['items'] as $item) {
            InvoiceInItem::create([
                'invoice_in_id' => $invoiceIn->id,
                'sepatu_id' => $item['sepatu_id'],
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'],
            ]);
        }

        // Redirect ke halaman index invoice dengan pesan sukses
        return redirect()->route('invoiceIn.index')->with('success', 'Invoice berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $invoiceIn = InvoiceIn::findOrFail($id);
        $invoiceIn->items()->delete(); // Menghapus semua item yang terkait dengan invoice
        $invoiceIn->delete(); // Menghapus invoice itu sendiri
        return redirect()->route('invoiceIn.index')->with('success', 'Invoice berhasil dihapus.');
    }
}
