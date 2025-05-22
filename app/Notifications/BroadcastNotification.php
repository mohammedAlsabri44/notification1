<?php

namespace App\Notifications;

use App\Models\AdminBroadcast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;


class BroadcastNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public AdminBroadcast $broadcast) {}

    public function via($notifiable)
    {
        return [$this->broadcast->channel]; // mail, sms, in_app
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->broadcast->title)
            ->line($this->broadcast->message);
    }

   public function toVonage($notifiable)
{
    return (new VonageMessage)
        ->content($this->broadcast->message);
}


    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->broadcast->title,
            'message' => $this->broadcast->message,
        ];
    }
}
