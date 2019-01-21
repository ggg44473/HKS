<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasObjectiveTrait;
use App\Traits\HasAvatarTrait;

class Company extends Model
{
    use HasObjectiveTrait, HasAvatarTrait;

    protected $fillable = [
        'name', 'description', 'user_id',
    ];

    public function users()
    {
        return $this->hasMany('App\User','company_id');
    }

    public function departments()
    {
        return $this->hasMany('App\Department','company_id');
    }

    public function getOKrRoute()
    {
        return route('company.okr');
    }
}
