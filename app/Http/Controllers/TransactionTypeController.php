<?php

namespace App\Http\Controllers;

use App\Models\TransactionType;
use Illuminate\Http\Request;

class TransactionTypeController extends Controller
{
    public function index()
    {
        $transactionTypes = \App\Models\TransactionType::latest()->paginate(10);

        return view('pages.master.transaction-types.index', compact('transactionTypes'));
    }

    public function create()
    {
        return view('pages.master.transaction-types.create', ['title' => 'Tambah Transaction Type']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        TransactionType::create($data);

        return redirect()->route('transaction-types.index')->with('success', 'Jenis transaksi berhasil ditambahkan.');
    }

    public function edit(TransactionType $transactionType)
    {
        return view('pages.master.transaction-types.edit', compact('transactionType'));
    }

    public function update(Request $request, TransactionType $transactionType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $transactionType->update($data);

        return redirect()->route('transaction-types.index')->with('success', 'Jenis transaksi berhasil diupdate.');
    }

    public function destroy(TransactionType $transactionType)
    {
        $transactionType->delete();

        return redirect()->route('transaction-types.index')->with('success', 'Jenis transaksi berhasil dihapus.');
    }
}
