<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DeadlineNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $model;
    public $modelType;
    public $deadIssue;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($issue)
    {
        $this->deadIssue = $issue;
        $this->modelType = substr($this->deadIssue->model_type, 4);
        $this->model = $this->deadIssue->model;
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
                'message' => '您的目標 [ ' . $this->deadIssue->title . '  ] 於 ' . $this->deadIssue->finished_at . ' 到期，請確認是否需要延期(postpone)',
                'icon' => $this->model->getAvatar(),
                'link' => $this->model->getOKrRoute(),
            ],
        ];
    }
}
