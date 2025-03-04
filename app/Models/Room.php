<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    use HasFactory;

    protected $table = 'rooms';
    protected $fillable = ['room_type_id', 'room_number', 'status', 'image'];
    protected $primaryKey = 'id';
    protected $dates = ['created_at', 'updated_at'];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }
}
