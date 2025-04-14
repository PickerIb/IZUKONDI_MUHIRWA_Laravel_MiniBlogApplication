<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::view('/','posts.index')->name('home');

Route::redirect('/','posts');

//User posts route
Route::get('/{user}/posts',[DashboardController::class,'userPosts'])->name('posts.user');


Route::resource('posts',PostController::class);

//Routes for authenticated users
Route::middleware('auth')->group(function(){


Route::get('/dashboard',[DashboardController::class,'index'])->middleware('verified')->name('dashboard');


Route::post('/logout',[AuthController::class,'logout'])->name('logout');


//Email verification Notice route 


Route::get('/email/verify', [AuthController::class,'verifyNotice'])->name('verification.notice');

//Email Verification Handler Notice 

Route::get('/email/verify/{id}/{hash}', [AuthController::class,'verifyEmail'])->middleware(['signed'])->name('verification.verify');

//Resending the email verification route 

Route::post('/email/verification-notification', [AuthController::class,'verifyHandler'])->middleware(['throttle:6,1'])->name('verification.send');

});


Route::middleware('guest')->group(function() {

Route::view('/register','auth.register')->name('register'); 

Route::post('/register', [App\Http\Controllers\AuthController::class,'register']);

Route::view('/login','auth.login')->name('login'); 

Route::post('/login', [App\Http\Controllers\AuthController::class,'login']);

});