<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserActions;
use App\Http\Controllers\Views;
use App\Http\Controllers\FallbackController;
use Illuminate\Support\Facades\Mail;



Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/forgot-password/{id}', [Views::class, 'forgotPassword'])->name('/forgot-password');
Route::get('/password-link-sent', [Views::class, 'passwordLinkSent'])->name('/password-link-sent');

Route::post('/api/auth/otp', [AuthController::class, 'OTP'])->name('api/auth/otp');
Route::post('/api/auth/check-otp', [AuthController::class, 'verifyOTP'])->name('api/auth/check-otp');

Route::prefix('/api')->group(function(){
    // Authentication routes
    Route::post('auth/signup', [AuthController::class, 'signup'])->name('api/auth/sign-up');
    Route::post('auth/login', [AuthController::class, 'login'])->name('api/auth/login');
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('api/auth/logout');

    //Upload image route
    Route::post('upload-image', [UserActions::class, 'uploadImage'])->name('api/upload-image');
    Route::post('reset-link', [UserActions::class, 'resetLink'])->name('api/reset-link');
    Route::post('create-event', [UserActions::class, 'createEvent'])->name('api/create-event');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('api/forgot-password');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('api/reset-password');
});


Route::get('/event/{id}', [Views::class, 'Events'])->name('event');
Route::get('/login', [Views::class, 'login'])->name('login');
Route::get('/signup', [Views::class, 'signup'])->name('signup');
Route::get('/otp', [Views::class, 'otp'])->name('otp');
Route::get('/dashboard', [Views::class, 'dashboard'])->name('dashboard');
Route::get('/event/{id}', [Views::class, 'event'])->name('event');




Route::fallback(FallbackController::class);