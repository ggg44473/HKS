<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;
use App\Policies\UserPolicy;
use App\Project;
use App\Policies\ProjectPolicy;
use App\Company;
use App\Policies\CompanyPolicy;
use App\Department;
use App\Policies\DepartmentPolicy;
use App\Action;
use App\Policies\ActionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Company::class => CompanyPolicy ::class,
        Department::class => DepartmentPolicy::class,
        Project::class => ProjectPolicy::class,
        Action::class => ActionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::resource('companys', 'CompanyPolicy');
        Gate::resource('departments', 'DepartmentPolicy');
        Gate::resource('projects', 'ProjectPolicy');
        Gate::resource('users', 'UserPolicy');
        Gate::resource('actions', 'ActionPolicy');
    }
}
