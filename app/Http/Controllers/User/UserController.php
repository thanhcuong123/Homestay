<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\homestay;
use App\Models\TouristSpot;


class UserController extends Controller
{
    public function lists()
    {
        return view('user.lists');
    }

    public function home()
    {
        $homestays = Homestay::select('name', 'latitude', 'longitude', 'address', 'image')
            ->get()
            ->map(function ($homestay) {
                // Kiểm tra nếu ảnh đã có đầy đủ đường dẫn hay chưa
                if ($homestay->image && !str_contains($homestay->image, 'storage/upload/homestay/')) {
                    $homestay->image = asset("storage/{$homestay->image}");
                }
                return $homestay;
            });
        // dd($homestays); // Kiểm tra dữ liệu

        $touristSpots = TouristSpot::select('name', 'latitude', 'longitude', 'address', 'icon')
            ->get()
            ->map(function ($tourist) {
                if ($tourist->icon && !str_contains($tourist->icon, 'storage/upload/tourist/')) {
                    $tourist->icon = asset("storage/{$tourist->icon}");
                }
                return $tourist;
            });
        // dd($homestays, $touristSpots); // Debug dữ liệu

        return view('user.index', compact('homestays', 'touristSpots'));
    }
}
