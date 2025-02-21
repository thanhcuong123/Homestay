<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdministrativeUnit extends Model
{
    use HasFactory;

    protected $table = 'administrative_units';
    protected $fillable = ['name', 'type'];
    protected $primaryKey = 'id';
    protected $dates = ['created_at', 'updated_at'];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function homestays()
    {
        return $this->hasMany(Homestay::class, 'administrative_unit_id');
    }
}
