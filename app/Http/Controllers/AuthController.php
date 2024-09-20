<?php

namespace App\Http\Controllers;

use App\Http\Controllers\userActions;


use App\Mail\OTPMail;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\ForgottenPasswordModel;
use App\Http\Controllers\AuthController;


class AuthController extends Controller
{

    protected $userActions;
    public function __construct(Views $userActions){
        // Dependency inject for userActions controller
        $this->userActions = $userActions;
    }
    
    public function signup(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'pwd' => 'required|string|max:255'
        ]);

        $name = $request->name;
        $email = $request->email;
        $pwd = $request->pwd;

        $emailExists = DB::table('user')
                        ->where('email',$email)
                        ->count();

        if(empty($name) || empty($email) || empty($pwd)){
            $data = 'Error processing data.';
            return response(['error' => 'Error processing data.','data' => ''], 422);
        }
        if($emailExists > 0){
            $data = 'Email already exists.';
            return response()->json(['error' => 'Email already exists.','data' => ''], 409 );
        }

        session(['user_details' => [
            'name' => $name,
            'email' => $email,
            'pwd' => $pwd
        ]]);

        $this->OTP($email);

        return response()->json(['data' => 'ok'], 200);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string',
            'pwd' => 'required|string'
        ]);

        

        $email = $request->email;
        $pwd = $request->pwd;

        if(empty($email) || empty($pwd)){
            return response()->json(['error' => 'Error processing data.','data' => ''], 422);
        }
        else{
            $emailExists = Users::where('email', $email)->count();
            if($emailExists < 1){
                return response()->json(['error' => 'Email does not exist.', 'data' => ''], 404);
            }
            else{
                $Hashedpwd = Users::where('email', $email)->pluck('pwd')->first();
                
                if(Hash::check($pwd, $Hashedpwd)){
                    $userData = Users::where('email', $email)->select('id','email','name')->first();
                    session(['user' => $userData]);
                    return response(['data' => true], 200);
                }
                else{
                    return response(['error' => 'Incorrect password.', 'data' => ''], 404);
                }
            }
        }
    }

    public function OTP($email = ''){
        if($email == ''){
            $email = session('user_details')['email'];
        }
        $data = session('user_details');

        $result = Mail::to($email)->send(new OTPMail($data));

        if($result){
            return response()->json(['data' => true], 200);
        }
        else{
            return response()->json(['data' => false, 'error' => 'Error sending mail.'], 500);
        }
    }

    public function verifyOTP(Request $request){
        $request->validate([
            'token' => 'required',
        ]);  

        $token = $request->token;
        if(Hash::check($token, session('user_details')['otp'])){
            $details = session('user_details');
            $user = Users::create($details);
            $email = $user->email;
            $new_pwd = Hash::make($user->pwd);
            Users::where('email', $email)->update([
                'pwd' => $new_pwd
            ]);
            session(['user_details' => null]);
            session(['user' => $user]);
            return response()->json(['response' => 'ok', 'user_data' => $details], 200);
        }
        else{
            return response()->json(['error' => 'incorrect OTP Entered.'], 400);
        }  
    }


    public function forgotPassword(Request $request){
        $request->validate([
            'email' => 'string|required',
        ]); 

        $email = $request->email;


        if(empty($email)){
            return response()->json(['error' => 'Unexpected response.'], 500);
        }
        else{
            $data = Users::where('email', $email)->first();
            $token = $this->userActions->generateLink();
            $data['link'] = $token;
            
            ForgottenPasswordModel::create([
                'email' => $email,
                'token' => $token,
                'time' => time() + (60 * 60)
            ]);
            $result = Mail::to($email)->send(new forgotPasswordMail($data));
        }
    }

    public function resetPassword(Request $request){
        $request->validate([
            'pwd' => 'string|required',
        ]);

        $pwd = $request->pwd;

        if(empty($pwd)){
            return response()->json(['error' => 'Unexpected response.'], 500);
        }
        else{

            $response = Users::where('id', $id)->update([
                'pwd' => Hash::make($pwd)
            ]);
        }
    }


    public function logout(Request $request){

        session()->regenerateToken();

        session()->flush();
    }

}