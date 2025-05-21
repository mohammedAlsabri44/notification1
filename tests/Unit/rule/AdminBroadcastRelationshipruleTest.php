<?php

namespace Tests\Unit\Models;

use App\Models\AdminBroadcast;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBroadcastRelationshipruleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_attach_users_to_admin_broadcast()
    {
        $broadcast = AdminBroadcast::create([
            'title' => 'System Update',
            'message' => 'We will update the system tonight.',
            'channel' => 'in_app',
        ]);

        $user = User::factory()->create();

        $broadcast->users()->attach($user->id);

        $this->assertDatabaseHas('admin_broadcast_user', [
            'admin_broadcast_id' => $broadcast->id,
            'user_id' => $user->id,
        ]);

        $this->assertTrue($broadcast->users->contains($user));
    }

    /** @test */
    public function it_detaches_users_properly()
    {
        $broadcast = AdminBroadcast::create([
            'title' => 'Downtime',
            'message' => 'Planned maintenance.',
            'channel' => 'sms',
        ]);

        $user = User::factory()->create();

        $broadcast->users()->attach($user->id);
        $broadcast->users()->detach($user->id);

        $this->assertDatabaseMissing('admin_broadcast_user', [
            'admin_broadcast_id' => $broadcast->id,
            'user_id' => $user->id,
        ]);
    }
}
