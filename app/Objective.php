<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    // protected $table = "objectives"; // $table預設是複數
    // public $timestamps = false; //若要取消時間戳記
    protected $fillable = [ //新增的欄位名稱
        'user_id',
        'title',
        'started_at',
        'finished_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function keyresults()
    {
        return $this->hasMany(KeyResult::class);
    }

    public function actions()
    {
        return $this->hasManyThrough('App\Action', 'App\KeyResult', 'objective_id', 'related_kr');
    }
}
