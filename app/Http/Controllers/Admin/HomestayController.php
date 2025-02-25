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
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'administrative_unit_id' => 'nullable|exists:administrative_units,id',
        ]);

        // Lưu vào database
        Homestay::create([
            'owner_id' => $request->owner_id,
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'administrative_unit_id' => $request->administrative_unit_id,
        ]);

        // Chuyển hướng về danh sách homestay với thông báo thành công
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
            'administrative_unit_id' => 'nullable|exists:administrative_units,id'
        ]);

        $homestay = Homestay::findOrFail($id);
        $homestay->update($request->all());

        return redirect()->route('admin.homestay.index')->with('success', 'Cập nhật homestay thành công!');
    }
    public function destroy($id)
    {
        $homestay = Homestay::findOrFail($id);
        $homestay->delete();

        return redirect()->route('admin.homestay.index')->with('success', 'Xóa homestay thành công.');
    }
}
