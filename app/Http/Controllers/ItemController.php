<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('itemType')->latest()->paginate(10);

        return view('pages.master.items.index', compact('items'));
    }

    public function create()
    {
        $itemTypes = ItemType::orderBy('name')->get();

        return view('pages.master.items.create', compact('itemTypes'));
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

        Item::create($data);

        return redirect()->route('items.index')->with('success', 'Item berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        $itemTypes = ItemType::orderBy('name')->get();

        return view('pages.master.items.edit', compact('item', 'itemTypes'));
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

        return redirect()->route('items.index')->with('success', 'Item berhasil diupdate.');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item berhasil dihapus.');
    }
}
