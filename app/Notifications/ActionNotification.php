<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActionNotification extends Notification implements ShouldQueue
{
    use Queueable;


    public $deadIssue;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($issue)
    {
        $this->deadIssue = $issue;
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
                'message' => '您的 Action [ ' . $this->deadIssue->title . '  ] 於 ' . $this->deadIssue->finished_at . ' 到期，請確認是否需要延期(postpone)',
                'icon' => $this->deadIssue->getAvatar(),
                'link' => route('actions.show', $this->deadIssue->id),
            ],
        ];
    }
}
