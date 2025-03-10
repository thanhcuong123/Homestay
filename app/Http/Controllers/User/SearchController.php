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

        $results = Homestay::with(['owner', 'roomTypes'])
        ->where(function ($q) use ($query, $maxGuests, $maxPrice) {
            if ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhereHas('owner', function ($q) use ($query) {
                      $q->where('name', 'like', '%' . $query . '%');
                  });
            }

            if ($maxGuests !== null) {
                $q->orWhereHas('roomTypes', function ($q) use ($maxGuests) {
                    $q->where('max_guests', '>=', $maxGuests);
                });
            }

            if ($maxPrice !== null) {
                $q->orWhereHas('roomTypes', function ($q) use ($maxPrice) {
                    $q->where('price', '<=', $maxPrice);
                });
            }
        })
        ->get();

        return response()->json($results);
    }
}