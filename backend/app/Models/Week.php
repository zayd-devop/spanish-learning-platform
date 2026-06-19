<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_number',
        'title',
        'focus',
        'milestone',
        'is_completed',
        'source_links',
        'video_links',
        'books',
        'checklist',
        'exam_links',
        'completed_checklists',
        'task_progress',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'source_links' => 'array',
        'video_links' => 'array',
        'books' => 'array',
        'checklist' => 'array',
        'exam_links' => 'array',
        'completed_checklists' => 'array',
        'task_progress' => 'array',
    ];
}
