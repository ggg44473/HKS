<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $comment;
    private $details;
    private $link;
    private $icon;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $icon)
    {
        $this->comment = $comment;
        $this->icon = $icon;
        if ($comment->parent == null) {
            $users = $comment->commentable->getNotifiable();
            $this->details['name'] = is_a($users, 'App\User') ? $users->name : 'All';
            $this->details['body'] = ' 留言在 ' . $comment->commentable->getHasCommentMessage();
        } else {
            $users = $comment->parent->commenter;
            $this->details['name'] = $users->name;
            $this->details['body'] = ' 回覆您的留言';
            $this->details['parentComment'] = $comment->parent->comment;
        }

        $this->details['commenter'] = $comment->commenter->name;
        $this->details['comment'] = $comment->comment;

        if (is_a($comment->commentable, 'App\Objective')) {
            $this->link = $comment->commentable->model->getOKrRoute() . '#comment-' . $comment->id;
        } elseif (is_a($comment->commentable, 'App\Action')) {
            $this->link = route('actions.show', $comment->commentable->id);
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
        return ['mail', 'database', 'broadcast'];
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
            ->subject('[Goal Care] New Comment')
            ->greeting('Dear ' . $this->details['name'])
            ->line($this->details['commenter'] . $this->details['body'])
            ->line(array_key_exists('parentComment', $this->details) ? $this->details['parentComment'] : '')
            ->line('The comment is')
            ->line($this->details['comment'])
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
            'created_at' => now()->toDateTimeString(),
            'read_at' => null,
            'data' => [
                'message' => $this->details['commenter'] . $this->details['body'],
                'icon' => $this->icon,
                'link' => $this->link,
            ],
        ];
    }
}
