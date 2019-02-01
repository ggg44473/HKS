<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DepartmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $department;
    private $status;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($department, $inOrOut='in')
    {
        $this->department = $department;
        if ($inOrOut == 'in') {
            $this->status = '您已加入部門';
        } elseif ($inOrOut == 'out') {
            $this->status = '您已退出部門';
        }
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
                'message' => $this->status . '[' . $this->department->name . ']',
                'icon' => $this->department->getAvatar(),
                'link' => $this->department->getOKrRoute(),
            ],
        ];
    }
}
