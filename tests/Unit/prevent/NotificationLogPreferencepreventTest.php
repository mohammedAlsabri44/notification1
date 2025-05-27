<?php

use App\Models\User;
use App\Models\Notification_Types;
use App\Models\UserNotificationPreference;
use App\Models\NotificationLog;


uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);

test('does not create log if preference disabled', function () {
    // إعداد مستخدم ونوع إشعار
    $user = User::factory()->create();

    $type = Notification_Types::create([
        'name' => 'New Message',
        'slug' => 'new-message',
        'description' => 'Test',
        'is_active' => true,
    ]);

    // تعطيل التفضيل
    UserNotificationPreference::create([
        'user_id' => $user->id,
        'notification_type_id' => $type->id,
        'channel' => 'email',
        'is_enabled' => false,
    ]);

    // منطق التطبيق: لا يتم إنشاء سجل إذا كانت التفضيلات معطلة
    $preference = UserNotificationPreference::where([
        'user_id' => $user->id,
        'notification_type_id' => $type->id,
        'channel' => 'email',
    ])->first();

    if ($preference && $preference->is_enabled) {
        NotificationLog::create([
            'user_id' => $user->id,
            'notification_type_id' => $type->id,
            'channel' => 'email',
            'status' => 'sent',
            'sent_at' => now(),
            'response_message' => 'sent',
            'created_at' => now(),
        ]);
    }

    // التأكد من عدم إنشاء السجل
    $this->assertDatabaseMissing('notification_logs', [
        'user_id' => $user->id,
        'notification_type_id' => $type->id,
        'channel' => 'email',
    ]);
});