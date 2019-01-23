<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [ //新增的欄位名稱
        'user_id',
        'title',
        'color',
        'started_at',
        'finished_at'
    ];
}
