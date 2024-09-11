<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Images;
use App\Models\Events;

class UserActions extends Controller
{
    public function uploadImage(Request $request){
        $request->validate([
            'id' => 'integer|required',
            'files.*' => 'file|mimes:jpeg,png,jpg,gif|required'
        ]);

        $event_id = $request->id;

        $uploadedFiles = $request->file('files');

        $event_exists = Events::where('id', $event_id)->count() > 0;

        if($event_exists == true){
            if($uploadedFiles){
                foreach ($uploadedFiles as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('img/post_files'), $fileName);
        
                    Images::create([
                        'image_path' => 'img/events/'.$event_id.'/'.$fileName,
                        'event_id' => $event_id
                    ]);
                }

                return response()->json([
                    'url' => route('post', ['id' => $post_id])
                ]);
            }
            else{
                return response()->json(['error' => 'Error processing data.'], 500);
            }
        }   
        else{
            return response()->jso(['error' => 'Event does not exist.'], 500);
        }
    }

    public function resetLink(Request $request){
        $request->validate([
            'id' => 'integer|required',
        ]);

        $event_id = $request->id;
    }
}
