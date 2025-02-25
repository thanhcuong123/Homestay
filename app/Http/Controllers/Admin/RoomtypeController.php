<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomType;


class RoomtypeController extends Controller
{
    //

    public function index()
    {
        $rooms = Roomtype::all();
        return view("admin.Room.Roomtype", compact("rooms"));
    }
}
