<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    use HasFactory;

    protected $table = 'services';

    protected $fillable = ['homestay_id', 'name'];

    protected $primaryKey = 'id';

    protected $dates = ['created_at', 'updated_at'];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function homestay()
    {
        return $this->belongsTo(Homestay::class);
    }
}
