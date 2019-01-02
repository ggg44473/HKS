<?php

namespace App;

use App\Keyresult;
use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    // protected $table = "objectives"; //指定資料表名稱(默認是複數型，所以可不打)
    // public $timestamps = false; //若要取消時間戳記
    protected $fillable = [ //新增的欄位名稱
        'owner',
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
        return $this->hasMany(Keyresult::class);
    }

    // public static function boot() {
    //     echo 'rrtt';
    //     parent::boot();
    //     static::deleting(function($objective) { // before delete() method call this
    //          $keyresults = $objective->keyresults();
    //         //  dd($keyresults);
    //          foreach($keyresults as $keyresult){
    //             $keyresult->delete();
    //          }
    //          // do the rest of the cleanup...
    //     });
    // }

}
