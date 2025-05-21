<?php

namespace Tests\Unit\Models;

use App\Models\AdminBroadcast;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AdminBroadcastModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_admin_broadcast_with_factory()
    {
        $broadcast = AdminBroadcast::factory()->create([
            'sent' => false,
        ]);

        $this->assertDatabaseHas('admin_broadcasts', [
            'id' => $broadcast->id,
            'sent' => false,
        ]);
    }

    /** @test */
    public function it_casts_scheduled_at_to_datetime()
    {
        $broadcast = AdminBroadcast::factory()->create([
            'scheduled_at' => '2025-12-31 12:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $broadcast->scheduled_at);
        $this->assertEquals('2025-12-31 12:00:00', $broadcast->scheduled_at->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_can_attach_users()
    {
        $broadcast = AdminBroadcast::factory()->create();
        $user = User::factory()->create();

        $broadcast->users()->attach($user);

        $this->assertTrue($broadcast->users->contains($user));
    }
}