<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Images;
use App\Models\Events;

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

    public function login(){
        return view('auth.login');
    }

    public function signup(){
        return view('auth.signup');
    }

    public function otp(){
        if(null != session('user_details')){
            return view('auth.otp-ver');
        }
        else{
            return view('404.index');
        }
    }

    public function dashboard(){
        return view('index.dashboard');
    }

    public function event($event_id){
        $isExists = Events::where('id', $event_id)->count() > 0;

        // if($isExists == false){
        //     return view('404.index');
        // }
        // else{  
        //     $event = Events::where('id', $event_id)->first();
        //     $images = Images::where('event_id', $event->id)->get();

        //     return view('index.event')->with((['data' => $event, 'images' => $images]));
        // }

        return view('index.event');
    }
}
