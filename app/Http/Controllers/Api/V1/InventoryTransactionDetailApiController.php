<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\InventoryTransactionDetail;
use Illuminate\Http\Request;

class InventoryTransactionDetailApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Data detail transaksi berhasil diambil',
            'data' => InventoryTransactionDetail::with('item')->latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inventory_transaction_id' => 'required|exists:inventory_transactions,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $data['subtotal'] = $data['quantity'] * $data['price'];

        return response()->json([
            'message' => 'Detail transaksi berhasil dibuat',
            'data' => InventoryTransactionDetail::create($data),
        ], 201);
    }

    public function show(InventoryTransactionDetail $inventoryTransactionDetail)
    {
        return response()->json([
            'message' => 'Detail transaksi berhasil diambil',
            'data' => $inventoryTransactionDetail->load('item'),
        ]);
    }

    public function update(Request $request, InventoryTransactionDetail $inventoryTransactionDetail)
    {
        $data = $request->validate([
            'inventory_transaction_id' => 'required|exists:inventory_transactions,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $data['subtotal'] = $data['quantity'] * $data['price'];

        $inventoryTransactionDetail->update($data);

        return response()->json([
            'message' => 'Detail transaksi berhasil diupdate',
            'data' => $inventoryTransactionDetail,
        ]);
    }

    public function destroy(InventoryTransactionDetail $inventoryTransactionDetail)
    {
        $inventoryTransactionDetail->delete();

        return response()->json([
            'message' => 'Detail transaksi berhasil dihapus',
        ]);
    }
}
