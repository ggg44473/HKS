<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Objective;

class ObjectiveController extends Controller
{
    /**
     * 要登入才能用的Controller
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  Objective $objective
     * @return \Illuminate\Http\Response
     */
    public function destroy(Objective $objective)
    {
        $this->authorize('storeObjective', $objective->model);       
        $objective->delete();
        return redirect()->back();
    }

    public function getArray(Objective $objective)
    {
        return $objective->getRelatedKrRecord();
    }
}
