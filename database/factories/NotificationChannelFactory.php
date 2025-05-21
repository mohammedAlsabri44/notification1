<?php

namespace Database\Factories;

use App\Models\NotificationChannel;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationChannelFactory extends Factory
{
    protected $model = NotificationChannel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'is_enabled' => $this->faker->boolean(),
            'priority_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}