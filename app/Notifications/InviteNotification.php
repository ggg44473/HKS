<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InviteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $invitation;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $userName = $this->invitation->user->name;
        $modelType = substr($this->invitation->model_type, 4);
        $model = $this->invitation->model;

        return (new MailMessage)
            ->greeting('Dear ' . $userName)
            ->line('You have been invited into ' . $modelType . ' ' . $model->name)
            ->action('Go to see the invitation', $model->getInviteUrl())
            ->line('You care your goals, we care you.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
