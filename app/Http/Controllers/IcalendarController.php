<?php

namespace App\Http\Controllers;

use App\Action;
use App\Activity;
use App\Objective;
use Illuminate\Http\Request;

class IcalendarController extends Controller
{
    /**
     * 要登入才能用的Controller
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getEventsICalObject()
    {
        $events = Activity::where('user_id', '=', auth()->user()->id)->get();
        $eventsAction = Action::where('user_id', '=', auth()->user()->id)->get();
        $eventsObjective = Objective::where('model_id', '=', auth()->user()->id)->where('model_type', '=', 'App\User')->get();
        define('ICAL_FORMAT', 'Ymd\THis\Z');

        $icalObject = "BEGIN:VCALENDAR
        VERSION:2.0
        METHOD:PUBLISH
        PRODID:-//Charles Oduk//Tech Events//EN\n";
       
        // loop over events
        foreach ($events as $event) {
            $icalObject .=
                "BEGIN:VEVENT
            DTSTART:" . date(ICAL_FORMAT, strtotime($event->started_at)) . "
            DTEND:" . date(ICAL_FORMAT, strtotime($event->finished_at)) . "
            DTSTAMP:" . date(ICAL_FORMAT, strtotime($event->created_at)) . "
            SUMMARY:$event->title
            UID:$event->id
            LAST-MODIFIED:" . date(ICAL_FORMAT, strtotime($event->updated_at)) . "
            END:VEVENT\n";
        }
        foreach ($eventsAction as $event) {
            $icalObject .=
                "BEGIN:VEVENT
            DTSTART:" . date(ICAL_FORMAT, strtotime($event->started_at)) . "
            DTEND:" . date(ICAL_FORMAT, strtotime($event->finished_at)) . "
            DTSTAMP:" . date(ICAL_FORMAT, strtotime($event->created_at)) . "
            SUMMARY:$event->title
            UID:$event->id
            LAST-MODIFIED:" . date(ICAL_FORMAT, strtotime($event->updated_at)) . "
            END:VEVENT\n";
        }
        foreach ($eventsObjective as $event) {
            $icalObject .=
                "BEGIN:VEVENT
            DTSTART:" . date(ICAL_FORMAT, strtotime($event->started_at)) . "
            DTEND:" . date(ICAL_FORMAT, strtotime($event->finished_at)) . "
            DTSTAMP:" . date(ICAL_FORMAT, strtotime($event->created_at)) . "
            SUMMARY:$event->title
            UID:$event->id
            LAST-MODIFIED:" . date(ICAL_FORMAT, strtotime($event->updated_at)) . "
            END:VEVENT\n";
        }
 
        // close calendar
        $icalObject .= "END:VCALENDAR";
 
        // Set the headers
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');

        $icalObject = str_replace(' ', '', $icalObject);

        echo $icalObject;
    }
}
