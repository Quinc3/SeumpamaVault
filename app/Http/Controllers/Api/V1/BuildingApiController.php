<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Data gedung berhasil diambil',
            'data' => Building::withCount('rooms')->latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:buildings,code',
            'description' => 'nullable|string',
        ]);

        return response()->json([
            'message' => 'Gedung berhasil dibuat',
            'data' => Building::create($data),
        ], 201);
    }

    public function show(Building $building)
    {
        return response()->json([
            'message' => 'Detail gedung berhasil diambil',
            'data' => $building->load('rooms'),
        ]);
    }

    public function update(Request $request, Building $building)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:buildings,code,' . $building->id,
            'description' => 'nullable|string',
        ]);

        $building->update($data);

        return response()->json([
            'message' => 'Gedung berhasil diupdate',
            'data' => $building,
        ]);
    }

    public function destroy(Building $building)
    {
        $building->delete();

        return response()->json([
            'message' => 'Gedung berhasil dihapus',
        ]);
    }
}
