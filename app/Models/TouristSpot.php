<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TouristSpot extends Model
{
    //
    use HasFactory;
    protected $fillable = ['name', 'address', 'latitude', 'longitude', 'icon'];

    public function icon()
    {
        return $this->belongsTo(Icon::class);
    }

    public function homestays()
    {
        return $this->belongsToMany(Homestay::class, 'distances', 'tourist_spot_id', 'homestay_id')
                    ->withPivot('distance')
                    ->orderBy('distance');
    }
}