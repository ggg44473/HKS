<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasObjectiveTrait;

class Department extends Model
{
    use HasObjectiveTrait;
    
    protected $fillable = [
        'name', 'description', 'parent_department_id', 'company_id', 'image', 'user_id', 
    ];

    public function company_id()
    {
        return $this->belongsTo(Company::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }
}
