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
        'title', 'description', 'user_id'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function getOKrRoute()
    {
        return route('department.okr', $this->id);
    }
}
