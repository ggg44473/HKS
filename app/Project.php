<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasObjectiveTrait;
use App\Traits\HasAvatarTrait;
use App\Interfaces\HasObjectiveInterface;
use App\Traits\HasInvitationTrait;
use App\Traits\HasFollowTrait;
use App\Interfaces\HasInvitationInterface;
use App\Traits\HasPermissionTrait;
use App\Traits\HasMemberTrait;

class Project extends Model implements HasObjectiveInterface, HasInvitationInterface
{
    use HasObjectiveTrait, HasAvatarTrait, HasInvitationTrait, HasFollowTrait, HasPermissionTrait, HasMemberTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'isdone', 'company_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getOKrRoute()
    {
        return route('project.okr', $this->id);
    }

    public function getNotifiableUser()
    {
        return $this->users;
    }

    public function getInviteUrl($userId)
    {
        return route('project');
    }

    public function delete()
    {
        $this->users()->detach();
        $this->invitation()->delete();
        $this->permissions()->delete();
        return parent::delete();
    }
}
