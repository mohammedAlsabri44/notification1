<?php

namespace App\Http\Controllers;

use App\Models\AdminBroadcast;
use Illuminate\Http\Request;

class AdminBroadcastController extends Controller
{
    public function index()
    {
        return AdminBroadcast::with('users')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'channel' => 'required|string',
            'filter_by_role' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
            'sent' => 'boolean',
        ]);

        $broadcast = AdminBroadcast::create($data);

        return response()->json($broadcast, 201);
    }

    public function show(AdminBroadcast $adminBroadcast)
    {
        return $adminBroadcast->load('users');
    }

    public function update(Request $request, AdminBroadcast $adminBroadcast)
    {
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'message' => 'sometimes|string',
            'channel' => 'sometimes|string',
            'filter_by_role' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
            'sent' => 'boolean',
        ]);

        $adminBroadcast->update($data);

        return $adminBroadcast;
    }

    public function destroy(AdminBroadcast $adminBroadcast)
    {
        $adminBroadcast->delete();

        return response()->json(['message' => 'Broadcast deleted']);
    }
}
