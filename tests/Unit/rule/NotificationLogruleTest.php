<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Notification_Types;
use App\Models\NotificationLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationLogruleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_notification_log()
    {
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
    }
}
