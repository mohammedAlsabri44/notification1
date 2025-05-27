<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user_notification_preferences table has expected columns', function () {
    expect(Schema::hasTable('user_notification_preferences'))->toBeTrue();

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
        expect(Schema::hasColumn('user_notification_preferences', $column))->toBeTrue("Missing column: {$column}");
    }
});

it('enforces unique user-notification-type-channel combination', function () {
    $user = \App\Models\User::factory()->create();

    $notificationTypeId = DB::table('notification_types')->insertGetId([
        'name' => 'Test Type',
        'slug' => 'test-type',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('user_notification_preferences')->insert([
        'user_id' => $user->id,
        'notification_type_id' => $notificationTypeId,
        'channel' => 'email',
        'is_enabled' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->expectException(\Illuminate\Database\QueryException::class);

    DB::table('user_notification_preferences')->insert([
        'user_id' => $user->id,
        'notification_type_id' => $notificationTypeId,
        'channel' => 'email', // نفس القيم السابقة
        'is_enabled' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
});
