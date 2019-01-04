<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryRate extends Model
{
    protected $fillable = [
        'key_results_id',
        'current_value',
        'confidence',
    ];

    public function keyresult()
    {
        return $this->belongsTo(keyresult::class);
    }

}
