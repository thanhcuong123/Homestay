<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
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
            'user_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        Review::create($request->all());

        return redirect()->back()->with('success', 'Đánh giá đã được gửi!');
    }


}