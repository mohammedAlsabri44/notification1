<?php

namespace Database\Factories;

use App\Models\Notification_Types;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationTypesFactory extends Factory
{
    protected $model = Notification_Types::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence,
            'is_active' => true,
        ];
    }
     }