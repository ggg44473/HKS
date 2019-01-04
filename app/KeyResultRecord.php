<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeyResultRecord extends Model
{
    protected $fillable = [
        'key_results_id',
        'history_value',
        'history_confidence',
    ];

    public function keyresult()
    {
        return $this->belongsTo(keyresult::class);
    }
}
