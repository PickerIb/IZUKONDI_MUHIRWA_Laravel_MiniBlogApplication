<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::view('/','posts.index')->name('home');

Route::redirect('/','posts');


Route::get('/{user}/posts',[DashboardController::class,'userPosts'])->name('posts.user');


Route::resource('posts',PostController::class);

Route::middleware('auth')->group(function(){


Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');


Route::post('/logout',[AuthController::class,'logout'])->name('logout');


});

Route::middleware('guest')->group(function() {

Route::view('/register','auth.register')->name('register'); 

Route::post('/register', [App\Http\Controllers\AuthController::class,'register']);

Route::view('/login','auth.login')->name('login'); 

Route::post('/login', [App\Http\Controllers\AuthController::class,'login']);

});