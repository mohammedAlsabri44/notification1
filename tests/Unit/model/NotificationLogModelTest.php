<?php

use App\Models\User;
use App\Models\NotificationLog;
use App\Models\Notification_Types;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can create notification log', function () {
    $log = NotificationLog::factory()->create();

    $this->assertDatabaseHas('notification_logs', [
        'id' => $log->id,
        'status' => $log->status,
    ]);
});

it('belongs to user', function () {
    $log = NotificationLog::factory()->create();

    expect($log->user)->toBeInstanceOf(User::class);
});

it('belongs to notification type', function () {
    $log = NotificationLog::factory()->create();

    expect($log->notificationType)->toBeInstanceOf(Notification_Types::class);
});

it('casts dates correctly', function () {
    $log = NotificationLog::factory()->create([
        'sent_at' => now(),
        'created_at' => now(),
    ]);

    expect($log->sent_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
    expect($log->created_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});