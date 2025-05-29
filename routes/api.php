<?php
use App\Http\Controllers\UserNotificationPreferenceController;
use App\Http\Controllers\AdminBroadcastController;

Route::apiResource('broadcasts', AdminBroadcastController::class);


Route::apiResource('notification-preferences', UserNotificationPreferenceController::class);
