<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\homestay;
use App\Models\TouristSpot;

class MapController extends Controller
{
    //
    public function showAllLocations()
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

        $touristSpots = TouristSpot::select('name', 'latitude', 'longitude', 'address', 'icon')
            ->get()
            ->map(function ($tourist) {
                if ($tourist->icon && !str_contains($tourist->icon, 'storage/upload/tourist/')) {
                    $tourist->icon = asset("storage/{$tourist->icon}");
                }
                return $tourist;
            });

        return view('user.index', compact('homestays', 'touristSpots'));
    }
    public function calculateDistance($homestayId, $touristId)
    {
        $homestay = Homestay::findOrFail($homestayId);
        $tourist = TouristSpot::findOrFail($touristId);

        return response()->json([
            'homestay' => [
                'name' => $homestay->name,
                'latitude' => $homestay->latitude,
                'longitude' => $homestay->longitude
            ],
            'tourist' => [
                'name' => $tourist->name,
                'latitude' => $tourist->latitude,
                'longitude' => $tourist->longitude
            ]
        ]);
    }
}
