<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'required_hours',
        'school',
        'profile_picture',
        'cover_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the DTR logs for the user
     */
    public function dtrLogs()
    {
        return $this->hasMany(DtrLog::class);
    }

    /**
     * Get the accomplishments for the user
     */
    public function accomplishments()
    {
        return $this->hasMany(Accomplishment::class);
    }

    /**
     * Get the notifications for the user
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get total rendered hours for the user
     */
    public function getTotalRenderedHours()
    {
        return $this->dtrLogs()->where('status', 'completed')->sum('total_hours');
    }

    /**
     * Get remaining hours based on user's required hours
     */
    public function getRemainingHours()
    {
        $totalRequired = $this->required_hours ?? 590;
        $rendered = $this->getTotalRenderedHours();
        return max(0, $totalRequired - $rendered);
    }

    /**
     * Get progress percentage
     */
    public function getProgressPercentage()
    {
        $totalRequired = $this->required_hours ?? 590;
        $rendered = $this->getTotalRenderedHours();
        return min(100, round(($rendered / $totalRequired) * 100, 2));
    }

    /**
     * Get required days based on required hours
     * Formula: 590 hours = 75 days, so days = hours / 7.867
     */
    public function getRequiredDays()
    {
        $hoursPerDay = 7.867; // 590 hours / 75 days
        return ceil(($this->required_hours ?? 590) / $hoursPerDay);
    }
}
