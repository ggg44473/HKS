<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasObjectiveTrait;

class Department extends Model
{
    use HasObjectiveTrait;
    
    protected $fillable = [
        'name', 'description', 'parent_department_id', 'company_id', 'avatar', 'user_id', 
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function getAvatar()
    {
        return $this->avatar? $this->avatar: '/img/icon/building/g.svg';
    }

    public function getOKrRoute(){
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
        return $this->belongsTo(Department::class,'parent_department_id');
    }
}
