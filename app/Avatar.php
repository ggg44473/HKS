<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $fillable = [
        'model_type', 'model_id', 'path'
    ];

    public function model() : MorphTo
    {
        return $this->morphTo();
    }
}
