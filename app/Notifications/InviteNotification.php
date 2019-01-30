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
    public $userName;
    public $userId;
    public $modelType;
    public $model;
    public $modelName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invitation)
    {
        $this->invitation = $invitation;

        $this->userName = $this->invitation->user->name;
        $this->userId = $this->invitation->user->id;
        $this->modelType = substr($this->invitation->model_type, 4);
        $this->model = $this->invitation->model;
        $this->modelName = $this->model->name ?? $this->model->title;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
        // return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Dear ' . $this->userName)
            ->line('You have been invited into ' . $this->modelType . ' ' . $this->modelName)
            ->action('Go to see the invitation', $this->model->getInviteUrl($this->userId))
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
            'id' => $this->id,
            'read_at' => null,
            'data' => [
                'message' => '您被邀請至' . $this->modelType . ' ' . $this->modelName,
                'icon' => $this->model->getAvatar(),
                'link' => $this->model->getInviteUrl($this->userId),
            ],
        ];
    }
}
