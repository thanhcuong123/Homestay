<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function getReviews($homestayId)
    {
        $reviews = Review::where('homestay_id', $homestayId)->latest()->get();
        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $request->validate([
            'homestay_id' => 'required|exists:homestays,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        $review = Review::create([
            'homestay_id' => $request->homestay_id,
            'user_id' => Auth::id() ?? null, // Nếu có user đăng nhập thì lấy user_id
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Đánh giá đã được lưu!',
            'review' => [
                'user_name' => $review->user->name ?? 'Ẩn danh',
                'avatar' => $review->user->avatar ?? 'storage/uploads/icon/an_danh.jpg',
                'rating' => $review->rating,
                'comment' => $review->comment,
            ],
        ]);
    }
}
