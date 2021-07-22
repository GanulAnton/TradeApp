<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;
    public $data;
    public $type;
    public $title;
    public $description;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data ,$type, $title = null, $description = null)
    {
        $this->data = $data;
        $this->type = $type;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function toBroadcast()
    {
        return [
            'data' => $this->data,
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
