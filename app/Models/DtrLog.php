<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DtrLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'time_in',
        'time_out',
        'break_hours',
        'total_hours',
        'status',
        'notes',
        'face_photo',
        'face_confidence',
    ];

    protected $casts = [
        'date' => 'date',
        'time_in' => 'datetime',
        'time_out' => 'datetime',
        'break_hours' => 'decimal:2',
        'total_hours' => 'decimal:2',
        'face_confidence' => 'decimal:2',
    ];

    /**
     * Get the user that owns the DTR log
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate total hours between time in and time out
     */
    public function calculateTotalHours()
    {
        if ($this->time_in && $this->time_out) {
            $timeIn = Carbon::parse($this->time_in);
            $timeOut = Carbon::parse($this->time_out);
            
            $rawHours = $timeOut->diffInMinutes($timeIn) / 60;
            $this->total_hours = $rawHours - ($this->break_hours ?? 0);
            $this->status = 'completed';
            $this->save();
        }
    }

    /**
     * Scope to get DTR logs for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get today's DTR
     */
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }
}
