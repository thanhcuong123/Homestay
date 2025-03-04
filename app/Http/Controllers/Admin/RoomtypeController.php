<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Homestay;

class RoomtypeController extends Controller
{


    public function index()
    {
        $homestay = Homestay::all();
        $rooms = Roomtype::all();
        return view("admin.roomtype.Roomtype", compact('rooms', 'homestay'));
    }
    public function create()
    {
        $homestay = Homestay::all();
        return view('admin.roomtype.createroomtype', compact('homestay'));
    }
    public function store(Request $request)
    {
        Roomtype::create([
            'homestay_id' => $request->homestay_id,
            'name' => $request->name,
            'max_guests' => $request->max_guests,
            'area' => $request->area,
            'price' => $request->price,
            'amenities' => $request->amenities

        ]);
        return redirect()->route('admin.roomtype.index')->with('success', 'Thêm loại phòng thành công');
    }
    public function edit($id)
    {
        $roomtype = Roomtype::find($id);
        $homestay = Homestay::all();
        return view('admin.roomtype.updateroomtype', compact('roomtype', 'homestay'));
    }
    public function update(Request $request, $id)
    {
        $roomtype  = Roomtype::findOrFail($id);
        $roomtype->update([
            'homestay_id' => $request->homestay_id,
            'name' => $request->name,
            'max_guests' => $request->max_guests,
            'area' => $request->area,
            'price' => $request->price,
            'amenities' => $request->amenities,

        ]);
        return redirect()->route('admin.roomtype.index')->with('success', 'cập nhật loại phòng thành công!');
    }
    public function destroy($id)
    {
        $roomtype = Roomtype::findOrFail($id);
        $roomtype->delete();
        return redirect()->route('admin.roomtype.index')->with('success', 'Xóa thành công!');
    }
}
