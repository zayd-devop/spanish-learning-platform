<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWeekProgress extends Model
{
    use HasFactory;

    protected $table = 'user_week_progress';

    protected $fillable = [
        'user_id',
        'week_id',
        'is_completed',
        'task_progress',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'task_progress' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function week()
    {
        return $this->belongsTo(Week::class);
    }
}
