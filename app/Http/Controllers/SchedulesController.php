<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

use App\Http\Models\Schedule;

use App\Http\Requests\CreateScheduleRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

use App\Services\ScheduleService;
class SchedulesController extends Controller
{
    //
    protected $scheduleService;
    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService=$scheduleService;
    }
    public function index()
    {
        $events=$this->scheduleService->storeEventsFromGoogleCalendar();
        return Inertia::render('Schedules/index', [
            'events'=>$events
        ]);
        
       
    }
    public function create(CreateScheduleRequest $request)
    {
        $sched=Auth::user()->events()->create([
            'start_date'=>$request['start_date'],
            'start_time'=>$request['start_time'],
            'end_date'=>$request['end_date'],
            'end_time'=>$request['end_time'],
            'title'=>$request['title'],
            'details'=>$request['details'],
        ]);
    }
    public function getSchedule(Request $request)
    {
        $sched=Auth::user()->events()
        ->where('start_date', '>=', $request->start_date)
        ->where('end_date', '<=', $request->end_date)
        ->get();
        return $sched;
    }
}
