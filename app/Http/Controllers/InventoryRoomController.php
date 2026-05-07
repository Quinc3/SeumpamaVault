<?php

namespace App\Http\Controllers;

use App\Models\InventoryRoom;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryRoomController extends Controller
{
    public function index()
    {
        $inventoryRooms = \App\Models\InventoryRoom::with(['inventory.item', 'room.building'])
            ->latest()
            ->paginate(10);

        return view('pages.inventory-rooms.index', compact('inventoryRooms'));
    }

    public function create()
    {
        $inventories = \App\Models\Inventory::with('item')->orderBy('barcode')->get();
        $rooms = \App\Models\Room::with('building')->orderBy('name')->get();

        return view('pages.inventory-rooms.create', compact('inventories', 'rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'room_id' => 'required|exists:rooms,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:baik,rusak,dipindahkan',
            'assigned_at' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $inventory = Inventory::findOrFail($data['inventory_id']);

        $usedQuantity = InventoryRoom::where('inventory_id', $inventory->id)->sum('quantity');
        $availableQuantity = $inventory->quantity - $usedQuantity;

        if ($data['quantity'] > $availableQuantity) {
            return back()
                ->withInput()
                ->withErrors(['quantity' => 'Jumlah melebihi stok tersedia. Stok tersedia: ' . $availableQuantity]);
        }

        InventoryRoom::create($data);

        return redirect()->route('inventory-rooms.index')->with('success', 'Barang berhasil didistribusikan.');
    }

    public function edit(\App\Models\InventoryRoom $inventoryRoom)
    {
        $inventories = \App\Models\Inventory::with('item')->orderBy('barcode')->get();
        $rooms = \App\Models\Room::with('building')->orderBy('name')->get();

        return view('pages.inventory-rooms.edit', compact('inventoryRoom', 'inventories', 'rooms'));
    }

    public function update(Request $request, InventoryRoom $inventoryRoom)
    {
        $data = $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'room_id' => 'required|exists:rooms,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:baik,rusak,dipindahkan',
            'assigned_at' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $inventory = Inventory::findOrFail($data['inventory_id']);

        $usedQuantity = InventoryRoom::where('inventory_id', $inventory->id)
            ->where('id', '!=', $inventoryRoom->id)
            ->sum('quantity');

        $availableQuantity = $inventory->quantity - $usedQuantity;

        if ($data['quantity'] > $availableQuantity) {
            return back()
                ->withInput()
                ->withErrors(['quantity' => 'Jumlah melebihi stok tersedia. Stok tersedia: ' . $availableQuantity]);
        }

        $inventoryRoom->update($data);

        return redirect()->route('inventory-rooms.index')->with('success', 'Distribusi barang berhasil diupdate.');
    }

    public function destroy(InventoryRoom $inventoryRoom)
    {
        $inventoryRoom->delete();

        return redirect()->route('inventory-rooms.index')->with('success', 'Distribusi barang berhasil dihapus.');
    }
}
