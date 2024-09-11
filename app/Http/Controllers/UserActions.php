<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Images;
use App\Models\Events;
use Illuminate\Support\Facades\File;

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
                $rel_path = public_path('img/events/'.$event_id.'/');

                if(!File::exists($rel_path)){
                    File::makeDirectory($rel_path);
                }

                foreach ($uploadedFiles as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($rel_path, $fileName);
        
                    Images::create([
                        'image_path' => $rel_path.$fileName,
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
            return response()->json(['error' => 'Event does not exist.'], 404);
        }
    }

    public function resetLink(Request $request){
        $request->validate([
            'id' => 'integer|required',
        ]);

        $event_id = $request->id;
        $new_number = '';
        $isExists = Events::where('id', $event_id)->count() > 0;

        if($isExists == false){
            return response()->json(['error' => 'Event does not exist.'], 404);
        }   

        $new_link = $this->generateLink($new_number);

        Events::where('id', $event_id)->update([
            'event_link' => $new_link,
        ]);

        return response()->json(['new_link' => $new_link, 'event_id' => $event_id], 200);
    }

    public function createEvent(Request $request){
        $request->validate([
            'title' => 'string|required',
        ]);

        $title = $request->title;
        $link = $this->generateLink();
        $user_id = session('user')->id;

        $event = Events::create([
            'user_id' => $user_id,
            'event_link' => $link,
            'title' => $title
        ]);


        if($event){
            return response()->json(['data' => $event], 200);
        }
        else{
            return response()->json(['error' => 'Error processing data.'], 500);
        }

       
    }

    private function generateLink($number = ''){
        $number_stored = $number;
        while (strlen($number) < 10) {
            $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

            $rand_1 = mt_rand(0 ,1);
            $rand_2= null;

            if($rand_1){
                $rand_2 = rand(0, 25);
                $number = $number.(string) $letters[$rand_2];
            }
            else{
                $rand_2 = rand(0, 9);
                $number = $number. (string) $rand_2;
            }
        }

        $isExists = Events::where('id', $event_id)->count() > 0;
        if($isExists == true){
            return $this->generateLink($number_stored);
        }
        else{
            return '/event'.'/'.$number;
        }
    }
}
