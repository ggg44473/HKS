<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Objective;

class ObjectiveController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  Objective $objective
     * @return \Illuminate\Http\Response
     */
    public function destroy(Objective $objective)
    {
        $objective->delete();
        return redirect()->back();
    }
}
