<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DtrLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        // Calculate total hours rendered
        $totalHours = $user->getTotalRenderedHours();
        
        // Calculate remaining hours (out of 590)
        $remainingHours = $user->getRemainingHours();
        
        // Calculate progress percentage
        $progressPercentage = $user->getProgressPercentage();
        
        // Estimate remaining days (assuming 8 hours per day)
        $remainingDays = $remainingHours > 0 ? ceil($remainingHours / 8) : 0;
        
        // Get today's DTR
        $todayDtr = DtrLog::forUser($user->id)
            ->today()
            ->first();
        
        // Get this week's stats
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        
        $weekDtrs = DtrLog::forUser($user->id)
            ->whereBetween('date', [$weekStart, $weekEnd])
            ->where('status', 'completed')
            ->get();
        
        $weekDays = $weekDtrs->count();
        $weekHours = $weekDtrs->sum('total_hours');
        
        // Get this month's stats
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
        
        $monthDtrs = DtrLog::forUser($user->id)
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->where('status', 'completed')
            ->get();
        
        $monthDays = $monthDtrs->count();
        $monthHours = $monthDtrs->sum('total_hours');
        
        // Get recent DTR logs (last 5)
        $recentDtrs = DtrLog::forUser($user->id)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard', compact(
            'totalHours',
            'remainingHours',
            'progressPercentage',
            'remainingDays',
            'todayDtr',
            'weekDays',
            'weekHours',
            'monthDays',
            'monthHours',
            'recentDtrs'
        ));
    }
}
