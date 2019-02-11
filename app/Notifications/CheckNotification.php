<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CheckNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $model;
    public $modelName;
    public $modelType;
    public $objective;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($obj)
    {
        $this->objective = $obj;
        $this->modelType = substr($this->objective->model_type, 4);
        $this->model = $this->objective->model;
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
            'created_at' => now()->toDateTimeString(),
            'data' => [
                'message' => '您當前的目標 [ ' . $this->objective->title . '  ] 已超過七天沒更新關鍵指標 ! 請填上最新的達成值、信心指數。',
                'icon' => $this->model->getAvatar(),
                'link' => $this->model->getOKrRoute(),
            ],
        ];
    }
}

