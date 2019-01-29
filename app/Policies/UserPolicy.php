<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can store Objective for the user.
     *
     * @param  \App\User  $current_user
     * @param  \App\User  $user
     * @return mixed
     */
    public function storeObjective(User $current_user, User $user)
    {
        return $current_user->id == $user->id;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $current_user
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $current_user, User $user)
    {
        return $current_user->id === $user->id;
    }
}
