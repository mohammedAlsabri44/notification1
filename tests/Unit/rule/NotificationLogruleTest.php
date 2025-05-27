<?php

use App\Models\User;
use App\Models\Notification_Types;
use App\Models\NotificationLog;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);
it('can create a notification log', function () {
    $user = User::factory()->create();

    $type = Notification_Types::create([
        'name' => 'Test Alert',
        'slug' => 'test-alert',
        'description' => 'Test description',
        'is_active' => true,
    ]);

    $log = NotificationLog::create([
        'user_id' => $user->id,
        'notification_type_id' => $type->id,
        'channel' => 'email',
        'status' => 'sent',
        'sent_at' => now(),
        'response_message' => 'Delivered',
        'created_at' => now(),
    ]);

    $this->assertDatabaseHas('notification_logs', [
        'user_id' => $user->id,
        'notification_type_id' => $type->id,
        'channel' => 'email',
        'status' => 'sent',
        'response_message' => 'Delivered',
    ]);
});