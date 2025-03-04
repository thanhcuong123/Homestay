<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;

class Roomcontroller extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        $roomtype = RoomType::all();
        return view('admin.room.room', compact('rooms', 'roomtype'));
    }
    public function create()
    {
        $roomtype = RoomType::all();
        return view('admin.room.create', compact('roomtype'));
    }
    public function store(Request $request)
    {
        // $request->validate([
        //     'owner_id' => 'required|exists:owners,id',
        //     'name' => 'required|string|max:255',
        //     'address' => 'required|string',
        //     'latitude' => 'required|numeric',
        //     'longitude' => 'required|numeric',
        //     'administrative_unit_id' => 'nullable|exists:administrative_units,id',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            // dd($request->file('image'));
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Kiểm tra xem file đã nhận chưa
            if (!$image->isValid()) {
                return back()->with('error', 'Lỗi tải lên hình ảnh');
            }

            $imagePath = $image->storeAs('uploads/room', $imageName, 'public');
        }

        // Kiểm tra đường dẫn ảnh
        if (!$imagePath) {
            return back()->with('error', 'Không thể lưu hình ảnh.');
        }

        Room::create([
            'room_type_id' => $request->room_type_id,
            'room_number' => $request->room_number,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.room.index')->with('success', 'Thêm homestay thành công!');
    }
    public function edit($id)
    {
        $roomtypes = RoomType::all();
        $room = Room::findOrFail($id);
        return view('admin.room.update', compact('roomtypes', 'room'));
    }
    public function update(Request $request, $id)
    {
        // Kiểm tra dữ liệu đầu vào
        // $request->validate([
        //     'room_type_id' => 'required|exists:room_types,id',
        //     'room_number' => 'required|string|max:255',
        //     'status' => 'required|string',
        //     'area' => 'required|numeric',
        //     'price' => 'required|numeric',
        //     'amenities' => 'required|string',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);
        $room = Room::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            if (!$image->isValid()) {
                return back()->with('error', 'Lỗi tải lên hình ảnh.');
            }
            $imagePath = $image->storeAs('uploads/room', $imageName, 'public');


            if ($imagePath) {
                $room->image = $imagePath;
            }
        }
        $room->room_type_id = $request->room_type_id;
        $room->room_number = $request->room_number;
        $room->status = $request->status;

        $room->save();

        return redirect()->route('admin.room.index')->with('success', 'Cập nhật phòng thành công!');
    }
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect()->route('admin.room.index')->with('success', 'Xóa thành công!');
    }
}
