<?php

use App\Models\NotificationTemplate;
use App\Models\Notification_Types;
use Illuminate\Database\QueryException;


uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);
test('allows only valid enum values for channel', function () {
    $type = Notification_Types::create([
        'name' => 'Test Type',
        'slug' => 'test-type',
        'description' => 'description',
        'is_active' => true,
    ]);

    // ✅ valid channel
    $template = NotificationTemplate::create([
        'notification_type_id' => $type->id,
        'channel' => 'email',
        'subject' => 'Test Subject',
        'body' => 'Test Body',
    ]);

    expect($template->channel)->toEqual('email');

    // ❌ invalid channel should fail
    $this->expectException(QueryException::class);

    NotificationTemplate::create([
        'notification_type_id' => $type->id,
        'channel' => 'whatsapp',
        'subject' => 'Invalid',
        'body' => 'Body',
    ]);
});