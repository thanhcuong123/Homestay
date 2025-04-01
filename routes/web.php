<?php

use App\Http\Controllers\Admin\HomestayController;
use App\Http\Controllers\Admin\RoomtypeController;
use App\Http\Controllers\User\GetInfoHomestayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;

use App\Http\Controllers\User\SearchController;
use App\Http\Controllers\Admin\OwnerController;
use Illuminate\Support\Facades\View;
use App\Http\controllers\Admin\Roomcontroller;
use App\Http\controllers\Admin\TourisSpotsController;
use App\Http\Controllers\Admin\User_adminController;
// use App\Http\controllers\Admin\MapController;
use App\Http\Controllers\User\MapController;
use App\Http\Controllers\User\ReviewController;

Route::get('/', function () {

    return view('user/index');
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
    //lists
    route::get('/lists', [UserController::class, 'lists'])->name('list.html');
    Route::get('/mapall', [MapController::class, 'showAllLocations'])->name('mapall');
    Route::get('/distance/{homestayId}/{touristId}', [MapController::class, 'calculateDistance']);
});
//Search
Route::get('/search-homestay', [SearchController::class, 'searchHomestay'])->name('searchHomestay');
//Thông tin homestay khi xem chi tiết
Route::get('/homestay/{id}', [GetInfoHomestayController::class, 'getHomestayDetails'])->name('getHomestayDetails');
//Đánh giá
Route::get('/homestay/{id}/reviews', [ReviewController::class, 'getReviews']);
Route::post('/reviews', [ReviewController::class, 'store']);


// Route cho admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    //User
    Route::get('/admin/User',action: [User_adminController::class, 'index'])->name('admin.user.index');
    Route::get('/admin/User/create',action: [User_adminController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/User/store', [User_adminController::class,'store'])->name('admin.user.store');
    Route::get('/admin/User/edit/{id}',[User_adminController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/User/update/{id}', [User_adminController::class, 'update'])->name('admin.user.update');
    Route::delete('admin/User/destroy/{id}', [User_adminController::class, 'destroy'])->name('admin.user.destroy');

    //homestay
    Route::get('/admin/homestay', [HomestayController::class, 'index'])->name('admin.homestay.index');
    Route::get('/admin/homestay/create', [HomestayController::class, 'create'])->name('admin.homestay.create');
    Route::post('/admin/homestay/store', [HomestayController::class, 'store'])->name('admin.homestay.store');
    Route::get('/admin/homestay/{id}/edit', [HomestayController::class, 'edit'])->name('admin.homestay.edit');
    Route::put('/admin/homestay/update/{id}', [HomestayController::class, 'update'])->name('admin.homestay.update');
    Route::delete('admin/homestay/{id}', [HomestayController::class, 'destroy'])->name('admin.homestay.destroy');
    Route::get('/admin/homestay/map', [HomestayController::class, 'showMap'])->name('admin.homestay.map');
    Route::get('/admin/homestay/mapall', [HomestayController::class, 'showMapall'])->name('admin.homestay.mapall');

    // Owner
    Route::get('/admin/owner', [OwnerController::class, 'index'])->name('admin.owner.index');
    Route::get('/admin/owner/create', [OwnerController::class, 'create'])->name('admin.owner.create');
    Route::post('/admin/owner/store', [OwnerController::class, 'store'])->name('admin.owner.store');
    Route::delete('admin/owner/destroy/{id}', [OwnerController::class, 'destroy'])->name('owner.destroy');
    Route::get('admin/owner/edit/{id}', [OwnerController::class, 'edit'])->name('owner.edit');
    Route::put('/admin/owner/{id}', [OwnerController::class, 'update'])->name('admin.owner.update');
    Route::post('admin/owner/update', [OwnerController::class, 'update'])->name('owner.update');

    //Roomtype
    Route::get('/admin/roomtype', [RoomtypeController::class, 'index'])->name('admin.roomtype.index');
    Route::get('/admin/roomtype/creae', [RoomtypeController::class, 'create'])->name('roomtype.create');
    Route::post('/admin/roomtype/store', [RoomtypeController::class, 'store'])->name('roomtype.store');
    Route::get('/admin/roomtype/edit/{id}', [RoomtypeController::class, 'edit'])->name('roomtype.edit');
    Route::put('/admin/roomtype/update/{id}', [RoomtypeController::class, 'update'])->name('roomtype.update');
    Route::delete('/admin/roomtype/{id}', [RoomtypeController::class, 'destroy'])->name('roomtype.destroy');
    // room
    Route::get('/admin/room', [Roomcontroller::class, 'index'])->name('admin.room.index');
    Route::get('/admin/room/create', [Roomcontroller::class, 'create'])->name('room.create');
    Route::post('/admin/room/store', [Roomcontroller::class, 'store'])->name('room.store');
    Route::get('/admin/room/edit/{id}', [Roomcontroller::class, 'edit'])->name('room.edit');
    Route::put('/admin/room/update/{id}', [Roomcontroller::class, 'update'])->name('room.update');
    Route::delete('admin/rooom/destroy/{id}', [Roomcontroller::class, 'destroy'])->name('rooms.destroy');
    //touris_spot
    Route::get('admin/tourist', [TourisSpotsController::class, 'index'])->name('tourist.index');
    Route::get('/admin/tourist/create', [TourisSpotsController::class, 'create'])->name('tourist.create');
    Route::post('/admin/tourist/store', [TourisSpotsController::class, 'store'])->name('tourist.store');
    Route::delete('/admin/tourist/destroy/{id}', [TourisSpotsController::class, 'destroy'])->name('tourist.destroy');
    Route::get('/admin/tourist/edit{id}', [TourisSpotsController::class, 'edit'])->name('tourist.edit');
    Route::put('/admin/tourist/update/{id}', [TourisSpotsController::class, 'update'])->name('tourist.update');
    Route::get('/admin/tourist/map', [TourisSpotsController::class, 'showMap'])->name('tourist.map');
    Route::get('/admin/tourist/mapall', [TourisSpotsController::class, 'mapall'])->name('tourist.mapall');
    //map
    // Route::get('/admin/mapall', [MapController::class, 'showAllLocations'])->name('mapall');
    // Route::get('/map/distance/{homestayId}/{touristId}', [MapController::class, 'calculateDistance']);
});



// *******













// end route admin
