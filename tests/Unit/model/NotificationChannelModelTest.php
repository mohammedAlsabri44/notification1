<?php

use App\Models\NotificationChannel;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);


it('can create a notification channel', function () {
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
});

it('can scope enabled channels', function () {
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

    expect($enabled)->toHaveCount(1);
    expect($enabled->first()->name)->toEqual('Email');
});

it('orders enabled channels by priority', function () {
    NotificationChannel::factory()->create(['name' => 'One', 'is_enabled' => true, 'priority_order' => 5]);
    NotificationChannel::factory()->create(['name' => 'Two', 'is_enabled' => true, 'priority_order' => 1]);

    $channels = NotificationChannel::enabled()->get();

    expect($channels->first()->name)->toEqual('Two');
    // lower priority_order comes first
});