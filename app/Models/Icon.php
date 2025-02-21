<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Icon extends Model
{
    //

    use HasFactory;

    protected $table = 'icons';

    protected $fillable = ['name', 'url'];
}
