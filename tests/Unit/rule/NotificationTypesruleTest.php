<?php

namespace Tests\Unit\Models;

use App\Models\Notification_Types;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTypesruleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_enforces_unique_constraint_on_slug()
    {
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
    }
}
