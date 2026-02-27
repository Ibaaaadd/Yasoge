<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\InvoiceIn;
use App\Models\InvoiceInItem;
use App\Models\InvoiceOutItem;
use App\Models\Sepatu;
use Illuminate\Support\Facades\DB;

class InvoiceInController extends Controller
{
    public function index()
    {
        $invoiceIn = InvoiceIn::with('items.sepatu')->get(); // Mendapatkan semua invoice_in beserta relasi sepatu
        return view('invoiceIn.index', compact('invoiceIn'));
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
        return view('invoiceIn.create', compact('sepatuItems'));
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
