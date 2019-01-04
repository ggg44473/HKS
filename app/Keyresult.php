<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeyResult extends Model
{
    protected $fillable = [
        'objective_id',
        'title',
        'confidence',
        'initial_value',
        'target_value',
        'current_value',
        'weight',
    ];

    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }
    public function  keyResultRecords()
    {
        return $this->hasMany(KeyResultRecord::class);
    }

    public function accomplishRate()
    {
        if($this->target_value == $this->initial_value) 
            return 0;
        else if ($this->target_value > $this->initial_value)
            return round(($this->current_value - $this->initial_value) * 100 / ($this->target_value - $this->initial_value), 0);
        else if ($this->target_value < $this->initial_value)
            return round(($this->initial_value - $this->current_value) * 100 / ($this->initial_value - $this->target_value), 0);
    }
}
