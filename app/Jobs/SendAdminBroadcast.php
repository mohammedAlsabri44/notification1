<?php

namespace App\Jobs;

use App\Models\AdminBroadcast;
use App\Models\User;
use App\Notifications\BroadcastNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdminBroadcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public AdminBroadcast $broadcast) {}

    public function handle(): void
    {
        if ($this->broadcast->sent) return;

        $query = User::query();

        if ($this->broadcast->filter_by_role) {
            $query->whereHas('roles', function ($q) {
                $q->where('name', $this->broadcast->filter_by_role);
            });
        }

        $users = $query->get();

        foreach ($users as $user) {
            $user->notify(new BroadcastNotification($this->broadcast));
        }

        $this->broadcast->update(['sent' => true]);
    }
}
