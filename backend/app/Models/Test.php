<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_id',
        'title',
        'type',
    ];

    public function week()
    {
        return $this->belongsTo(Week::class);
    }

    public function questions()
    {
        return $this->hasMany(TestQuestion::class);
    }
}
