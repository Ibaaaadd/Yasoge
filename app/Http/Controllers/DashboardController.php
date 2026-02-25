<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvoiceIn;
use App\Models\InvoiceOut;
use App\Models\Sepatu;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $sepatu = Sepatu::all();
        $invoiceIn = InvoiceIn::all()->count();
        $invoiceOut = InvoiceOut::all()->count();

        $currentYear = (int) date('Y');
        $yearsIn  = InvoiceIn::selectRaw('EXTRACT(YEAR FROM tgl)::int as year')->whereNotNull('tgl')->distinct()->pluck('year');
        $yearsOut = InvoiceOut::selectRaw('EXTRACT(YEAR FROM tgl)::int as year')->whereNotNull('tgl')->distinct()->pluck('year');
        $years = $yearsIn->merge($yearsOut)->unique()->sortDesc()->values();
        if ($years->isEmpty()) {
            $years = collect([$currentYear]);
        }

        $defaultYear = $years->first() ?? $currentYear;
        $selectedYear = (int) $request->get('year', $defaultYear);

        $invoiceInYear  = InvoiceIn::whereRaw('EXTRACT(YEAR FROM tgl) = ?', [$selectedYear])->count();
        $invoiceOutYear = InvoiceOut::whereRaw('EXTRACT(YEAR FROM tgl) = ?', [$selectedYear])->count();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $invoiceInMonthly  = array_fill(0, 12, 0);
        $invoiceOutMonthly = array_fill(0, 12, 0);

        $inData = InvoiceIn::selectRaw('EXTRACT(MONTH FROM tgl)::int as month, COALESCE(SUM(total), 0) as total')
            ->whereRaw('EXTRACT(YEAR FROM tgl) = ?', [$selectedYear])
            ->groupBy('month')
            ->get();

        $outData = InvoiceOut::selectRaw('EXTRACT(MONTH FROM tgl)::int as month, COALESCE(SUM(total), 0) as total')
            ->whereRaw('EXTRACT(YEAR FROM tgl) = ?', [$selectedYear])
            ->groupBy('month')
            ->get();

        foreach ($inData as $row) {
            $invoiceInMonthly[$row->month - 1] = (float) $row->total;
        }
        foreach ($outData as $row) {
            $invoiceOutMonthly[$row->month - 1] = (float) $row->total;
        }

        return view('dashboard', compact(
            'invoiceIn', 'invoiceOut', 'sepatu',
            'months', 'invoiceInMonthly', 'invoiceOutMonthly',
            'years', 'selectedYear',
            'invoiceInYear', 'invoiceOutYear'
        ));
    }
}
