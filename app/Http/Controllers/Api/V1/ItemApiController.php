<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Data item berhasil diambil',
            'data' => Item::with('itemType')->latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_type_id' => 'required|exists:item_types,id',
            'code' => 'nullable|string|max:255|unique:items,code',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        return response()->json([
            'message' => 'Item berhasil dibuat',
            'data' => Item::create($data),
        ], 201);
    }

    public function show(Item $item)
    {
        return response()->json([
            'message' => 'Detail item berhasil diambil',
            'data' => $item->load(['itemType', 'inventories']),
        ]);
    }

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'item_type_id' => 'required|exists:item_types,id',
            'code' => 'nullable|string|max:255|unique:items,code,' . $item->id,
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $item->update($data);

        return response()->json([
            'message' => 'Item berhasil diupdate',
            'data' => $item,
        ]);
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json([
            'message' => 'Item berhasil dihapus',
        ]);
    }
}
