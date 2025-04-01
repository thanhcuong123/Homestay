<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class User_adminController extends Controller
{
    public function index(){
        $user=User::all();
        return view('admin.user.index', compact('user'));
    }
    public function create()
    {
        return view('admin.user.create');
    }
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'avatar' => $request->avatar,
            'role' => $request->role ?? 'user',
        ]);
        return redirect()->route('admin.user.index')->with('success', 'Thêm tài khoản thành công!');
    }
    public function destroy($id){
        User::find($id)->delete();
        return redirect()->route('admin.user.index')->with('success','Xóa người dùng thành công!');
    }
    public function edit($id){
        $user = User::find($id);
        return view('admin.user.update',compact('user'));
    }
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'phone' => 'nullable|string|max:15',
        'address' => 'nullable|string',
        'gender' => 'nullable|in:Nam,Nữ',
        'date_of_birth' => 'nullable|date',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'role' => 'required|in:admin,user',
    ]);

    $data = $request->except('password', 'avatar');

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    if ($request->hasFile('avatar')) {
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $data['avatar'] = $avatarPath;
    }

    $user->update($data);

    return redirect()->route('admin.user.index')->with('success', 'Cập nhật người dùng thành công!');
}

}