<?php

namespace App\Http\Controllers;

use MaddHatter\LaravelFullCalendar\Facades\Calendar;
use Illuminate\Http\Request;
use App\Http\Requests\ActivityRequest;
use App\User;
use App\Action;
use App\Activity;
use App\Objective;
use Carbon\Carbon;

class ActivityController extends Controller
{
    public function calendar()
    {
        return view('calendar.index');
    }

    public function index(User $user)
    {
        $activities = Activity::select("id", "title", "started_at as start", "finished_at as end", "color")
            ->where('user_id', '=', $user->id)->get();

        $action = array();
        $actions = array();
        foreach ($activities as $activity) {
            $action = array(
                'id' => $activity->id, 'title' => $activity->title, 'school' => '3',
                'start' => $activity->start, 'color' => $activity->color,
                'end' => $activity->end, 'url' => route('calendar.show', $activity->id)
            );

            array_push($actions, $action);
        }
        return response()->json($actions);
    }

    public function objectives(User $user)
    {
        $action = array();
        $actions = array();
        $colors = ['App\User' => '#e87461', 'App\Project' => '#e0c879', 'App\Company' => '#0072e3', 'App\Department' => '#00aeae'];
        $blade = ['App\User' => '個人目標', 'App\Project' => '個人專案', 'App\Company' => '公司目標', 'App\Department' => '部門目標'];
        $activities = Objective::select("id", "title", "started_at as start", "finished_at as end", "model_type")
            ->where('model_id', '=', $user->id)->get();
        foreach ($activities as $activity) {
            $action = array(
                'id' => $activity->id, 'title' => '[ ' . $blade[$activity->model_type] . ' ] ' . $activity->title,
                'start' => $activity->start, 'end' => $activity->end, 'color' => $colors[$activity->model_type], 'school' => '1'
            );
            array_push($actions, $action);
        }
        return response()->json($actions);
    }

    public function actions(User $user)
    {
        $action = array();
        $actions = array();
        $colors = ['#ea0000', '#ae8f00', '#0072e3', '#00aeae', '#6c6c6c'];
        $blade = ['Immediate', 'Urgent', 'Normal', 'Low', 'Postponed'];
        $activities = Action::select("id", "title", "finished_at as start", "priority")
            ->where('user_id', '=', $user->id)->get();

        foreach ($activities as $activity) {
            $action = array(
                'id' => $activity->id, 'title' => '[ ' . $blade[$activity->priority - 1] . ' ] ' . $activity->title,
                'start' => $activity->start, 'color' => $colors[$activity->priority - 1],
                'url' => route('actions.show', $activity->id), 'school' => '2'
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
    public function show(Activity $activity)
    {
        // $activity = Activity::where('id', '=', $activity->id)->get();
        $data = [
            'activity' => $activity,
        ];
        return view('calendar.show', $data);
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
    public function update(ActivityRequest $request, Activity $activity)
    {
        $actAttr['title'] = $request->input('title');
        $actAttr['color'] = $request->input('color');
        $actAttr['started_at'] = $request->input('st_date') . " " . date("H:m:s", strtotime($request->input('st_time')));
        if ($request->input('fin_date'))
            $actAttr['finished_at'] = $request->input('fin_date') . " " . date("H:m:s", strtotime($request->input('fin_time')));
        $activity->update($actAttr);

        return redirect('calendar');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect('calendar');
    }
}
