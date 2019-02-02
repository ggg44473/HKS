<?php

namespace App\Policies;

use App\User;
use App\Action;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the action.
     *
     * @param  \App\User  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function view(User $user, Action $action)
    {
        //
    }

    /**
     * Determine whether the user can create actions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the action.
     *
     * @param  \App\User  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function update(User $user, Action $action)
    {
        if ($user->id === $action->user_id) return true;
        if (isset($user->role($action->objective->model)->id)) {
            return $user->role($action->objective->model)->id <= 3;
        } else {
            return false;
        }

    }

    /**
     * Determine whether the user can delete the action.
     *
     * @param  \App\User  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function delete(User $user, Action $action)
    {
        if ($user->id === $action->user_id) return true;
        return $user->role($action->objective->model)->id <= 3;
    }

    /**
     * Determine whether the user can restore the action.
     *
     * @param  \App\User  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function restore(User $user, Action $action)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the action.
     *
     * @param  \App\User  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function forceDelete(User $user, Action $action)
    {
        //
    }
}
