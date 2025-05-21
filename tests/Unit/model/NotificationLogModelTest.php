<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\NotificationLog;
use App\Models\Notification_Types;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationLogModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_notification_log()
    {
        $log = NotificationLog::factory()->create();

        $this->assertDatabaseHas('notification_logs', [
            'id' => $log->id,
            'status' => $log->status,
        ]);
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $log = NotificationLog::factory()->create();

        $this->assertInstanceOf(User::class, $log->user);
    }

    /** @test */
    public function it_belongs_to_notification_type()
    {
        $log = NotificationLog::factory()->create();

        $this->assertInstanceOf(Notification_Types::class, $log->notificationType);
    }

    /** @test */
    public function it_casts_dates_correctly()
    {
        $log = NotificationLog::factory()->create([
            'sent_at' => now(),
            'created_at' => now(),
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $log->sent_at);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $log->created_at);
    }
}