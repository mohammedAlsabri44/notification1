<?php

use App\Models\NotificationChannel;
use Illuminate\Support\Facades\Schema;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);

test('notification channels table has expected columns', function () {
    expect(Schema::hasTable('notification_channels'))->toBeTrue();

    $expected = [
        'id', 'name', 'is_enabled', 'priority_order', 'created_at', 'updated_at'
    ];

    foreach ($expected as $column) {
        expect(Schema::hasColumn('notification_channels', $column))->toBeTrue("Missing column: $column");
    }
});

it('can create a notification channel', function () {
    $channel = NotificationChannel::create([
        'name' => 'email',
        'is_enabled' => true,
        'priority_order' => 1,
    ]);

    expect(\DB::table('notification_channels')->where('name', 'email')->exists())->toBeTrue();

    expect($channel->is_enabled)->toBeTrue();
    expect($channel->priority_order)->toEqual(1);
});

it('requires unique name', function () {
    NotificationChannel::create([
        'name' => 'sms',
        'is_enabled' => true,
        'priority_order' => 0,
    ]);

    NotificationChannel::create([
        'name' => 'sms',
        'is_enabled' => false,
        'priority_order' => 2,
    ]);
})->throws(\Illuminate\Database\QueryException::class);

