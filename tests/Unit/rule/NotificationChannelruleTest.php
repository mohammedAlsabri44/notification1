<?php

use App\Models\NotificationChannel;
use Illuminate\Database\QueryException;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);
it('enforces unique constraint on name', function () {
    NotificationChannel::create([
        'name' => 'email',
        'is_enabled' => true,
        'priority_order' => 1,
    ]);

    $this->expectException(QueryException::class);

    NotificationChannel::create([
        'name' => 'email', // duplicate name
        'is_enabled' => false,
        'priority_order' => 2,
    ]);
});