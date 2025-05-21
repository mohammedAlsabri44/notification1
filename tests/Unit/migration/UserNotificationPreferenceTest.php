<?php

namespace Tests\Unit\Migration;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class UserNotificationPreferenceTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
{
    parent::setUp();

    // شغّل الهجرات لقاعدة بيانات SQLite الخاصة بالاختبار
    Artisan::call('migrate');
}

    /** @test */
    public function user_notification_preferences_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasTable('user_notification_preferences'));

        $columns = [
            'id',
            'user_id',
            'notification_type_id',
            'channel',
            'is_enabled',
            'created_at',
            'updated_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('user_notification_preferences', $column),
                "Missing column: {$column}"
            );
        }
    }

    /** @test */
    public function it_enforces_unique_user_notification_channel_combination()
    {
        // أنشئ مستخدم
        $user = \App\Models\User::factory()->create();

        // أنشئ نوع إشعار في جدول Notification_Types
        $notificationTypeId = DB::table('Notification_Types')->insertGetId([
            'name' => 'Test Type',
            'slug' => 'test-type',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // إدخال أول
        DB::table('user_notification_preferences')->insert([
            'user_id' => $user->id,
            'notification_type_id' => $notificationTypeId,
            'channel' => 'email',
            'is_enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // محاولة تكرار نفس القيم (يجب أن تفشل)
        $this->expectException(\Illuminate\Database\QueryException::class);

        DB::table('user_notification_preferences')->insert([
            'user_id' => $user->id,
            'notification_type_id' => $notificationTypeId,
            'channel' => 'email',
            'is_enabled' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
