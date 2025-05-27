<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use App\Models\Notification_Types;
use App\Models\NotificationTemplate;


uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);

test('notification type id and channel are unique together', function () {
    $notificationType = Notification_Types::create([
        'name' => 'Test Notification',
        'slug' => 'test-notification',
        'description' => 'test',
        'is_active' => true
    ]);

    NotificationTemplate::create([
        'notification_type_id' => $notificationType->id,
        'channel' => 'email',
        'subject' => 'Welcome!',
        'body' => 'Hello user'
    ]);

    $this->expectException(QueryException::class);

    // Laravel will throw this on unique constraint violation
    // محاولة إدخال نفس النوع ونفس القناة مرة أخرى
    NotificationTemplate::create([
        'notification_type_id' => $notificationType->id,
        'channel' => 'email',
        'subject' => 'Duplicate',
        'body' => 'This should fail'
    ]);
});