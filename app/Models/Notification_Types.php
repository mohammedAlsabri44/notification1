<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Notification_Types extends Model
{
    use HasFactory;
    protected static function newFactory()
    {
        return \Database\Factories\NotificationTypesFactory::new();
    }
    protected $table = 'notification_types';
   protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected static function booted()
    {
        static::creating(function ($notification) {
            if (empty($notification->slug)) {
                $notification->slug = Str::slug($notification->name);
            }
        });

        static::updating(function ($notification) {
            if ($notification->isDirty('name')) {
                $notification->slug = Str::slug($notification->name);
            }
        });
    }


}

