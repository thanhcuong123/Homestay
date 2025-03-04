<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TouristSpot;

class TourisSpotsController extends Controller
{
    public function index()
    {
        $tourist = TouristSpot::all();
        return view('admin.tourist.tourist', compact('tourist'));
    }
}
