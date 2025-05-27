<?php

use App\Models\NotificationTemplate;
use App\Models\Notification_Types;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can create notification template', function () {
    $template = NotificationTemplate::factory()->create();

    $this->assertDatabaseHas('notification_templates', [
        'id' => $template->id,
        'channel' => $template->channel,
    ]);
});

it('belongs to notification type', function () {
    $template = NotificationTemplate::factory()->create();

    expect($template->notificationType)->toBeInstanceOf(Notification_Types::class);
});