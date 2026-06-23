<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    protected $table = 'user_data';

    protected $fillable = [
        'user_id',
        'documents_data',
        'budget_data',
        'practice_chat_history',
        'interview_history',
        'cover_letters'
    ];

    protected $casts = [
        'documents_data' => 'array',
        'budget_data' => 'array',
        'practice_chat_history' => 'array',
        'interview_history' => 'array',
        'cover_letters' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
