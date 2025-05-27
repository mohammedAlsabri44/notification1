<?php

use Illuminate\Support\Facades\Schema;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('notification type table has required columns', function () {
    $expected = ['id', 'name', 'slug', 'description', 'is_active', 'created_at', 'updated_at'];

    foreach ($expected as $column) {
        expect(Schema::hasColumn('notification_types', $column))->toBeTrue(
            "Column '{$column}' is missing from the notification_types table."
        );
    }
});
