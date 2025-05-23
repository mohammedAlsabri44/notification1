<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdminBroadcast;
use App\Jobs\SendAdminBroadcast;

class ProcessScheduledBroadcasts extends Command
{
    protected $signature = 'broadcasts:process';
    protected $description = 'Send scheduled admin broadcasts';
//     protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule): void
// {
//     $schedule->command('broadcasts:process')->everyMinute();
// }


    public function handle(): void
    {
        AdminBroadcast::where('sent', false)
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<=', now())
            ->each(fn ($broadcast) => dispatch(new SendAdminBroadcast($broadcast)));

        $this->info('Broadcasts dispatched');
    }
}
