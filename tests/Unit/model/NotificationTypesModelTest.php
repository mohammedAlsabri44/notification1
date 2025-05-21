<?php

namespace Tests\Unit\Models;

use App\Models\Notification_Types;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTypesModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_notification_type()
    {
        $type = Notification_Types::factory()->create([
            'name' => 'Test Notification Type',
        ]);

        $this->assertDatabaseHas('notification_types', [
            'name' => 'Test Notification Type',
        ]);
    }

    /** @test */
    public function it_generates_slug_when_created()
    {
        $type = Notification_Types::factory()->create([
            'name' => 'New Alert Type',
            'slug' => null,
        ]);

        $this->assertEquals('new-alert-type', $type->slug);
    }

    /** @test */
    public function it_updates_slug_when_name_is_updated()
    {
        $type = Notification_Types::factory()->create([
            'name' => 'Old Name',
        ]);

        $type->update(['name' => 'Updated Name']);

        $this->assertEquals('updated-name', $type->slug);
    }
}