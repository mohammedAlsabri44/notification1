<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\NotificationTemplate;
use App\Models\Notification_Types;
use Illuminate\Database\QueryException;

class NotificationTemplatevalidateTest extends TestCase
{
    use RefreshDatabase;

    public function test_allows_only_valid_enum_values_for_channel()
    {
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

        $this->assertEquals('email', $template->channel);

        // ❌ invalid channel should fail
        $this->expectException(QueryException::class);

        NotificationTemplate::create([
            'notification_type_id' => $type->id,
            'channel' => 'whatsapp',
            'subject' => 'Invalid',
            'body' => 'Body',
        ]);
    }
}
