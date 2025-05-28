<?php

namespace App\Http\Controllers;

use App\Models\NotificationLog;
use Illuminate\Http\Request;

class NotificationLogController extends Controller
{
    public function index()
    {
        return NotificationLog::with(['user', 'notificationType'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'notification_type_id' => 'required|exists:notification_types,id',
            'channel' => 'required|string',
            'sent_at' => 'nullable|date',
            'status' => 'required|string',
            'response_message' => 'nullable|string',
            'created_at' => 'nullable|date',
        ]);

        return NotificationLog::create($data);
    }

    public function show(NotificationLog $notificationLog)
    {
        return $notificationLog->load(['user', 'notificationType']);
    }

    public function update(Request $request, NotificationLog $notificationLog)
    {
        $data = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'notification_type_id' => 'sometimes|exists:notification_types,id',
            'channel' => 'sometimes|string',
            'sent_at' => 'nullable|date',
            'status' => 'sometimes|string',
            'response_message' => 'nullable|string',
            'created_at' => 'nullable|date',
        ]);

        $notificationLog->update($data);

        return $notificationLog;
    }

    public function destroy(NotificationLog $notificationLog)
    {
        $notificationLog->delete();

        return response()->json(['message' => 'Log deleted']);
    }
}
