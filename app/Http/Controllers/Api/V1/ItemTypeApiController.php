<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ItemType;
use Illuminate\Http\Request;

class ItemTypeApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Data item type berhasil diambil',
            'data' => ItemType::withCount('items')->latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        return response()->json([
            'message' => 'Item type berhasil dibuat',
            'data' => ItemType::create($data),
        ], 201);
    }

    public function show(ItemType $itemType)
    {
        return response()->json([
            'message' => 'Detail item type berhasil diambil',
            'data' => $itemType->load('items'),
        ]);
    }

    public function update(Request $request, ItemType $itemType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $itemType->update($data);

        return response()->json([
            'message' => 'Item type berhasil diupdate',
            'data' => $itemType,
        ]);
    }

    public function destroy(ItemType $itemType)
    {
        $itemType->delete();

        return response()->json([
            'message' => 'Item type berhasil dihapus',
        ]);
    }
}
