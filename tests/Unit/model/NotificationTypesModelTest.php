<?php

use App\Models\Notification_Types;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can create notification type', function () {
    $type = Notification_Types::factory()->create([
        'name' => 'Test Notification Type',
    ]);

    $this->assertDatabaseHas('notification_types', [
        'name' => 'Test Notification Type',
    ]);
});

it('generates slug when created', function () {
    $type = Notification_Types::factory()->create([
        'name' => 'New Alert Type',
        'slug' => null,
    ]);

    expect($type->slug)->toEqual('new-alert-type');
});

it('updates slug when name is updated', function () {
    $type = Notification_Types::factory()->create([
        'name' => 'Old Name',
    ]);

    $type->update(['name' => 'Updated Name']);

    expect($type->slug)->toEqual('updated-name');
});