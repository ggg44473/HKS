<?php

namespace App\Traits;

use App\Objective;

trait HasObjectiveTrait
{
    /**
     * Returns all objectives for this model.
     */
    public function objectives()
    {
        return $this->morphMany(Objective::class, 'model');
    }

    public function addObjective($request)
    {
        $attr['model_id'] = $this->id;
        $attr['model_type'] = get_class($this);
        $attr['title'] = $request->input('obj_title');
        $attr['started_at'] = $request->input('st_date');
        $attr['finished_at'] = $request->input('fin_date');

        Objective::create($attr);
    }

    public function hasObjectives()
    {
        return count($this->objectives()->get()) ? true : false;
    }

    public function updateObjective()
    {

    }

    public function deleteObjective()
    {

    }
}
