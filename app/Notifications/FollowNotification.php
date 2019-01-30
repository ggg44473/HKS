<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FollowNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $model;
    public $modelName;
    public $modelType;
    public $follow;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($follow)
    {
        $this->follow = $follow;
        $this->modelType = substr($this->follow->model_type, 4);
        $this->model = $this->follow->model;
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
        return ['database', 'broadcast'];
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
            'data' => [
                'message' => $this->follow->user->name . '正在追蹤' .  $this->modelType .' '. $this->modelName ,
                'icon' => $this->model->getAvatar(),
                'link' => $this->follow->user->getOKrRoute(),
            ],
        ];
    }
}
