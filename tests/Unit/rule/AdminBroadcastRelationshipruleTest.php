<?php

use App\Models\AdminBroadcast;
use App\Models\User;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);
it('can attach users to admin broadcast', function () {
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

    expect($broadcast->users->contains($user))->toBeTrue();
});

it('detaches users properly', function () {
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
});