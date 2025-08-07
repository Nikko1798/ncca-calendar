<?php

namespace App\Services;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Video;
class UserSettingsService
{
    public function uploadVideos($request){
        $request->validate([
            'picture' => 'nullable|file|mimes:mp4,mov,avi,webm|max:51200',
            'picture1' => 'nullable|file|mimes:mp4,mov,avi,webm|max:51200',
            'picture2' => 'nullable|file|mimes:mp4,mov,avi,webm|max:51200',
        ]);
        
        $paths = [];
        $counter=1;
        Video::query()->delete();
        //this is the name of the fields in front-end form
        foreach (['picture', 'picture1', 'picture2'] as $field) {
            
            if ($request->hasFile($field)) {
                
                DB::transaction(function () use ($request, $field, $counter){
                    $filename=Str::random(10) . '.' . $request->file($field)->getClientOriginalExtension();
                    $paths[$field] = $request->file($field)->move(public_path('videos'), $filename);
                    
                    $vid=Video::create([
                        'file_location'=>$filename,
                        'queue'=>$counter,
                    ]);
                });
            }
            $counter++;
        }

    }
}   
