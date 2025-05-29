<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminBroadcastController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationTypesController;
use App\Http\Controllers\NotificationChannelController;
use App\Http\Controllers\NotificationLogController;
use App\Http\Controllers\NotificationTemplateController;
use App\Http\Controllers\UserNotificationPreferenceController;

// Route::middleware(['web'])->group(function () {
//     Route::get('/broadcasts', [AdminBroadcastController::class, 'index']);
//     Route::post('/broadcasts', [AdminBroadcastController::class, 'store']);
//     Route::get('/broadcasts/{adminBroadcast}', [AdminBroadcastController::class, 'show']);
//     Route::put('/broadcasts/{adminBroadcast}', [AdminBroadcastController::class, 'update']);
//     Route::delete('/broadcasts/{adminBroadcast}', [AdminBroadcastController::class, 'destroy']);
// });

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::apiResource('users', UserController::class);
});

Route::prefix('api')->group(function () {
    Route::apiResource('broadcasts', AdminBroadcastController::class);
});

Route::prefix('api')->group(function () {
    Route::apiResource('notification_types', NotificationTypesController::class);
});

Route::prefix('api')->group(function () {
    Route::apiResource('channels', NotificationChannelController::class);

    // مسار مخصص للقنوات المفعّلة فقط
    Route::get('enabled-channels', [NotificationChannelController::class, 'enabled']);
});

Route::prefix('api')->group(function () {
    Route::apiResource('notification-logs', NotificationLogController::class);
});

Route::prefix('api')->group(function () {
    Route::apiResource('notification-templates', NotificationTemplateController::class);
});

Route::prefix('api')->group(function () {
    Route::apiResource('notification-preferences', UserNotificationPreferenceController::class);
});



