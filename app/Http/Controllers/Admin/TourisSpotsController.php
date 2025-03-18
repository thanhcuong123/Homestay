<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TouristSpot;
use Illuminate\Support\Facades\Storage;

class TourisSpotsController extends Controller
{
    public function index()
    {
        $tourist = TouristSpot::all();
        return view('admin.tourist.tourist', compact('tourist'));
    }
    public function create()
    {
        return view('admin.tourist.create');
    }
    public function store(Request $request)
    {


        $imagePath = null;

        if ($request->hasFile('image')) {
            // dd($request->file('image'));
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Kiểm tra xem file đã nhận chưa
            if (!$image->isValid()) {
                return back()->with('error', 'Lỗi tải lên hình ảnh');
            }

            $imagePath = $image->storeAs('uploads/tourist', $imageName, 'public');
        }

        // Kiểm tra đường dẫn ảnh
        if (!$imagePath) {
            return back()->with('error', 'Không thể lưu hình ảnh.');
        }

        TouristSpot::create([

            'name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,

            'icon' => $imagePath,
        ]);

        return redirect()->route('tourist.index')->with('success', 'Thêm điểm du lịch thành công!');
    }
    public function edit($id)
    {
        $tourist = TouristSpot::find($id);
        return view('admin.tourist.update', compact('tourist'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $tourist = TouristSpot::findOrFail($id);

        $tourist->name = $request->name;
        $tourist->address = $request->address;
        $tourist->latitude = $request->latitude;
        $tourist->longitude = $request->longitude;

        // Kiểm tra nếu có tải lên hình ảnh mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($tourist->icon) {
                Storage::delete('public/uploads/tourist/' . basename($tourist->icon));
            }

            // Lưu ảnh mới
            $imagePath = $request->file('image')->store('uploads/tourist', 'public');
            $tourist->icon = $imagePath;
        }

        $tourist->save();

        return redirect()->route('tourist.index')->with('success', 'Cập nhật điểm du lịch thành công!');
    }
    public function showMap(Request $request)
    {
        $tourist = TouristSpot::where('latitude', $request->lat)
            ->where('longitude', $request->lng)
            ->firstOrFail();

        return view('admin.tourist.map', [
            'latitude' => $tourist->latitude,
            'longitude' => $tourist->longitude,
            'name' => $tourist->name,
            'address' => $tourist->address,
            'icon' => $tourist->icon,
        ]);
    }
    public function mapall(Request $request)
    {

        $tourist = TouristSpot::all()->map(function ($tourist) {
            return [
                'name' => $tourist->name,
                'address' => $tourist->address,
                'latitude' => $tourist->latitude,
                'longitude' => $tourist->longitude,
                'icon' => asset('storage/' . $tourist->icon),
            ];
        });

        return view('admin.tourist.mapall', compact('tourist'));
    }
    public function destroy($id)
    {
        $tourist = TouristSpot::findOrFail($id);

        // Xóa hình ảnh nếu có
        if ($tourist->icon) {
            Storage::delete('public/' . $tourist->icon);
        }

        $tourist->delete();

        return redirect()->route('tourist.index')->with('success', 'Đã xóa điểm du lịch thành công!');
    }
}
