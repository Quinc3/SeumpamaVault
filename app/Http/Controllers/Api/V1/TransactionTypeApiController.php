<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TransactionType;
use Illuminate\Http\Request;

class TransactionTypeApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Data jenis transaksi berhasil diambil',
            'data' => TransactionType::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        return response()->json([
            'message' => 'Jenis transaksi berhasil dibuat',
            'data' => TransactionType::create($data),
        ], 201);
    }

    public function show(TransactionType $transactionType)
    {
        return response()->json([
            'message' => 'Detail jenis transaksi berhasil diambil',
            'data' => $transactionType,
        ]);
    }

    public function update(Request $request, TransactionType $transactionType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $transactionType->update($data);

        return response()->json([
            'message' => 'Jenis transaksi berhasil diupdate',
            'data' => $transactionType,
        ]);
    }

    public function destroy(TransactionType $transactionType)
    {
        $transactionType->delete();

        return response()->json([
            'message' => 'Jenis transaksi berhasil dihapus',
        ]);
    }
}
