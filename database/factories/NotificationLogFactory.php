<?php

namespace Database\Factories;

use App\Models\NotificationLog;
use App\Models\User;
use App\Models\Notification_Types;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationLogFactory extends Factory
{
    protected $model = NotificationLog::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'notification_type_id' => Notification_Types::factory(),
            'channel' => $this->faker->randomElement(['email', 'sms', 'in_app']),
            'sent_at' => now(),
            'status' => 'sent',
            'response_message' => $this->faker->sentence,
            'created_at' => now(),
        ];
    }
}