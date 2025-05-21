<?php

namespace Tests\Unit\Models;

use App\Models\NotificationChannel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class NotificationChannelruleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_enforces_unique_constraint_on_name()
    {
        NotificationChannel::create([
            'name' => 'email',
            'is_enabled' => true,
            'priority_order' => 1,
        ]);

        $this->expectException(QueryException::class);

        NotificationChannel::create([
            'name' => 'email', // duplicate name
            'is_enabled' => false,
            'priority_order' => 2,
        ]);
    }
}
