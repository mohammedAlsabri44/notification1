<?php

use App\Models\User;
use App\Models\Notification_Types;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);
it('enforces unique constraint on user type and channel', function () {
    $user = User::factory()->create();

    $type = Notification_Types::create([
        'name' => 'System Alert',
        'slug' => 'system-alert',
        'description' => 'System related notifications',
        'is_active' => true,
    ]);

    DB::table('user_notification_preferences')->insert([
        'user_id' => $user->id,
        'notification_type_id' => $type->id,
        'channel' => 'email',
        'is_enabled' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->expectException(QueryException::class);

    // Insert duplicate (violates unique)
    DB::table('user_notification_preferences')->insert([
        'user_id' => $user->id,
        'notification_type_id' => $type->id,
        'channel' => 'email', // duplicate
        'is_enabled' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
});