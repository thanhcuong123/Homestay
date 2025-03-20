<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homestay;

class SearchController extends Controller
{
    public function searchHomestay(Request $request)
    {
        $query = $request->input('query');
        $maxGuests = $request->input('max_guests');
        $maxPrice = $request->input('max_price');

        $results = Homestay::select('id', 'name', 'latitude', 'longitude', 'image', 'address', 'owner_id')
            ->with(['owner:id,name,phone', 'roomTypes'])
            ->where(function ($q) use ($query, $maxGuests, $maxPrice) {
                if (!empty($query)) {
                    $q->where('name', 'like', '%' . $query . '%')
                        ->orWhereHas('owner', function ($q) use ($query) {
                            $q->where('name', 'like', '%' . $query . '%');
                        });
                }

                if (!empty($maxGuests)) {
                    $q->orWhereHas('roomTypes', function ($q) use ($maxGuests) {
                        $q->where('max_guests', '>=', $maxGuests);
                    });
                }

                if (!empty($maxPrice)) {
                    $q->orWhereHas('roomTypes', function ($q) use ($maxPrice) {
                        $q->where('price', '<=', $maxPrice);
                    });
                }
            })
            ->get()
            ->map(function ($homestay) {
                // Kiểm tra nếu ảnh đã có đầy đủ đường dẫn hay chưa
                if ($homestay->image && !str_contains($homestay->image, 'storage/upload/homestay/')) {
                    $homestay->image = asset("storage/{$homestay->image}");
                }
                return $homestay;
            });




        return response()->json($results);
    }
}
