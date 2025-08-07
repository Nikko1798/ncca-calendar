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

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Video;

class VideoController extends Controller
{
    //
    public function index(){
        $vids=Video::all();
        return Inertia::render('Videos/index', [
            'videos' => $vids
        ]);
    }
    public function insert(Request $request){
        $request->validate([
            'media' => 'nullable|file|mimes:mp4,mov,avi,webm,png,jpg,jpeg|max:51200',
            'floor' => 'nullable',
            'queue' => 'nullable',
        ]);
        
            
        if ($request->hasFile('media')) {
            
            DB::transaction(function () use ($request){
                $filename=Str::random(10) . '.' . 
                $request->file('media')->getClientOriginalExtension();
                $request->file('media')->move(public_path('medias'), $filename);
                
                $vid=Video::create([
                    'file_location'=>$filename,
                    'queue'=>$request['queue'],
                    'floor' => $request['floor']
                ]);
            });
        }
        return redirect()->route('videos-view.index')->with('success', 'Video inserted successfully!');

        
    }
}
