<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);

test('notification logs table has expected columns', function () {
    expect(Schema::hasTable('notification_logs'))->toBeTrue();

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
        expect(Schema::hasColumn('notification_logs', $column))->toBeTrue("Missing column: $column");
    }
});

it('can insert notification log record', function () {
    // إنشاء مستخدم باستخدام factory
    $user = User::factory()->create();

    // إدخال نوع إشعار (Notification Type)
    $typeId = DB::table('Notification_Types')->insertGetId([
        'name' => 'Test Type',
        'slug' => 'test-type',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // إدخال سجل إشعار
    $logId = DB::table('notification_logs')->insertGetId([
        'user_id' => $user->id,
        'notification_type_id' => $typeId,
        'channel' => 'email',
        'sent_at' => now(),
        'status' => 'sent',
        'response_message' => 'Success',
        'created_at' => now(),
    ]);

    // التحقق من أن السجل موجود في قاعدة البيانات
    expect(DB::table('notification_logs')->where('id', $logId)->exists())->toBeTrue();

    // أو باستخدام Pest's database assertion
    $this->assertDatabaseHas('notification_logs', [
        'id' => $logId,
        'user_id' => $user->id,
        'channel' => 'email',
        'status' => 'sent',
    ]);
});
