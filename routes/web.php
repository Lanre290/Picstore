<?php

use Illuminate\Support\Facades\Route;


Route::prefix('/api')->group(function(){
    // Authentication routes
    Route::post('auth/signup', [AuthController::class, 'signup'])->name('auth/sign-up');
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth/login');

    //Upload image route
    Route::post('upload-image', [UserActions::class, 'uploadImage'])->name('api/upload-image');
});
