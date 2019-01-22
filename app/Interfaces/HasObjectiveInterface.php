<?php

namespace App\Interfaces;

use App\Objective;
use Illuminate\Http\Request;

interface HasObjectiveInterface
{
    /**
     * Returns all objectives for this model.
     */
    public function objectives();

    public function addObjective(Request $request);

    public function hasObjectives();

    public function getObjectivesBuilder(Request $request);

    public function getPages(Request $request);

    public function getOkrsWithPage(Request $request);

    public function getOKrRoute();

    public function getNotifiableUser();
}
