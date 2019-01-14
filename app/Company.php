<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasObjectiveTrait;

class Company extends Model
{
    use HasObjectiveTrait;

    protected $fillable = [
        'name', 'description', 'user_id', 'avatar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
