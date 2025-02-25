<?php

use App\Http\Controllers\Admin\HomestayController;
use App\Http\Controllers\Admin\RoomtypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;




Route::get('/', function () {

    return view('admin/admin_layout');
});


//login
Route::get('/login', [AuthController::class, 'showFormlogin'])->name('showFormlogin.html');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Use vieets trong đây nhe 
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.index');
    })->name('userindex');
    //home
    Route::get('/home', [UserController::class, 'home'])->name('home.html');
    //about us
    Route::get('/about', [UserController::class, 'about'])->name('about.html');

    //lists
    route::get('/lists', [UserController::class, 'lists'])->name('list.html');

    //booking
    route::get('/booking', [UserController::class, 'booking'])->name('booking.html');

    //contact
    route::get('/contact', [UserController::class, 'contact'])->name('contact.html');
});

// Route cho admin
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/roomtype', [RoomtypeController::class, 'index'])->name('admin.roomtype');
    Route::get('/admin/homestay', [HomestayController::class, 'index'])->name('admin.homestay.index');
    Route::get('/admin/homestay/create', [HomestayController::class, 'create'])->name('admin.homestay.create');
    Route::post('/admin/homestay/store', [HomestayController::class, 'store'])->name('admin.homestay.store');
    Route::get('/admin/homestay/{id}/edit', [HomestayController::class, 'edit'])->name('admin.homestay.edit');
    Route::put('/admin/homestay/update/{id}', [HomestayController::class, 'update'])->name('admin.homestay.update');
    Route::delete('admin/homestay/{id}', [HomestayController::class, 'destroy'])->name('admin.homestay.destroy');
});



// *******













// end route admin