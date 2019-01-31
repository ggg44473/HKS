<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActivityNotification extends Notification implements ShouldQueue
{
    use Queueable;


    public $freshIssue;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($issue)
    {
        $this->freshIssue = $issue;
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
                'message' => '您安排的行程 [ ' . $this->freshIssue->title . '  ] ' . Carbon::parse($this->freshIssue->started_at)->diffForHumans() . '後開始，請盡早預備',
                'icon' => asset('img/logo/favicon.ico'),
                'link' => route('calendar.show', $this->freshIssue->id),
            ],
        ];
    }
}
