<?php

namespace App\Traits;

use App\Invitation;
use App\ProjectUser;
use App\User;
use Notification;
use App\Notifications\InviteNotification;

trait HasInvitationTrait
{
    /**
     * Returns all invitation for this model.
     */
    public function invitation()
    {
        return $this->morphMany(Invitation::class, 'model');
    }

    public function sendInvitation($request)
    {
        $userIds = preg_split("/[,]+/", $request->invite);
        foreach ($userIds as $userId) {
            $attr['user_id'] = $userId;
            $attr['model_id'] = $this->id;
            $attr['model_type'] = get_class($this);
            if (Invitation::where($attr)->first() == null) {
                $invitation = Invitation::create($attr);
                Notification::send(User::findOrFail($userId), new InviteNotification($invitation));
            }
        }
    }

    public function deleteInvitation($user)
    {
        $this->invitation->where('user_id', $user->id)->first()->delete();
    }

    public function getInvitationUsers()
    {
        $users = [];
        foreach ($this->invitation as $invitation) {
            $users[] = $invitation->user;
        }

        return $users;
    }
}
