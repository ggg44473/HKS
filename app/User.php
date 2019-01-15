<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravelista\Comments\Commenter;
use App\Traits\HasObjectiveTrait;

class User extends Authenticatable
{
    use Notifiable, Commenter, HasObjectiveTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'company_id', 'department_id', 'position', 'enable'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAvatar()
    {
        return $this->avatar? $this->avatar:'/img/icon/user/green.svg';
    }

    public function getOKrRoute(){
        return route('user.okr', $this->id);
    }
}
