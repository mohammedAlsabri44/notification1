<?php

use App\Models\AdminBroadcast;
use App\Models\User;
use Illuminate\Support\Carbon;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);


it('can create admin broadcast with factory', function () {
    $broadcast = AdminBroadcast::factory()->create([
        'sent' => false,
    ]);

    $this->assertDatabaseHas('admin_broadcasts', [
        'id' => $broadcast->id,
        'sent' => false,
    ]);
});

it('casts scheduled at to datetime', function () {
    $broadcast = AdminBroadcast::factory()->create([
        'scheduled_at' => '2025-12-31 12:00:00',
    ]);

    expect($broadcast->scheduled_at)->toBeInstanceOf(Carbon::class);
    expect($broadcast->scheduled_at->format('Y-m-d H:i:s'))->toEqual('2025-12-31 12:00:00');
});

it('can attach users', function () {
    $broadcast = AdminBroadcast::factory()->create();
    $user = User::factory()->create();

    $broadcast->users()->attach($user);

    expect($broadcast->users->contains($user))->toBeTrue();
});