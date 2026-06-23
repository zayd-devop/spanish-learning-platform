<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licence extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'institute',
        'location',
        'description',
        'website',
        'latitude',
        'longitude',
    ];
}
