<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Distance extends Model
{
    //
    use HasFactory;
    protected $fillable = ['homestay_id', 'tourist_spot_id', 'distance'];

    public function homestay()
    {
        return $this->belongsTo(Homestay::class);
    }

    public function touristSpot()
    {
        return $this->belongsTo(TouristSpot::class);
    }
}