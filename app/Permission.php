<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'model_type', 'model_id', 'role_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function model() 
    {
        return $this->morphTo();
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
