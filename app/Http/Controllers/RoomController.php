<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Building;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = \App\Models\Room::with('building')->latest()->paginate(10);

        return view('pages.master.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $buildings = \App\Models\Building::all();

        return view('pages.master.rooms.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Room::create($data);

        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        $buildings = Building::orderBy('name')->get();
        return view('pages.master.rooms.edit', compact('room', 'buildings'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $room->update($data);

        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil diupdate.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
