<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryTransactionApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Data transaksi inventory berhasil diambil',
            'data' => InventoryTransaction::with(['type', 'details.item'])->latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'transaction_type_id' => 'required|exists:transaction_types,id',
            'transaction_code' => 'nullable|string|max:255|unique:inventory_transactions,transaction_code',
            'transaction_date' => 'required|date',
            'total_budget' => 'nullable|numeric|min:0',
            'total_realization' => 'nullable|numeric|min:0',
            'evidence_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'description' => 'nullable|string',

            'details' => 'nullable|array',
            'details.*.item_id' => 'required_with:details|exists:items,id',
            'details.*.quantity' => 'required_with:details|integer|min:1',
            'details.*.price' => 'required_with:details|numeric|min:0',
        ]);

        if ($request->hasFile('evidence_file')) {
            $data['evidence_file'] = $request->file('evidence_file')->store('transaction-evidence', 'public');
        }

        $details = $data['details'] ?? [];
        unset($data['details']);

        $transaction = DB::transaction(function () use ($data, $details) {
            $transaction = InventoryTransaction::create($data);

            foreach ($details as $detail) {
                $detail['subtotal'] = $detail['quantity'] * $detail['price'];
                $transaction->details()->create($detail);
            }

            return $transaction;
        });

        return response()->json([
            'message' => 'Transaksi inventory berhasil dibuat',
            'data' => $transaction->load(['type', 'details.item']),
        ], 201);
    }

    public function show(InventoryTransaction $transaction)
    {
        return response()->json([
            'message' => 'Detail transaksi inventory berhasil diambil',
            'data' => $transaction->load(['type', 'details.item']),
        ]);
    }

    public function update(Request $request, InventoryTransaction $transaction)
    {
        $data = $request->validate([
            'transaction_type_id' => 'required|exists:transaction_types,id',
            'transaction_code' => 'nullable|string|max:255|unique:inventory_transactions,transaction_code,' . $transaction->id,
            'transaction_date' => 'required|date',
            'total_budget' => 'nullable|numeric|min:0',
            'total_realization' => 'nullable|numeric|min:0',
            'evidence_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'description' => 'nullable|string',

            'details' => 'nullable|array',
            'details.*.item_id' => 'required_with:details|exists:items,id',
            'details.*.quantity' => 'required_with:details|integer|min:1',
            'details.*.price' => 'required_with:details|numeric|min:0',
        ]);

        if ($request->hasFile('evidence_file')) {
            $data['evidence_file'] = $request->file('evidence_file')->store('transaction-evidence', 'public');
        }

        $details = $data['details'] ?? null;
        unset($data['details']);

        DB::transaction(function () use ($transaction, $data, $details) {
            $transaction->update($data);

            if (is_array($details)) {
                $transaction->details()->delete();

                foreach ($details as $detail) {
                    $detail['subtotal'] = $detail['quantity'] * $detail['price'];
                    $transaction->details()->create($detail);
                }
            }
        });

        return response()->json([
            'message' => 'Transaksi inventory berhasil diupdate',
            'data' => $transaction->load(['type', 'details.item']),
        ]);
    }

    public function destroy(InventoryTransaction $transaction)
    {
        $transaction->details()->delete();
        $transaction->delete();

        return response()->json([
            'message' => 'Transaksi inventory berhasil dihapus',
        ]);
    }
}
