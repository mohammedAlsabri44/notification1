<?php

use App\Models\Notification_Types;
use Illuminate\Database\QueryException;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);
it('enforces unique constraint on slug', function () {
    Notification_Types::create([
        'name' => 'Test Name',
        'slug' => 'test-name',
        'description' => 'desc',
        'is_active' => true,
    ]);

    $this->expectException(QueryException::class);

    Notification_Types::create([
        'name' => 'Another Name',
        'slug' => 'test-name', // duplicate slug
        'description' => 'another',
        'is_active' => true,
    ]);
});