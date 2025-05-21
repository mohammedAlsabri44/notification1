<?php

namespace Tests\Unit\Models;

use App\Models\Notification_Types;
use App\Models\NotificationTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class NotificationTemplateruleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_enforces_unique_constraint_on_notification_type_and_channel()
    {
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
    }
}
