<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAvatarTrait;

class Activity extends Model
{
    use HasAvatarTrait;

    protected $fillable = [ //新增的欄位名稱
        'user_id',
        'title',
        'color',
        'started_at',
        'finished_at'
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
