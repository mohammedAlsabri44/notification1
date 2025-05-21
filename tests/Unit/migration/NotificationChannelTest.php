<?php

namespace Tests\Unit;

use App\Models\NotificationChannel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NotificationChannelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function notification_channels_table_has_expected_columns(): void
    {
        $this->assertTrue(Schema::hasTable('notification_channels'));

        $expected = [
            'id', 'name', 'is_enabled', 'priority_order', 'created_at', 'updated_at'
        ];

        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn('notification_channels', $column),
                "Missing column: $column"
            );
        }
    }

    #[Test]
    public function it_can_create_a_notification_channel(): void
    {
        $channel = NotificationChannel::create([
            'name' => 'email',
            'is_enabled' => true,         // نمررها يدويًا لتجنب مشكلة SQLite
            'priority_order' => 1,        // نمررها أيضًا
        ]);

        $this->assertDatabaseHas('notification_channels', [
            'name' => 'email',
            'is_enabled' => true,
            'priority_order' => 1,
        ]);

        $this->assertTrue($channel->is_enabled);
        $this->assertEquals(1, $channel->priority_order);
    }

    #[Test]
    public function it_requires_unique_name(): void
    {
        NotificationChannel::create([
            'name' => 'sms',
            'is_enabled' => true,
            'priority_order' => 0,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        NotificationChannel::create([
            'name' => 'sms', // محاولة تكرار الاسم
            'is_enabled' => false,
            'priority_order' => 2,
        ]);
    }
}


