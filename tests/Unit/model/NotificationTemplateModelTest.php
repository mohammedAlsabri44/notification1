<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\NotificationTemplate;
use App\Models\Notification_Types;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTemplateModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_notification_template()
    {
        $template = NotificationTemplate::factory()->create();

        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'channel' => $template->channel,
        ]);
    }

    /** @test */
    public function it_belongs_to_notification_type()
    {
        $template = NotificationTemplate::factory()->create();

        $this->assertInstanceOf(Notification_Types::class, $template->notificationType);
    }
}
