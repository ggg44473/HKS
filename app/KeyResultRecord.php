<?php

namespace App;

use Carbon\Carbon;
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
        return $this->belongsTo('App\KeyResult', 'key_results_id');
    }

    public function accomplishRate()
    {
        return $this->keyresult()->getResults()->historyAcpRate($this->history_value);
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->toDateString();
    }

}
