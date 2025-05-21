<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Database\QueryException;
use App\Models\Notification_Types;
use App\Models\NotificationTemplate;

class NotificationTemplateSchemaTest extends TestCase
{
    use RefreshDatabase;

    // public function test_notification_templates_table_has_expected_columns()
    // {
    //     $this->assertTrue(Schema::hasTable('notification_templates'));

    //     $expected = [
    //         'id',
    //         'notification_type_id',
    //         'channel',
    //         'subject',
    //         'body',
    //         'created_at',
    //         'updated_at'
    //     ];

    //     foreach ($expected as $column) {
    //         $this->assertTrue(
    //             Schema::hasColumn('notification_templates', $column),
    //             "Column '{$column}' is missing from the notification_templates table."
    //         );
    //     }
    // }

    public function test_notification_type_id_and_channel_are_unique_together()
    {
        $notificationType = Notification_Types::create([
            'name' => 'Test Notification',
            'slug' => 'test-notification',
            'description' => 'test',
            'is_active' => true
        ]);

        NotificationTemplate::create([
            'notification_type_id' => $notificationType->id,
            'channel' => 'email',
            'subject' => 'Welcome!',
            'body' => 'Hello user'
        ]);

        $this->expectException(QueryException::class); // Laravel will throw this on unique constraint violation

        // محاولة إدخال نفس النوع ونفس القناة مرة أخرى
        NotificationTemplate::create([
            'notification_type_id' => $notificationType->id,
            'channel' => 'email',
            'subject' => 'Duplicate',
            'body' => 'This should fail'
        ]);
    }
}
