<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_id',
        'text_answer',
        'audio_path',
        'evaluation_score',
        'evaluation_feedback',
    ];

    public function week()
    {
        return $this->belongsTo(Week::class);
    }
}
