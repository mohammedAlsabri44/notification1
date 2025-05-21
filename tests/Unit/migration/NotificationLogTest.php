<?php

namespace Tests\Unit\Migration;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User;

class NotificationLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function notification_logs_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasTable('notification_logs'));

        $expected = [
            'id',
            'user_id',
            'notification_type_id',
            'channel',
            'sent_at',
            'status',
            'response_message',
            'created_at',
        ];

        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn('notification_logs', $column),
                "Missing column: $column"
            );
        }
    }

    // /** @test */
    // public function it_can_insert_notification_log_record()
    // {
    //     $user = User::factory()->create();

    //     $typeId = DB::table('Notification_Types')->insertGetId([
    //         'name' => 'Test Type',
    //         'slug' => 'test-type',
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     $logId = DB::table('notification_logs')->insertGetId([
    //         'user_id' => $user->id,
    //         'notification_type_id' => $typeId,
    //         'channel' => 'email',
    //         'sent_at' => now(),
    //         'status' => 'sent',
    //         'response_message' => 'Success',
    //         'created_at' => now(),
    //     ]);

    //     $this->assertDatabaseHas('notification_logs', [
    //         'id' => $logId,
    //         'user_id' => $user->id,
    //         'channel' => 'email',
    //         'status' => 'sent',
    //     ]);
    // }
}
