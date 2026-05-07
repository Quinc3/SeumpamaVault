<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Data ruangan berhasil diambil',
            'data' => Room::with('building')->latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:rooms,code',
            'description' => 'nullable|string',
        ]);

        return response()->json([
            'message' => 'Ruangan berhasil dibuat',
            'data' => Room::create($data),
        ], 201);
    }

    public function show(Room $room)
    {
        return response()->json([
            'message' => 'Detail ruangan berhasil diambil',
            'data' => $room->load(['building', 'inventoryRooms.inventory.item']),
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:rooms,code,' . $room->id,
            'description' => 'nullable|string',
        ]);

        $room->update($data);

        return response()->json([
            'message' => 'Ruangan berhasil diupdate',
            'data' => $room,
        ]);
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json([
            'message' => 'Ruangan berhasil dihapus',
        ]);
    }
}
