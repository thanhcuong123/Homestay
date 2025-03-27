<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\homestay;
use App\Models\TouristSpot;

class GetInfoHomestayController extends Controller
{
    public function getHomestayDetails($id)
    {
        $homestay = homestay::with([
            'owner',
            'roomTypes.rooms',
            'roomTypes',
            'services',
        ])->find($id);

        if (!$homestay) {
            return redirect()->back()->with('error', 'Homestay không tồn tại');
        }

        // Kiểm tra roomTypes có tồn tại không
        $reviews = collect([]);
        if ($homestay->roomTypes) {
            $reviews = $homestay->roomTypes->flatMap(function ($roomType) {
                return $roomType->rooms ? $roomType->rooms->flatMap->reviews : collect([]);
            });
        }
        $latitude = $homestay->latitude;
        $longitude = $homestay->longitude;
        // $radius = 5; // km

        $touristSpots = TouristSpot::selectRaw("
                id, name, address, latitude, longitude, icon,
                (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
            ", [$latitude, $longitude, $latitude])
        //    ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();

        return response()->json([
            'id' => $homestay->id,
            'name' => $homestay->name,
            'address' => $homestay->address,
            'owner' => $homestay->owner,
            'latitude' => $homestay->latitude,
            'longitude' => $homestay->longitude,
            'image' => asset('storage/' . $homestay->image),
            'rooms' => $homestay->roomTypes->map(function ($roomType) {
                return [
                    'name' => $roomType->name,
                    'max_guests' => $roomType->max_guests,
                    'area' => $roomType->area,
                    'price' => $roomType->price,
                    'amenities' => $roomType->amenities,
                ];
            }),
            'reviews' => $reviews->map(function ($review) {
                return [
                    'user' => $review->user ? $review->user->name : 'Ẩn danh',
                    'comment' => $review->content ?? 'Không có bình luận',
                    'rating' => $review->rating ?? 0,
                ];
            }),
            'tourist_spots' => $touristSpots->map(function ($spot) {
                return [
                    'id' => $spot->id,
                    'name' => $spot->name,
                    'address' => $spot->address,
                    'latitude' => $spot->latitude,
                    'longitude' => $spot->longitude,
                    'icon' => asset('storage/' . $spot->icon),
                    'distance' => round($spot->distance, 2) . ' km',
                ];
            }),
        ]);
    }
}