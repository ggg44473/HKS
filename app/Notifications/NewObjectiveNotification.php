<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewObjectiveNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $model;
    private $modelType;
    private $objective;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($model, $objective)
    {
        $this->model = $model;
        $this->modelType = substr(get_class($model), 4);
        $this->objective = $objective;
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
            'read_at' => null,
            'data' => [
                'message' => $this->modelType . '[' . $this->model->name . ']新增了目標[' . $this->objective->title . ']',
                'icon' => $this->model->getAvatar(),
                'link' => $this->model->getOKrRoute() . '#oid-' . $this->objective->id,
            ],
        ];
    }
}
