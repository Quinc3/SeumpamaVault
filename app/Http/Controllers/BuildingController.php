<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = \App\Models\Building::latest()->paginate(10);

        return view('pages.master.buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('pages.master.buildings.create', ['title' => 'Tambah Building']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Building::create($data);

        return redirect()->route('buildings.index')->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function edit(Building $building)
    {
        return view('pages.master.buildings.edit', compact('building'));
    }

    public function update(Request $request, Building $building)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $building->update($data);

        return redirect()->route('buildings.index')->with('success', 'Gedung berhasil diupdate.');
    }

    public function destroy(Building $building)
    {
        $building->delete();

        return redirect()->route('buildings.index')->with('success', 'Gedung berhasil dihapus.');
    }
}
