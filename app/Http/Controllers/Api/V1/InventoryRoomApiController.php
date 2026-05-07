<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\InventoryRoom;
use Illuminate\Http\Request;

class InventoryRoomApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Data lokasi inventory berhasil diambil',
            'data' => InventoryRoom::with(['inventory.item', 'room.building'])->latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'room_id' => 'required|exists:rooms,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'nullable|string|max:255',
            'assigned_at' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $data['assigned_at'] ??= now();

        return response()->json([
            'message' => 'Inventory berhasil ditempatkan ke ruangan',
            'data' => InventoryRoom::create($data),
        ], 201);
    }

    public function show(InventoryRoom $inventoryRoom)
    {
        return response()->json([
            'message' => 'Detail lokasi inventory berhasil diambil',
            'data' => $inventoryRoom->load(['inventory.item', 'room.building']),
        ]);
    }

    public function update(Request $request, InventoryRoom $inventoryRoom)
    {
        $data = $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'room_id' => 'required|exists:rooms,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'nullable|string|max:255',
            'assigned_at' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $inventoryRoom->update($data);

        return response()->json([
            'message' => 'Lokasi inventory berhasil diupdate',
            'data' => $inventoryRoom,
        ]);
    }

    public function destroy(InventoryRoom $inventoryRoom)
    {
        $inventoryRoom->delete();

        return response()->json([
            'message' => 'Lokasi inventory berhasil dihapus',
        ]);
    }
}
