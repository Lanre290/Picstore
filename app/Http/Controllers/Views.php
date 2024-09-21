<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Redirect;
use App\Models\Images;
use App\Models\Events;
use App\Models\ForgottenPasswordModel;

class Views extends Controller
{
    public function  Events($event_link){
        $isExists = Events::where('link', $event_link)->count() > 0;
        
        if($isExists == false){
            return response()->json(['error' => 'Event does not exist.'], 404);
        }  
        else{
            $data = Events::where('id', $event_link)->get();
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
            return redirect('/dashboard');
        }
    }

    public function dashboard(){
        if (null != session('user')) {
            $events = Events::where('user_id', session('user')->id)->orderBy('timestamp', 'DESC')->get();
            $count = Events::where('user_id', session('user')->id)->count();

            return view('index.dashboard', ['events' => $events, 'count' => $count]);
        }
        else{
            return redirect('/login');
        }
    }

    public function event($event_link){
        if(null != session('user')){
            $isExists = Events::where('event_link', $event_link)->count() > 0;
            if($isExists == false){
                return view('404.index');
            }
            else{  
                $event = Events::where('event_link', $event_link)->first();
                $images = Images::where('event_id', $event->id)->get();

                return view('index.event')->with((['data' => $event, 'images' => $images]));
            }
        }
        else{
            return redirect('/login');
        }
    }

    public function forgotPassword($id){
        $isExists = ForgottenPasswordModel::where('id', $id)->count() > 0;
        $notExpired = time() < ForgottenPasswordModel::where('id', $id)->pluck('time')->first();
        $notExpired2 = ForgottenPasswordModel::where('id', $id)->pluck('status')[0] != 'expired';

        
        if($isExists == true && $notExpired == true && $notExpired2 == true){
            $response = ForgottenPasswordModel::where('id', $id)->update([
                'status' => 'expired'
            ]);
            return view('auth.reset-password-view');
        }
        else{
            return view('404.index');
        }
    }

    public function passwordLinkSent(){
        return view('auth.sent-password-link');
    }
}
