<?php

namespace App\Http\Controllers;

use App\Models\UserNotificationPreference;
use Illuminate\Http\Request;

class UserNotificationPreferenceController extends Controller
{
    public function index()
    {
        return UserNotificationPreference::with(['user', 'notificationType'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'notification_type_id' => 'required|exists:notification_types,id',
            'channel' => 'required|string',
            'is_enabled' => 'required|boolean',
        ]);

        return UserNotificationPreference::create($data);
    }

    public function show(UserNotificationPreference $userNotificationPreference)
    {
        return $userNotificationPreference->load(['user', 'notificationType']);
    }

    public function update(Request $request, UserNotificationPreference $userNotificationPreference)
    {
        $data = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'notification_type_id' => 'sometimes|exists:notification_types,id',
            'channel' => 'sometimes|string',
            'is_enabled' => 'sometimes|boolean',
        ]);

        $userNotificationPreference->update($data);

        return $userNotificationPreference;
    }

    public function destroy(UserNotificationPreference $userNotificationPreference)
    {
        $userNotificationPreference->delete();

        return response()->json(['message' => 'Preference deleted']);
    }
}
