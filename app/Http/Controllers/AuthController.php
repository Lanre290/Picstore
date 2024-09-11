<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    
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
            'pwd' => Hash::make($pwd)
        ]]);

        $this->OTP($email);

        return response()->json(['data' => 'ok'], 200);
    }

    public function login(Request $request){
        try {
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
        } catch (\Throwable $th) {
            return response(['error' => $th]);
        }
    }

    public function OTP(){
        $email = 'lanre2967@gmail.com';
        $data = [
            'name' => 'Ashiru Sheriff',
            'email' => 'lanre2967@gmail',
            'pwd' => 'fd328u908'
        ];

        Mail::to($email)->send(new OTPMail($data));
    }

    public function verifyOTP(Request $request){
        $request->validate([
            'token' => 'required|integer',
        ]);  


        Users::create(session('user_details'));
    }



    public function logout(Request $request){

        session()->regenerateToken();

        session()->flush();
    }

}