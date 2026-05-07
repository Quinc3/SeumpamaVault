<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    public function index()
    {
        $itemTypes = \App\Models\ItemType::latest()->paginate(10);

        return view('pages.master.item-types.index', compact('itemTypes'));
    }

    public function create()
    {
        return view('pages.master.item-types.create', ['title' => 'Tambah Item Type']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        ItemType::create($data);

        return redirect()->route('item-types.index')->with('success', 'Item type berhasil ditambahkan.');
    }

    public function edit(ItemType $itemType)
    {
        return view('pages.master.item-types.edit', compact('itemType'));
    }

    public function update(Request $request, ItemType $itemType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $itemType->update($data);

        return redirect()->route('item-types.index')->with('success', 'Item type berhasil diupdate.');
    }

    public function destroy(ItemType $itemType)
    {
        $itemType->delete();

        return redirect()->route('item-types.index')->with('success', 'Item type berhasil dihapus.');
    }

    public function __construct()
    {
        if (!auth()->user()?->isAdmin()) {
            abort(403);
        }
    }
}
