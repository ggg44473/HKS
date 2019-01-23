<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasObjectiveTrait;
use App\Traits\HasAvatarTrait;
use App\Interfaces\HasObjectiveInterface;
use App\Traits\HasInvitationTrait;

class Company extends Model implements HasObjectiveInterface
{
    use HasObjectiveTrait, HasAvatarTrait, HasInvitationTrait;

    protected $fillable = [
        'name', 'description', 'user_id',
    ];

    public function users()
    {
        return $this->hasMany('App\User', 'company_id');
    }

    public function departments()
    {
        return $this->hasMany('App\Department', 'company_id');
    }

    public function getOKrRoute()
    {
        return route('company.okr');
    }

    public function getNotifiableUser()
    {
        return $this->users;
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }
}
