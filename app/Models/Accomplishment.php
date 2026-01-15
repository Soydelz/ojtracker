<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomplishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'task_description',
        'tools_used',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the user that owns the accomplishment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get accomplishments for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
