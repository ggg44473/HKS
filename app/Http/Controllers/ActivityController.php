<?php

namespace App\Http\Controllers;

use MaddHatter\LaravelFullCalendar\Facades\Calendar;
use Illuminate\Http\Request;
use App\Http\Requests\ActivityRequest;
use App\User;
use App\Action;
use App\Activity;
use App\Objective;

class ActivityController extends Controller
{
    public function calendar()
    {
        return view('calendar.index');
    }

    public function index(User $user)
    {
        $activities = Activity::select("id", "title", "started_at as start", "finished_at as end", "color")
            ->where('user_id', '=', $user->id)->get()->toArray();
        return response()->json($activities);
    }

    public function objectives(User $user)
    {
        $activities = Objective::select("id", "title", "started_at as start", "finished_at as end")
            ->where('model_id', '=', $user->id)->where('model_type', '=', 'App\User')->get()->toArray();
        return response()->json($activities);
    }

    public function actions(User $user)
    {
        $action = array();
        $actions = array();
        $colors = ['#ea0000', '#ae8f00', '#0072e3', '#00aeae', '#6c6c6c'];
        $blade = ['Immediate', 'Urgent', 'Normal', 'Low', 'Postponed'];
        $activities = Action::select("id", "title", "finished_at as start", "priority")
            ->where('assignee', '=', $user->id)->get();
            
        foreach ($activities as $activity) {
            $action = array(
                'id' => $activity->id, 'title' => '[ '.$blade[$activity->priority - 1].' ] '.$activity->title,
                'start' => $activity->start, 'color' => $colors[$activity->priority - 1] ,
                'url' => route('actions.show',$activity->id)
            );
            array_push($actions, $action);
        }
        return response()->json($actions);
    }

    public function create(ActivityRequest $request, User $user)
    {
        $activities = new Activity;
        $activities->user_id = $user->id;
        $activities->title = $request->input('title');
        $activities->color = $request->input('color');
        $activities->started_at = $request->input('st_date') . " " . date("H:m:s", strtotime($request->input('st_time')));
        if ($request->input('fin_date'))
            $activities->finished_at = $request->input('fin_date') . " " . date("H:m:s", strtotime($request->input('fin_time')));
        $activities->save();
        return redirect('calendar');
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
