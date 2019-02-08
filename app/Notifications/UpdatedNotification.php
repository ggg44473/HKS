<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $model;
    public $modelName;
    public $modelType;
    public $updated;
    public $type;
    public $getRoute;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($updated)
    {
        $this->updated = $updated;
        // Action or KR
        $this->type = substr(get_class($this->updated), 4);
        // User? Object? Comp? Dep?
        $this->model = $this->updated->user ?? $this->updated->objective->model;
        $this->modelType = substr(get_class($this->model), 4);
        $this->modelName = $this->model->name ?? $this->model->title;
        $this->getRoute = is_a($this->updated, 'App\Action') ? $this->updated->getUrl() : $this->model->getOKrRoute();
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
                'message' => $this->modelType . ' [ ' . $this->modelName . ' ]的' . $this->type . ' [ ' . $this->updated->title . ' ] 更新於' . $this->updated->updated_at,
                'icon' => $this->model->getAvatar(),
                'link' => $this->getRoute,
            ],
        ];
    }
}
