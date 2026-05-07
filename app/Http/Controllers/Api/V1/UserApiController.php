<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Data user berhasil diambil',
            'data' => User::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,staff',
            'permissions' => 'nullable|array',
        ]);

        return response()->json([
            'message' => 'User berhasil dibuat',
            'data' => User::create($data),
        ], 201);
    }

    public function show(User $user)
    {
        return response()->json([
            'message' => 'Detail user berhasil diambil',
            'data' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,staff',
            'permissions' => 'nullable|array',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'User berhasil diupdate',
            'data' => $user,
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'User berhasil dihapus',
        ]);
    }
}
