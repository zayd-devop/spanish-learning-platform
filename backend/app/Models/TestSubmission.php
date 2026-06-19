<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'score',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
