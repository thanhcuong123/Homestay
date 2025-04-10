<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showFormlogin()
    {
        return view('login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    public function showFormRegister()
    {
        return view('register');
    }

    // Xử lý đăng ký tài khoản
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('login')->with('success', 'Đăng ký thành công!');
    }

    public function login(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        Log::info('Thử đăng nhập với email: ' . $request->email);

        if (!Auth::attempt($request->only('email', 'password'))) {
            Log::error('Đăng nhập thất bại: Email hoặc mật khẩu không đúng');
            return back()->withErrors(['login_error' => 'Email hoặc mật khẩu không đúng!'])->withInput();
        }

        $user = Auth::user();
        Log::info('Đăng nhập thành công! User: ' . json_encode($user));

        return ($user->role === 'admin')
            ? redirect()->route('admin.homestay.index')->with('success', 'Chào mừng Admin!')
            : redirect()->route('home.html')->with('success', 'Đăng nhập thành công!');
    }
}
