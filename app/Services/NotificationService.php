<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Create a notification for a user
     */
    public static function create($userId, $type, $title, $message, $icon = null, $link = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'icon' => $icon,
            'link' => $link,
        ]);
    }

    /**
     * Check if user forgot to time out and send reminder
     */
    public static function checkTimeOutReminder($user)
    {
        $todayDtr = $user->dtrLogs()->today()->first();
        
        if ($todayDtr && $todayDtr->time_in && !$todayDtr->time_out) {
            $hoursElapsed = now()->diffInHours($todayDtr->time_in);
            
            // If more than 9 hours have passed, send reminder
            if ($hoursElapsed >= 9) {
                self::create(
                    $user->id,
                    'reminder',
                    '⏰ Time Out Reminder',
                    "You haven't timed out yet today. Don't forget to log your time out!",
                    '⏰',
                    route('dashboard')
                );
            }
        }
    }

    /**
     * Check and notify milestones
     */
    public static function checkMilestones($user)
    {
        $progress = $user->getProgressPercentage();
        $milestones = [25, 50, 75, 100];
        
        foreach ($milestones as $milestone) {
            // Check if user just reached this milestone
            if ($progress >= $milestone) {
                $alreadyNotified = Notification::forUser($user->id)
                    ->where('type', 'milestone')
                    ->where('title', 'like', "%{$milestone}%")
                    ->exists();
                
                if (!$alreadyNotified) {
                    $emoji = $milestone == 100 ? '🎉' : '🎯';
                    $message = $milestone == 100 
                        ? 'Congratulations! You have completed your OJT requirement!' 
                        : "You've reached {$milestone}% of your OJT hours. Keep up the great work!";
                    
                    self::create(
                        $user->id,
                        'milestone',
                        "{$emoji} {$milestone}% Milestone Reached!",
                        $message,
                        $emoji,
                        route('dashboard')
                    );
                }
            }
        }
    }

    /**
     * Send weekly progress summary
     */
    public static function sendWeeklyProgressSummary($user)
    {
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        
        $weekHours = $user->dtrLogs()
            ->whereBetween('date', [$weekStart, $weekEnd])
            ->where('status', 'completed')
            ->sum('total_hours');
        
        self::create(
            $user->id,
            'progress',
            '📊 Weekly Progress Summary',
            "This week, you've completed " . number_format($weekHours, 2) . " hours of OJT. " . number_format($user->getRemainingHours(), 2) . " hours remaining.",
            '📊',
            route('reports.index')
        );
    }

    /**
     * Send system notification
     */
    public static function sendSystemNotification($userId, $title, $message, $icon = '📢', $link = null)
    {
        self::create(
            $userId,
            'system',
            $title,
            $message,
            $icon,
            $link
        );
    }

    /**
     * Welcome notification for new users
     */
    public static function sendWelcomeNotification($user)
    {
        self::create(
            $user->id,
            'system',
            '👋 Welcome to OJTracker!',
            "Welcome {$user->name}! Start tracking your OJT hours by logging your Time In/Out on the Dashboard.",
            '👋',
            route('dashboard')
        );
    }
}
