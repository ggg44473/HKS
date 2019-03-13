<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ObjectiveRequest;
use App\Http\Requests\KeyResultRequest;
use App\User;
use App\Objective;
use App\KeyResult;
use App\KeyResultRecord;

class OkrController extends Controller
{
    /**
     * 要登入才能用的Controller
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(Objective $objective)
    {
        $this->authorize('storeObjective', $objective->model);

        $user = User::where('id', '=', auth()->user()->id)->first();        
        //使用者的krs
        $keyresults = KeyResult::where('objective_id', '=', $objective->id)->get();
        $data = [
            'owner' => $user,
            'objective' => $objective,
            'keyresults' => $keyresults,
        ];
        return view('okrs.edit', $data);
    }

    public function update(Request $request, Objective $objective)
    {
        $this->authorize('storeObjective', $objective->model);

        $objAttr = [];
        if($request->exists('obj_title')) $objAttr['title'] = $request->input('obj_title');
        if($request->exists('st_date')) $objAttr['started_at'] = $request->input('st_date');
        if($request->exists('fin_date')) $objAttr['finished_at'] = $request->input('fin_date');
        $objective->update($objAttr);

        $keyresults = KeyResult::where('objective_id', '=', $objective->id)->get();
        foreach ($keyresults as $keyresult) {
            if($request->exists('krs_title' . $keyresult->id)){
                $krAttr['title'] = $request->input('krs_title' . $keyresult->id);
                $krAttr['confidence'] = $request->input('krs_conf' . $keyresult->id);
                $krAttr['initial_value'] = $request->input('krs_init' . $keyresult->id);
                $krAttr['target_value'] = $request->input('krs_tar' . $keyresult->id);
                $krAttr['current_value'] = $request->input('krs_now' . $keyresult->id);
                $krAttr['weight'] = $request->input('krs_weight' . $keyresult->id);
                // if( $krAttr['current_value']!=$keyresult->current_value ||$krAttr['confidence']!=$keyresult->confidence){
                // $oldAttr['key_results_id'] = $keyresult->id;
                // $oldAttr['history_confidence'] = $keyresult->confidence;
                // $oldAttr['history_value'] = $keyresult->current_value;
                // KeyResultRecord::create($oldAttr);
                $keyresult->update($krAttr);
            }
        }

        return redirect()->to($objective->model->getOKrRoute() . '#oid-' . $objective->id);
    }
}
