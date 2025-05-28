<?php

namespace App\Http\Controllers;

use App\Models\Notification_Types;
use Illuminate\Http\Request;

class NotificationTypesController extends Controller
{
    public function index()
    {
        return Notification_Types::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        return Notification_Types::create($data);
    }

    public function show(Notification_Types $notification_Type)
    {
        return $notification_Type;
    }

    public function update(Request $request, Notification_Types $notification_Type)
    {
        $data = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $notification_Type->update($data);
        return $notification_Type;
    }

    public function destroy(Notification_Types $notification_Type)
    {
        $notification_Type->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
