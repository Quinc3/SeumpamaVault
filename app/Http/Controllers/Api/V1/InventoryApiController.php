<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Data inventory berhasil diambil',
            'data' => Inventory::with('item.itemType')->latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'barcode' => 'nullable|string|max:255|unique:inventories,barcode',
            'expired_date' => 'nullable|date',
            'status' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('inventory-photos', 'public');
        }

        return response()->json([
            'message' => 'Inventory berhasil dibuat',
            'data' => Inventory::create($data),
        ], 201);
    }

    public function show(Inventory $inventory)
    {
        return response()->json([
            'message' => 'Detail inventory berhasil diambil',
            'data' => $inventory->load(['item.itemType', 'inventoryRooms.room.building']),
        ]);
    }

    public function update(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'barcode' => 'nullable|string|max:255|unique:inventories,barcode,' . $inventory->id,
            'expired_date' => 'nullable|date',
            'status' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('inventory-photos', 'public');
        }

        $inventory->update($data);

        return response()->json([
            'message' => 'Inventory berhasil diupdate',
            'data' => $inventory,
        ]);
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return response()->json([
            'message' => 'Inventory berhasil dihapus',
        ]);
    }
}
