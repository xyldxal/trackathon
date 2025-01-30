<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarEvent;

class CalendarController extends Controller
{
    public function index(){
        $events = CalendarEvent::where('user_id', auth()->id())
            ->with('card')
            ->get()
            ->map(function($event){
                return [
                    'title' => $event->title,
                    'start' => $event->event_date,
                    'url' => route('cards.show', $event->card)
                ];
            }
        );

        return view('calendar.index', compact('events'));
    }
}
