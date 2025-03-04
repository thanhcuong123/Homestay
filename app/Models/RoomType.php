<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{

    use HasFactory;

    protected $table = 'room_types';
    protected $fillable = ['homestay_id', 'name', 'max_guests', 'area', 'price', 'amenities'];
    protected $primaryKey = 'id';
    protected $dates = ['created_at', 'updated_at'];
    protected $dateFormat = 'Y-m-d H:i:s';
    // protected $casts = ['amenities' => 'array'];

    public function homestay()
    {
        return $this->belongsTo(Homestay::class, 'homestay_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_type_id');
    }
}
