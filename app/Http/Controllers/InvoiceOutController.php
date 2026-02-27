<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\InvoiceOut;
use App\Models\InvoiceOutItem;
use App\Models\InvoiceInItem;
use App\Models\Sepatu;
use Illuminate\Support\Facades\DB;

class InvoiceOutController extends Controller
{
    /** Hitung stok tersedia per sepatu_id */
    private function getStockMap()
    {
        $stockIn  = InvoiceInItem::select('sepatu_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('sepatu_id')->pluck('total', 'sepatu_id');
        $stockOut = InvoiceOutItem::select('sepatu_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('sepatu_id')->pluck('total', 'sepatu_id');
        $map = [];
        foreach (Sepatu::pluck('id') as $id) {
            $map[$id] = ($stockIn[$id] ?? 0) - ($stockOut[$id] ?? 0);
        }
        return $map;
    }

    public function index()
    {
        $invoiceOut = InvoiceOut::with('items.sepatu')->get();
        return view('invoiceOut.index', compact('invoiceOut'));
    }

    public function create()
    {
        $sepatuItems = Sepatu::all();
        $stockMap    = $this->getStockMap();
        $sepatuItems = $sepatuItems->map(function ($s) use ($stockMap) {
            $s->current_stock = $stockMap[$s->id] ?? 0;
            return $s;
        });
        return view('invoiceOut.create', compact('sepatuItems'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor'               => 'required',
            'tgl'                 => 'required|date',
            'total'               => 'required',
            'items'               => 'required|array|min:1',
            'items.*.sepatu_id'   => 'required|exists:sepatu,id',
            'items.*.jumlah'      => 'required|integer|min:1',
            'items.*.harga'       => 'required|numeric|min:0',
        ]);

        // Periksa apakah nomor invoice sudah ada
        if (InvoiceOut::where('nomor', $validatedData['nomor'])->exists()) {
            return redirect()->back()->withErrors(['nomor' => 'Nomor invoice sudah ada.'])->withInput();
        }

        // Validasi stok untuk setiap item
        $stockMap = $this->getStockMap();
        foreach ($validatedData['items'] as $item) {
            $available = $stockMap[$item['sepatu_id']] ?? 0;
            if ($available <= 0) {
                $sepatu = Sepatu::find($item['sepatu_id']);
                return redirect()->back()
                    ->withErrors(['items' => "Stok '{$sepatu->kode}' kosong, tidak bisa membuat invoice keluar."])
                    ->withInput();
            }
            if ($item['jumlah'] > $available) {
                $sepatu = Sepatu::find($item['sepatu_id']);
                return redirect()->back()
                    ->withErrors(['items' => "Stok '{$sepatu->kode}' tidak mencukupi. Stok tersedia: {$available}, diminta: {$item['jumlah']}."])
                    ->withInput();
            }
        }

        $invoiceOut = InvoiceOut::create([
            'nomor' => $validatedData['nomor'],
            'tgl'   => $validatedData['tgl'],
            'total' => $validatedData['total'],
        ]);

        foreach ($validatedData['items'] as $item) {
            InvoiceOutItem::create([
                'invoice_out_id' => $invoiceOut->id,
                'sepatu_id'      => $item['sepatu_id'],
                'jumlah'         => $item['jumlah'],
                'harga'          => $item['harga'],
            ]);
        }

        return redirect()->route('invoiceOut.index')->with('success', 'Invoice berhasil disimpan.');
    }

    public function edit($id)
    {
        $invoiceOut = InvoiceOut::findOrFail($id);
        $sepatuItems = Sepatu::all();

        $stockIn  = InvoiceInItem::select('sepatu_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('sepatu_id')->pluck('total', 'sepatu_id');
        $stockOut = InvoiceOutItem::select('sepatu_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('sepatu_id')->pluck('total', 'sepatu_id');

        // Stok lama di invoice ini dikembalikan ke pool (karena akan diganti)
        $oldQtys = InvoiceOutItem::where('invoice_out_id', $id)
            ->select('sepatu_id', DB::raw('SUM(jumlah) as old_qty'))
            ->groupBy('sepatu_id')->pluck('old_qty', 'sepatu_id');

        $sepatuItems = $sepatuItems->map(function ($s) use ($stockIn, $stockOut, $oldQtys) {
            $in  = $stockIn[$s->id]  ?? 0;
            $out = $stockOut[$s->id] ?? 0;
            $old = $oldQtys[$s->id]  ?? 0;
            $s->current_stock = $in - $out + $old;
            return $s;
        });

        return view('invoiceOut.edit', compact('invoiceOut', 'sepatuItems'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nomor'               => 'required',
            'tgl'                 => 'required|date',
            'total'               => 'required',
            'items'               => 'required|array|min:1',
            'items.*.sepatu_id'   => 'required|exists:sepatu,id',
            'items.*.jumlah'      => 'required|integer|min:1',
            'items.*.harga'       => 'required|numeric|min:0',
        ]);

        $invoiceOut = InvoiceOut::findOrFail($id);

        // Hitung stok bersih dengan mengembalikan item lama
        $stockIn  = InvoiceInItem::select('sepatu_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('sepatu_id')->pluck('total', 'sepatu_id');
        $stockOut = InvoiceOutItem::select('sepatu_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('sepatu_id')->pluck('total', 'sepatu_id');
        $oldQtys  = InvoiceOutItem::where('invoice_out_id', $id)
            ->select('sepatu_id', DB::raw('SUM(jumlah) as old_qty'))
            ->groupBy('sepatu_id')->pluck('old_qty', 'sepatu_id');

        foreach ($validatedData['items'] as $item) {
            $in        = $stockIn[$item['sepatu_id']]  ?? 0;
            $out       = $stockOut[$item['sepatu_id']] ?? 0;
            $old       = $oldQtys[$item['sepatu_id']]  ?? 0;
            $available = $in - $out + $old;

            if ($available <= 0 && $old == 0) {
                $sepatu = Sepatu::find($item['sepatu_id']);
                return redirect()->back()
                    ->withErrors(['items' => "Stok '{$sepatu->kode}' kosong."])
                    ->withInput();
            }
            if ($item['jumlah'] > $available) {
                $sepatu = Sepatu::find($item['sepatu_id']);
                return redirect()->back()
                    ->withErrors(['items' => "Stok '{$sepatu->kode}' tidak mencukupi. Stok tersedia: {$available}, diminta: {$item['jumlah']}."])
                    ->withInput();
            }
        }

        $invoiceOut->update([
            'nomor' => $validatedData['nomor'],
            'tgl'   => $validatedData['tgl'],
            'total' => $validatedData['total'],
        ]);

        InvoiceOutItem::where('invoice_out_id', $invoiceOut->id)->delete();

        foreach ($validatedData['items'] as $item) {
            InvoiceOutItem::create([
                'invoice_out_id' => $invoiceOut->id,
                'sepatu_id'      => $item['sepatu_id'],
                'jumlah'         => $item['jumlah'],
                'harga'          => $item['harga'],
            ]);
        }

        return redirect()->route('invoiceOut.index')->with('success', 'Invoice berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $invoiceOut = InvoiceOut::findOrFail($id);
        $invoiceOut->items()->delete();
        $invoiceOut->delete();
        return redirect()->route('invoiceOut.index')->with('success', 'Invoice berhasil dihapus.');
    }
}
