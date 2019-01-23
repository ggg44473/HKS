<?php

namespace App\Http\Controllers;

use MaddHatter\LaravelFullCalendar\Facades\Calendar;
use App\Http\Requests\EventRequest;
use Illuminate\Http\Request;
use App\Event;
use App\Objective;

class EventController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function calendar()
    {
        return view('calendar.index');
    }

    public function index()
    {
        // $events = Event::all();
        // $event = [];
        // foreach ($events as $row) {
        //     $endDate = $row->finished_at . "24:00:00"; 
        //     $event[] = \Calendar::event(
        //         $row->title,
        //         true,
        //         new \DateTime($row->started_at),
        //         new \DateTime($row->finished_at),
        //         $row->id,
        //         [
        //             'color' => $row->color,
        //         ]
        //     );
        // }
        // $calendar = \Calendar::addEvents($event);
        $events = Event::select("id", "title", "started_at as start", "finished_at as end", "color")->get()->toArray();
        return response()->json($events);
    }

    public function objectives()
    {
        $events = Objective::select("id", "title", "started_at as start", "finished_at as end")->where('model_id', '=', '1')->get()->toArray();
        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $input['st_date'] = $input['st_date']." ".date("H:m:s",strtotime($input['st_time']));
        $input['fin_date'] = $input['fin_date']." ".date("H:m:s",strtotime($input['fin_time']));

        Event::create($input);
        return redirect('calendar.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $events = new Event;
        $events->title = $request->input('title');
        $events->color = $request->input('color');
        $events->started_at = $request->input('st_date');
        $events->finished_at = $request->input('fin_date');

        $events->save();

        return redirect('calendar')->with('success', 'Events Added');
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
