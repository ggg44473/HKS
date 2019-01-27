<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravelista\Comments\Commenter;
use App\Traits\HasObjectiveTrait;
use App\Traits\HasAvatarTrait;
use App\Interfaces\HasObjectiveInterface;
use App\Traits\HasFollowTrait;

class User extends Authenticatable implements HasObjectiveInterface
{
    use Notifiable, Commenter, HasObjectiveTrait, HasAvatarTrait, HasFollowTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'company_id', 'department_id', 'position', 'enable'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getOKrRoute()
    {
        return route('user.okr', $this->id);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);;
    }

    public function actions()
    {
        return $this->hasMany('App\Action','user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getNotifiableUser()
    {
        return $this;
    }

    public function invitation()
    {
        return $this->hasMany(Invitation::class);
    }

    public function follow()
    {
        return $this->hasMany(Follow::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
