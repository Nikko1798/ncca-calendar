<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use Inertia\Response;

use App\Http\Models\Schedule;

use App\Http\Requests\CreateScheduleRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use App\Services\EventService;

use App\Models\Video;
class EventsController extends Controller
{
    //
    protected $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService=$eventService;
    }
    public function index($floor){
        $events=$this->eventService->storeEventsFromGoogleCalendar();
        $videos=Video::where('floor', $floor)->get();
        return Inertia::render('events/Index', [
            'events'=>$events,
            'videos'=>$videos
        ]);
        
        // return $events;
    }
    public function getEvents(){
        $events=$this->eventService->storeEventsFromGoogleCalendar();
        return $events;
    }
    public function CalendarView(){
        $events=$this->eventService->storeEventsFromGoogleCalendar();
       
        return Inertia::render('events/CalendarView', [
            'events'=>$events,
        ]);
    }
   
}
