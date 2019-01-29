<?php

namespace App\Policies;

use App\User;
use App\Company;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Permission;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function view(User $user, Company $company)
    {
        return $company->permissions->where('user_id', $user->id)->first();
    }

    /**
     * Determine whether the user can create companies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->company == null;
    }

    /**
     * Determine whether the user can update the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function update(User $user, Company $company)
    {
        return $user->role($company)->id <= 2;
    }

    /**
     * Determine whether the user can delete the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function delete(User $user, Company $company)
    {
        return $user->role($company)->id <= 1;
    }

    /**
     * Determine whether the user can memberSetting the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function memberSetting(User $user, Company $company)
    {
        return $user->role($company)->id <= 2;
    }

    /**
     * Determine whether the user can store Objective for the project.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function storeObjective(User $user, Company $company)
    {
        return $user->role($company)->id <= 3;
    }

    /**
     * Determine whether the user can restore the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function restore(User $user, Company $company)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function forceDelete(User $user, Company $company)
    {
        //
    }
}
