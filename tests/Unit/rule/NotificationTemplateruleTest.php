<?php

use App\Models\Notification_Types;
use App\Models\NotificationTemplate;
use Illuminate\Database\QueryException;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);
it('enforces unique constraint on notification type and channel', function () {
    $type = Notification_Types::create([
        'name' => 'Test Type',
        'slug' => 'test-type',
        'description' => 'Test Desc',
        'is_active' => true,
    ]);

    NotificationTemplate::create([
        'notification_type_id' => $type->id,
        'channel' => 'email',
        'subject' => 'Subject A',
        'body' => 'Body A',
    ]);

    $this->expectException(QueryException::class);

    NotificationTemplate::create([
        'notification_type_id' => $type->id, // same type
        'channel' => 'email',                // same channel (violates unique)
        'subject' => 'Subject B',
        'body' => 'Body B',
    ]);
});