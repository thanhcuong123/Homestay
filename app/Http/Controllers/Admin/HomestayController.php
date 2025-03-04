<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\homestay;
use App\Models\AdministrativeUnit;
use App\Models\Owner;
use App\Http\Controllers\Admin\Toastr;

class HomestayController extends Controller
{
    //
    public function index()
    {
        $homestay = Homestay::with('owner', 'administrativeUnit')->get();
        return view('admin.homestay.listhomestay', compact('homestay'));
    }
    public function create()
    {
        $owners = Owner::all();
        $administrativeUnits = AdministrativeUnit::all();
        return view('admin.homestay.create', compact('owners', 'administrativeUnits'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'administrative_unit_id' => 'nullable|exists:administrative_units,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            // dd($request->file('image'));
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Kiểm tra xem file đã nhận chưa
            if (!$image->isValid()) {
                return back()->with('error', 'Lỗi tải lên hình ảnh');
            }

            $imagePath = $image->storeAs('uploads/homestay', $imageName, 'public');
        }

        // Kiểm tra đường dẫn ảnh
        if (!$imagePath) {
            return back()->with('error', 'Không thể lưu hình ảnh.');
        }

        Homestay::create([
            'owner_id' => $request->owner_id,
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'administrative_unit_id' => $request->administrative_unit_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.homestay.index')->with('success', 'Thêm homestay thành công!');
    }

    public function edit($id)
    {
        $homestay = Homestay::findOrFail($id);
        $owners = Owner::all();
        $administrativeUnits = AdministrativeUnit::all();
        return view('admin.homestay.update', compact('homestay', 'owners', 'administrativeUnits'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'administrative_unit_id' => 'nullable|exists:administrative_units,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $homestay = Homestay::findOrFail($id);

        // Nếu có ảnh mới, lưu vào storage
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Kiểm tra file hợp lệ
            if (!$image->isValid()) {
                return back()->with('error', 'Lỗi tải lên hình ảnh.');
            }

            // Lưu file vào storage
            $imagePath = $image->storeAs('uploads/homestay', $imageName, 'public');

            // Nếu lưu thành công, cập nhật ảnh mới
            if ($imagePath) {
                $homestay->image = $imagePath;
            }
        }

        // Cập nhật các thông tin khác
        $homestay->owner_id = $request->owner_id;
        $homestay->name = $request->name;
        $homestay->address = $request->address;
        $homestay->latitude = $request->latitude;
        $homestay->longitude = $request->longitude;
        $homestay->administrative_unit_id = $request->administrative_unit_id;

        $homestay->save();

        return redirect()->route('admin.homestay.index')->with('success', 'Cập nhật homestay thành công!');
    }


    public function destroy($id)
    {
        $homestay = Homestay::findOrFail($id);
        $homestay->delete();

        return redirect()->route('admin.homestay.index')->with('success', 'Xóa homestay thành công.');
    }
    public function showMap(Request $request)
    {
        $homestay = Homestay::where('latitude', $request->lat)
            ->where('longitude', $request->lng)
            ->firstOrFail();

        return view('admin.homestay.map', [
            'latitude' => $homestay->latitude,
            'longitude' => $homestay->longitude,
            'name' => $homestay->name,
            'address' => $homestay->address,
            'image' => $homestay->image
        ]);
    }
    public function showMapall()
    {

        $homestays = Homestay::all()->map(function ($homestay) {
            return [
                'name' => $homestay->name,
                'address' => $homestay->address,
                'latitude' => $homestay->latitude,
                'longitude' => $homestay->longitude,
                'image' => asset('storage/' . $homestay->image),
            ];
        });

        return view('admin.homestay.mapall', compact('homestays'));
    }
}
