<?php

namespace Database\Factories;

use App\Models\NotificationTemplate;
use App\Models\Notification_Types;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationTemplateFactory extends Factory
{
    protected $model = NotificationTemplate::class;

    public function definition(): array
    {
        return [
            'notification_type_id' => Notification_Types::factory(),
            'channel' => $this->faker->randomElement(['email', 'sms', 'in_app']),
            'subject' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
        ];
    }
}
