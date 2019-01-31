<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasObjectiveTrait;
use App\Traits\HasAvatarTrait;
use App\Interfaces\HasObjectiveInterface;
use App\Traits\HasFollowTrait;
use App\Traits\HasPermissionTrait;

class Department extends Model implements HasObjectiveInterface
{
    use HasObjectiveTrait, HasAvatarTrait, HasFollowTrait, HasPermissionTrait;

    protected $fillable = [
        'name', 'description', 'parent_department_id', 'company_id', 'user_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function users()
    {
        return $this->hasMany('App\User', 'department_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function getOKrRoute()
    {
        return route('department.okr', $this->id);
    }

    /**
     * Returns all departments that this department is the parent of.
     */
    public function children()
    {
        return $this->hasMany(Department::class, 'parent_department_id');
    }

    /**
     * Returns the department to which this department belongs to.
     */
    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_department_id');
    }

    public function getNotifiableUser()
    {
        foreach ($this->permissions->where('role_id', '<=', '2') as $index => $permission) {
            $users = [$index => $permission->user];
        }
        return $users;
    }
}
