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

    public function accomplishRate()
    {
        // TODO: 達成率有可能遞增或遞減，也可能想遞增但遞減了
        return abs(round(($this->current_value - $this->initial_value) * 100 / ($this->target_value - $this->initial_value), 0));
    }
}
