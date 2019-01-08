<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $fillable = [
        'priority', 'color',
    ];
    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}
