<?php

namespace App\Http\Controllers;

use App\Models\NotificationTemplate;
use Illuminate\Http\Request;

class NotificationTemplateController extends Controller
{
    public function index()
    {
        return NotificationTemplate::with('notificationType')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'notification_type_id' => 'required|exists:notification_types,id',
            'channel' => 'required|string',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        return NotificationTemplate::create($data);
    }

    public function show(NotificationTemplate $notificationTemplate)
    {
        return $notificationTemplate->load('notificationType');
    }

    public function update(Request $request, NotificationTemplate $notificationTemplate)
    {
        $data = $request->validate([
            'notification_type_id' => 'sometimes|exists:notification_types,id',
            'channel' => 'sometimes|string',
            'subject' => 'sometimes|string|max:255',
            'body' => 'sometimes|string',
        ]);

        $notificationTemplate->update($data);

        return $notificationTemplate;
    }

    public function destroy(NotificationTemplate $notificationTemplate)
    {
        $notificationTemplate->delete();

        return response()->json(['message' => 'Template deleted']);
    }
}
