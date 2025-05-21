<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'notification_type_id',
        'channel',
        'subject',
        'body',
    ];

    public function notificationType()
    {
        return $this->belongsTo(Notification_Types::class, 'notification_type_id');
    }
}