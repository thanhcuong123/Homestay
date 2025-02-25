<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Nếu chưa đăng nhập, chuyển về login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập trước!');
        }

        // Kiểm tra quyền truy cập
        if (Auth::user()->role !== $role) {
            return abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}
