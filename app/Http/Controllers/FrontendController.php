<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\Item;
use App\Models\Room;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function dashboard()
    {
        $transactionsChart = InventoryTransaction::select(
            DB::raw('DATE(transaction_date) as date'),
            DB::raw('SUM(total_realization) as total')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $recentTransactions = InventoryTransaction::with('type')
            ->latest()
            ->take(5)
            ->get();

        $recentInventories = Inventory::with('item')
            ->latest()
            ->take(5)
            ->get();

        return view('pages.dashboard', [
            'totalInventory' => Inventory::sum('quantity') ?? 0,
            'totalItems' => Item::count(),
            'totalRooms' => Room::count(),
            'totalTransactions' => InventoryTransaction::count(),
            'rusak' => Inventory::where('status', 'rusak')->sum('quantity') ?? 0,
            'expired' => Inventory::where('status', 'expired')->sum('quantity') ?? 0,
            'chartDates' => $transactionsChart->pluck('date'),
            'chartTotals' => $transactionsChart->pluck('total'),
            'hasChartData' => $transactionsChart->count() > 0,
            'recentTransactions' => $recentTransactions,
            'recentInventories' => $recentInventories,
        ]);
    }

    public function reports(Request $request)
    {
        $query = Inventory::with('item');

        if ($request->item_id) {
            $query->where('item_id', $request->item_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $inventories = $query->latest()->paginate(10)->withQueryString();
        $items = Item::orderBy('name')->get();

        return view('pages.reports', compact('inventories', 'items'));
    }

    public function exportPdf(Request $request)
    {
        $query = Inventory::with('item');

        if ($request->item_id) {
            $query->where('item_id', $request->item_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $inventories = $query->latest()->get();

        $pdf = Pdf::loadView('pages.reports-pdf', compact('inventories'));

        return $pdf->download('laporan-inventory.pdf');
    }
}
