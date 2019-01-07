<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = [
        'user_id',
        'related_kr',
        'assignee',
        'priority',
        'isdone',
        'title',
        'content',
        'started_at',
        'finished_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function keyreult()
    {
        return $this->belongsTo('App\KeyResult', 'related_kr');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }
    // public function getFinishedAtAttribute($date)
    // {
    //     $time[]=explode("-",Carbon::parse($date)->toDateString());

    //     return $time[0][1]."/".$time[0][2];
    // }

}
