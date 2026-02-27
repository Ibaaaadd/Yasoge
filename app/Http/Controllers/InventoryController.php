<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sepatu;
use App\Models\InvoiceInItem;
use App\Models\InvoiceOutItem;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $sepatus = Sepatu::all();

        $stockIn = InvoiceInItem::select('sepatu_id', DB::raw('SUM(jumlah) as total_in'))
            ->groupBy('sepatu_id')
            ->pluck('total_in', 'sepatu_id');

        $stockOut = InvoiceOutItem::select('sepatu_id', DB::raw('SUM(jumlah) as total_out'))
            ->groupBy('sepatu_id')
            ->pluck('total_out', 'sepatu_id');

        $inventory = $sepatus->map(function ($sepatu) use ($stockIn, $stockOut) {
            $in  = $stockIn[$sepatu->id]  ?? 0;
            $out = $stockOut[$sepatu->id] ?? 0;
            return (object)[
                'id'            => $sepatu->id,
                'kode'          => $sepatu->kode,
                'harga'         => $sepatu->harga,
                'gambar'        => $sepatu->gambar,
                'stock_in'      => $in,
                'stock_out'     => $out,
                'current_stock' => $in - $out,
            ];
        });

        return view('inventory.index', compact('inventory'));
    }
}
