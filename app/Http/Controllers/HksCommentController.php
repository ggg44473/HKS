<?php

namespace App\Http\Controllers;

use Notification;
use Illuminate\Http\Request;
use App\User;
use App\Notifications\CommentNotification;

class HksCommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sendNotification()
    {
        $user = User::first();

        $details = [
            'greeting' => 'Hi Artisan',
            'body' => 'This is my first notification from ItSolutionStuff.com',
            'thanks' => 'Thank you for using ItSolutionStuff.com tuto!',
            'actionText' => 'View My Site',
            'actionURL' => url('/'),
            'order_id' => 101
        ];

        Notification::send($user, new CommentNotification($details));

        dd('done');
    }
}