<?php

use Illuminate\Support\Facades\Schema;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);

test('admin broadcasts table has expected columns', function () {
    expect(Schema::hasTable('admin_broadcasts'))->toBeTrue();

    $expectedColumns = [
        'id',
        'title',
        'message',
        'channel',
        'filter_by_role',
        'scheduled_at',
        'sent',
        'created_at',
        'updated_at',
    ];

    foreach ($expectedColumns as $column) {
        expect(Schema::hasColumn('admin_broadcasts', $column))
            ->toBeTrue("Failed asserting that column '{$column}' exists in 'admin_broadcasts' table.");
    }
});
