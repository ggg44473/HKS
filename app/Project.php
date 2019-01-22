<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasObjectiveTrait;
use App\Traits\HasAvatarTrait;
use App\Interfaces\HasObjectiveInterface;

class Project extends Model implements HasObjectiveInterface
{
    use HasObjectiveTrait, HasAvatarTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'user_id', 'isdone'
    ];

    public function admin()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class);;
    }

    public function company()
    {
        return $this->admin->belongsTo(Company::class);
    }

    public function getOKrRoute()
    {
        return route('project.okr', $this->id);
    }

    public function getNotifiableUser()
    {
        return $this->admin;
    }
}
