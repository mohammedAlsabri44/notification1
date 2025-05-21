<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_NotificationType_table_has_required_columns()
    {
        $expected = ['id', 'name', 'slug', 'description', 'is_active', 'created_at', 'updated_at'];

        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn('notification_types', $column),
                "Column '{$column}' is missing from the NotificationType table."
            );
        }
    }
}

