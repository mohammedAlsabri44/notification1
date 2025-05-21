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
        if (!Schema::hasTable('notification_templates')) {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_type_id')->constrained('Notification_Types')->onDelete('cascade');
            $table->enum('channel', ['email', 'sms', 'in_app']);
            $table->string('subject')->nullable();
            $table->text('body');
            $table->timestamps();
            $table->unique(['notification_type_id', 'channel']);
        });}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
