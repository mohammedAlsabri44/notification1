<?php

namespace Tests\Unit;

use App\Models\Notification_Type;
use App\Models\NotificationTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class NotificationTemplateTest extends TestCase
{
    use RefreshDatabase; // لإعادة تهيئة قاعدة البيانات قبل كل اختبار

    /**
     * التحقق من وجود الأعمدة المتوقعة في جدول notification_templates
     */
    public function test_notification_templates_table_has_expected_columns()
    {
        $columns = [
            'id',
            'notification_type_id',
            'channel',
            'subject',
            'body',
            'created_at',
            'updated_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('notification_templates', $column), "Missing column: $column");
        }
    }

    /**
     * التحقق من إمكانية إنشاء سجل في جدول notification_templates
     */
    // public function test_create_notification_template()
    // {
    //     // أولاً، إنشاء نوع إشعار في جدول Notification_Types
    //     $notificationType = Notification_Type::create([
    //         'name' => 'Test Notification',
    //         'slug' => 'test-notification',
    //     ]);

    //     // ثم نقوم بإنشاء قالب إشعار جديد
    //     $templateData = [
    //         'notification_type_id' => $notificationType->id,
    //         'channel' => 'email',
    //         'subject' => 'Test Subject',
    //         'body' => 'Test Body Content',
    //     ];

    //     $template = NotificationTemplate::create($templateData);

    //     // التأكد من أن السجل تم تخزينه في قاعدة البيانات
    //     $this->assertDatabaseHas('notification_templates', $templateData);
    // }

    // /**
    //  * التأكد من أن القناة (channel) تكون فريدة لكل نوع إشعار (notification_type_id)
    //  */
    // public function test_unique_channel_per_type()
    // {
    //     // إنشاء نوع إشعار جديد
    //     $notificationType = Notification_Type::create([
    //         'name' => 'Unique Test Notification',
    //         'slug' => 'unique-test-notification',
    //     ]);

    //     // إدخال السجل الأول
    //     NotificationTemplate::create([
    //         'notification_type_id' => $notificationType->id,
    //         'channel' => 'email',
    //         'subject' => 'Subject 1',
    //         'body' => 'Body 1',
    //     ]);

    //     // محاولة إدخال السجل الثاني بنفس القناة لنفس النوع
    //     $this->expectException(QueryException::class);
    //     NotificationTemplate::create([
    //         'notification_type_id' => $notificationType->id,
    //         'channel' => 'email',
    //         'subject' => 'Subject 2',
    //         'body' => 'Body 2',
    //     ]);
    // }

    // /**
    //  * التأكد من أن الحذف في جدول Notification_Types يؤدي إلى حذف السجلات المرتبطة في جدول notification_templates (cascade delete)
    //  */
    // public function test_notification_type_delete_cascades_to_templates()
    // {
    //     // إنشاء نوع إشعار جديد
    //     $notificationType = Notification_Type::create([
    //         'name' => 'Test Notification',
    //         'slug' => 'test-notification',
    //     ]);

    //     // إنشاء قالب إشعار مرتبط بهذا النوع
    //     $template = NotificationTemplate::create([
    //         'notification_type_id' => $notificationType->id,
    //         'channel' => 'email',
    //         'subject' => 'Test Subject',
    //         'body' => 'Test Body Content',
    //     ]);

    //     // التأكد من أن القالب تم تخزينه بنجاح في قاعدة البيانات
    //     $this->assertDatabaseHas('notification_templates', [
    //         'notification_type_id' => $notificationType->id,
    //         'channel' => 'email',
    //     ]);

    //     // حذف نوع الإشعار
    //     $notificationType->delete();

    //     // التأكد من أن القالب تم حذفه أيضًا (cascade delete)
    //     $this->assertDatabaseMissing('notification_templates', [
    //         'notification_type_id' => $notificationType->id,
    //     ]);
    // }
}
