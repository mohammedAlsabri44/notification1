<?php

namespace Database\Factories;

use App\Models\AdminBroadcast;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminBroadcastFactory extends Factory
{
    protected $model = AdminBroadcast::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'message' => $this->faker->paragraph,
            'channel' => $this->faker->randomElement(['email', 'sms', 'in_app']),
            'filter_by_role' => null,
            'scheduled_at' => now()->addDays(1),
            'sent' => false,
        ];
    }
}