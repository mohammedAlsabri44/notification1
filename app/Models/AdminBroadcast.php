<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AdminBroadcast extends Model
{
use HasFactory;
    protected $fillable = [
        'title',
        'message',
        'channel',
        'filter_by_role',
        'scheduled_at',
        'sent',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    // علاقة مع المستخدمين (لاستهدافهم بناءً على الدور إن وجد)
    public function users()
    {
        return $this->belongsToMany(User::class, 'admin_broadcast_user')
                    ->where(function ($query) {
                        if ($this->filter_by_role) {
                            $query->whereHas('roles', function ($q) {
                                $q->where('name', $this->filter_by_role);
                            });
                        }
                    });
    }
}
