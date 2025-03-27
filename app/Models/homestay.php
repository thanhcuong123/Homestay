<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Homestay extends Model
{
    //
    use HasFactory;

    protected $table = 'homestays';
    protected $fillable = ['owner_id', 'name', 'address', 'latitude', 'longitude', 'administrative_unit_id', 'image'];
    protected $primaryKey = 'id';
    protected $dates = ['created_at', 'updated_at'];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function administrativeUnit()
    {
        return $this->belongsTo(AdministrativeUnit::class, 'administrative_unit_id');
    }

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class, 'homestay_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'homestay_id');
    }
    public function distances()
    {
    return $this->hasMany(Distance::class, 'homestay_id');
    }
    public function touristSpots()
    {
        return $this->belongsToMany(TouristSpot::class, 'distances', 'homestay_id', 'tourist_spot_id')
                    ->withPivot('distance')
                    ->orderBy('distance');
    }
}