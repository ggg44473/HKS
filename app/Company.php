<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'description', 'owner'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
