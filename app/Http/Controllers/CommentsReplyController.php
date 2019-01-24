<?php

namespace App\Http\Controllers;

use Laravelista\Comments\CommentsController;
use Laravelista\Comments\Comment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentsReplyController extends CommentsController
{
    /**
     * Creates a reply "comment" to a comment.
     */
    public function reply(Request $request, Comment $comment)
    {
        $this->validate($request, [
            'message' => 'required|string'
        ]);

        $reply = new Comment;
        $reply->commenter()->associate(auth()->user());
        $reply->commentable()->associate($comment->commentable);
        $reply->parent()->associate($comment);
        $reply->comment = $request->message;
        $reply->save();

        return redirect()->to(url()->previous() . '#comment-' . $reply->id);
    }
}