<?php

namespace App\Http\Controllers;

use App\Models\NotificationChannel;
use Illuminate\Http\Request;

class NotificationChannelController extends Controller
{
    public function index()
    {
        return NotificationChannel::orderBy('priority_order')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'is_enabled' => 'required|boolean',
            'priority_order' => 'required|integer',
        ]);

        return NotificationChannel::create($data);
    }

    public function show(NotificationChannel $notificationChannel)
    {
        return $notificationChannel;
    }

    public function update(Request $request, NotificationChannel $notificationChannel)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'is_enabled' => 'sometimes|boolean',
            'priority_order' => 'sometimes|integer',
        ]);

        $notificationChannel->update($data);

        return $notificationChannel;
    }

    public function destroy(NotificationChannel $notificationChannel)
    {
        $notificationChannel->delete();

        return response()->json(['message' => 'Channel deleted successfully']);
    }

    // ✅ Optional: Return only enabled channels
    public function enabled()
    {
        return NotificationChannel::enabled()->get();
    }
}
