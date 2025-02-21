<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;


Route::get('/', function () {

    return view('user/index');
});
//home
Route::get('/home',[UserController::class, 'home'])->name('home.html');
//about us
Route::get('/about', [UserController::class,'about'])->name('about.html');

//lists
route::get('/lists',[UserController::class,'lists'])->name('list.html');

//booking
route::get('/booking',[UserController::class,'booking'])->name('booking.html');

//contact
route::get('/contact',[UserController::class,'contact'])->name('contact.html');

//login
route::get('/login',[AuthController::class,'login'])->name('login.html');