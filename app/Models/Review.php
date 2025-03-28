<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['homestay_id', 'user_id', 'comment', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');  // Kiểm tra xem cột 'user_id' có đúng không
    }


    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function homestay()
    {
        return $this->belongsTo(Homestay::class);
    }
}
