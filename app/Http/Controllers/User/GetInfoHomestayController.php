<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\homestay;

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
            return response()->json(['error' => 'Homestay không tồn tại'], 404);
        }

        // Kiểm tra roomTypes có tồn tại không
        $reviews = collect([]);
        if ($homestay->roomTypes) {
            $reviews = $homestay->roomTypes->flatMap(function ($roomType) {
                return $roomType->rooms ? $roomType->rooms->flatMap->reviews : collect([]);
            });
        }

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
        ]);
    }
}
