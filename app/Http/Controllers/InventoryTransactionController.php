<?php

namespace App\Http\Controllers;

use App\Models\InventoryTransaction;
use App\Models\InventoryTransactionDetail;
use App\Models\Item;
use App\Models\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InventoryTransactionController extends Controller
{
    public function index()
    {
        $transactions = InventoryTransaction::with('type')->latest()->paginate(10);
        return view('pages.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $items = Item::all();
        $types = TransactionType::all();

        $code = 'TRX-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

        return view('pages.transactions.create', compact('items', 'types', 'code'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $evidencePath = null;

            if ($request->hasFile('evidence_file')) {
                $evidencePath = $request->file('evidence_file')->store('transaction-evidence', 'public');
            }

            $trx = InventoryTransaction::create([
                'transaction_type_id' => $request->transaction_type_id,
                'transaction_code' => $request->transaction_code,
                'transaction_date' => $request->transaction_date,
                'total_budget' => $request->total_budget ?? 0,
                'total_realization' => 0,
                'evidence_file' => $evidencePath,
                'description' => $request->description,
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $subtotal = $item['qty'] * $item['price'];

                InventoryTransactionDetail::create([
                    'inventory_transaction_id' => $trx->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);

                $inventory = \App\Models\Inventory::where('item_id', $item['item_id'])->first();

                if (!$inventory) {
                    $inventory = \App\Models\Inventory::create([
                        'item_id' => $item['item_id'],
                        'quantity' => 0,
                        'price' => $item['price'],
                        'barcode' => 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5)),
                        'status' => 'baik',
                    ]);
                }

                $transactionType = \App\Models\TransactionType::find($request->transaction_type_id);

                if (strtolower($transactionType->name) == 'pembelian') {
                    $inventory->quantity += $item['qty'];
                }

                if (strtolower($transactionType->name) == 'penghapusan') {
                    $inventory->quantity -= $item['qty'];

                    if ($inventory->quantity < 0) {
                        throw new \Exception('Stok tidak cukup untuk penghapusan.');
                    }
                }

                $inventory->price = $item['price'];
                $inventory->save();

                $total += $subtotal;
            }

            $trx->update(['total_realization' => $total]);

            DB::commit();

            return redirect()->route('transactions.show', $trx)->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(InventoryTransaction $transaction)
    {
        $transaction->load(['type', 'details.item']);

        return view('pages.transactions.show', compact('transaction'));
    }
}
