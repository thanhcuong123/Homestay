<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;

class OwnerController extends Controller
{
    //
    public function index()
    {
        $owners = Owner::all();
        return view("admin.owner.listowner", compact('owners'));
    }
    public function create()
    {
        return view('admin.owner.create');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        // Kiểm tra dữ liệu đầu vào
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'gender' => 'required|in:Nam,Nữ',
        //     'phone' => 'required|digits:10',
        // ]);

        // Lưu vào database
        Owner::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'phone' => $request->phone,
        ]);
        return redirect()->route('admin.owner.index')->with('success', 'Thêm chủ homestay thành công!');
    }
    public function edit($id)
    {
        $owner = Owner::find($id);
        return view('admin.owner.update', compact('owner'));
    }
    public function update(Request $request, $id)
    {
        $owner = Owner::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Nam,Nữ',
            'phone' => 'required|digits:10',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('avatar');

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        $owner->update($data);

        return redirect()->route('admin.owner.index')->with('success', 'Cập nhật chủ sở hữu thành công!');
    }
    public function destroy($id)
    {
        Owner::find($id)->delete();
        return redirect()->route('admin.owner.index')->with('success', 'Xóa thành công!');
    }
}
