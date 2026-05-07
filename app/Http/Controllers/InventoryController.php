<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    private function adminOnly()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }
    }

    public function index(Request $request)
    {
        $query = Inventory::with('item');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('barcode', 'like', '%' . $request->search . '%')
                    ->orWhereHas('item', function ($q2) use ($request) {
                        $q2->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $inventories = $query->latest()->paginate(10);

        return view('pages.inventories.index', compact('inventories'));
    }

    public function create()
    {
        $this->adminOnly();

        $items = Item::orderBy('name')->get();
        $barcode = 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

        return view('pages.inventories.create', compact('items', 'barcode'));
    }

    public function store(Request $request)
    {
        $this->adminOnly();

        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'barcode' => 'nullable|string|max:255|unique:inventories,barcode',
            'expired_date' => 'nullable|date',
            'status' => 'required|in:baik,rusak,expired',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('inventory-photos', 'public');
        }

        Inventory::create($data);

        return redirect()->route('inventories.index')->with('success', 'Inventory berhasil ditambahkan.');
    }

    public function edit(Inventory $inventory)
    {
        $this->adminOnly();

        $items = Item::orderBy('name')->get();

        return view('pages.inventories.edit', compact('inventory', 'items'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $this->adminOnly();

        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'barcode' => 'nullable|string|max:255|unique:inventories,barcode,' . $inventory->id,
            'expired_date' => 'nullable|date',
            'status' => 'required|in:baik,rusak,expired',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            if ($inventory->photo) {
                Storage::disk('public')->delete($inventory->photo);
            }

            $data['photo'] = $request->file('photo')->store('inventory-photos', 'public');
        }

        $inventory->update($data);

        return redirect()->route('inventories.index')->with('success', 'Inventory berhasil diupdate.');
    }

    public function destroy(Inventory $inventory)
    {
        $this->adminOnly();

        $inventory->delete();

        return redirect()->route('inventories.index')->with('success', 'Inventory berhasil dihapus.');
    }

    public function print(Inventory $inventory)
    {
        $this->adminOnly();

        $inventory->load('item');

        return view('pages.inventories.print', compact('inventory'));
    }
}
