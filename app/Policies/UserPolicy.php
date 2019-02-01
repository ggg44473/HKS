<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function view(User $current_user, User $user)
    {
        return $current_user->company_id === $user->company_id;
    }
    
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

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $current_user
     * @param  \App\User  $user
     * @param  $model
     * @return mixed
     */
    public function adminCange(User $current_user, User $user, $model)
    {
        if ($current_user->role($model)->id == 1 && $current_user->id == $user->id) return true;
        if ($current_user->role($current_user->company)->id == 1 && get_class($model)==Department::class) return true;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $current_user
     * @param  \App\User  $user
     * @param  $model
     * @return mixed
     */
    public function permissionCange(User $current_user, User $user, $model)
    {
        if ($current_user->role($current_user->company)->id == 1) return true;
        $current_user_role = $current_user->role($model)->id;
        if ($current_user_role == 1) return true;
        elseif ($current_user_role > 2) return false;
        return $current_user_role < $user->role($model)->id;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $current_user
     * @param  \App\User  $user
     * @param  $model
     * @return mixed
     */
    public function memberDelete(User $current_user, User $user, $model)
    {
        if ($current_user->role($current_user->company)->id == 1) return true;
        $current_user_role = $current_user->role($model)->id;
        if ($current_user_role == 1) return true;
        elseif ($current_user_role > 2) return false;
        return $current_user_role < $user->role($model)->id;
    }

    /**
     * Determine whether the user can restore the project.
     *
     * @param  \App\User  $current_user
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $current_user, User $user)
    {
        return true;
    }
}
