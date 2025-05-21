<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminBroadcastMigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_broadcasts_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasTable('admin_broadcasts'));

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
            $this->assertTrue(
                Schema::hasColumn('admin_broadcasts', $column),
                "Failed asserting that column '{$column}' exists in 'admin_broadcasts' table."
            );
        }
    }
}
