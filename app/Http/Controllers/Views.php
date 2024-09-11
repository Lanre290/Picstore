<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Views extends Controller
{
    public function  Events($event_id){
        $isExists = Events::where('id', $event_id)->count() > 0;
        
        if($isExists == false){
            return response()->json(['error' => 'Event does not exist.'], 404);
        }  
        else{
            $data = Events::where('id', $event_id)->get();
            return response()->json(['data' => $data], 200);
        }
    }
}
