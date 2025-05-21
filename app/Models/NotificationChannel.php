<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationChannel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_enabled',
        'priority_order',
    ];

    // Optional scope to get only active channels
    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true)->orderBy('priority_order');
    }
}

