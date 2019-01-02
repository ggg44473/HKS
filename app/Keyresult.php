<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyresult extends Model
{
    protected $fillable = [ //新增的欄位名稱
        'owner',
        'title',
        'confidence',
        'initial',
        'target',
        'now',
        'weight',
        'average',
    ];

    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }
}
