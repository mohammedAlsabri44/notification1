<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Notification_Types;
use Illuminate\Foundation\Testing\RefreshDatabase;

class slug extends TestCase
{
    use RefreshDatabase;

    public function test_slug_is_generated_from_name_when_created()
    {
        // إنشاء نوع إشعار مع اسم معين
        $notificationType = Notification_Types::create([
            'name' => 'Test Notification Type',
            'description' => 'Test description',
            'is_active' => true,
        ]);

        // التأكد من أن الـ slug تم توليده بناءً على الاسم
        $this->assertEquals('test-notification-type', $notificationType->slug);
    }

    public function test_slug_is_updated_when_name_is_updated()
    {
        // إنشاء نوع إشعار مع اسم معين
        $notificationType = Notification_Types::create([
            'name' => 'Test Notification Type',
            'description' => 'Test description',
            'is_active' => true,
        ]);

        // تحديث الاسم
        $notificationType->update([
            'name' => 'Updated Notification Type',
        ]);

        // التأكد من أن الـ slug تم تحديثه بناءً على الاسم الجديد
        $this->assertEquals('updated-notification-type', $notificationType->slug);
    }
}

