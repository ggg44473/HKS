<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravelista\Comments\Commenter;
use App\Traits\HasObjectiveTrait;
use App\Traits\HasAvatarTrait;

class User extends Authenticatable
{
    use Notifiable, Commenter, HasObjectiveTrait, HasAvatarTrait;

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

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function department()
    {
        return $this->hasOne(Department::class);
    }
}
