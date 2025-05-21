<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_broadcasts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->enum('channel', ['email', 'sms', 'in_app']);
            $table->string('filter_by_role')->nullable();// تصفية المستخدمين حسب الدور (اختياري)
            $table->dateTime('scheduled_at')->nullable();// موعد الجدولة (اختياري)
            $table->boolean('sent')->default(false);// حالة الإرسال
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_broadcasts');
    }
};
