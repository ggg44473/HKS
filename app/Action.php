<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravelista\Comments\Commentable;

class Action extends Model
{

    use Commentable;

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

    public function assignee()
    {
        return $this->belongsTo('App\User', 'assignee');
    }

    public function keyresult()
    {
        return $this->belongsTo('App\KeyResult', 'related_kr');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }

    public function priority()
    {
        return $this->belongsTo('App\Priority', 'priority');
    }
    // public function getFinishedAtAttribute($date)
    // {
    //     $time[]=explode("-",Carbon::parse($date)->toDateString());

    //     return $time[0][1]."/".$time[0][2];
    // }

}
