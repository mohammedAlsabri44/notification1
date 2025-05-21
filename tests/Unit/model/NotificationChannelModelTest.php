<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\NotificationChannel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationChannelModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_notification_channel()
    {
        $channel = NotificationChannel::factory()->create([
            'name' => 'Email',
            'is_enabled' => true,
            'priority_order' => 1,
        ]);

        $this->assertDatabaseHas('notification_channels', [
            'name' => 'Email',
            'is_enabled' => true,
            'priority_order' => 1,
        ]);
    }

    /** @test */
    public function it_can_scope_enabled_channels()
    {
        NotificationChannel::factory()->create([
            'name' => 'Email',
            'is_enabled' => true,
            'priority_order' => 2,
        ]);

        NotificationChannel::factory()->create([
            'name' => 'SMS',
            'is_enabled' => false,
        ]);

        $enabled = NotificationChannel::enabled()->get();

        $this->assertCount(1, $enabled);
        $this->assertEquals('Email', $enabled->first()->name);
    }

    /** @test */
    public function it_orders_enabled_channels_by_priority()
    {
        NotificationChannel::factory()->create(['name' => 'One', 'is_enabled' => true, 'priority_order' => 5]);
        NotificationChannel::factory()->create(['name' => 'Two', 'is_enabled' => true, 'priority_order' => 1]);

        $channels = NotificationChannel::enabled()->get();

        $this->assertEquals('Two', $channels->first()->name); // lower priority_order comes first
    }
}