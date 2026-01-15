<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DtrLog;
use App\Services\NotificationService;
use Carbon\Carbon;

class DtrController extends Controller
{
    /**
     * Display all DTR records
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Get search query and per page
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);
        
        // Get all DTR logs ordered by date descending with search
        $query = DtrLog::forUser($user->id);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('notes', 'LIKE', "%{$search}%")
                  ->orWhereRaw("DATE_FORMAT(date, '%M %d, %Y') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("DATE_FORMAT(date, '%b %d, %Y') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("DATE_FORMAT(date, '%Y-%m-%d') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("DATE_FORMAT(date, '%M') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("DATE_FORMAT(date, '%W') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("DATE_FORMAT(date, '%d') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("DATE_FORMAT(date, '%Y') LIKE ?", ["%{$search}%"]);
            });
        }
        
        $dtrLogs = $query->orderBy('date', 'desc')->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);
        
        // Calculate totals
        $totalHours = $user->getTotalRenderedHours();
        $remainingHours = $user->getRemainingHours();
        
        return view('dtr.index', compact('dtrLogs', 'totalHours', 'remainingHours', 'search'));
    }

    /**
     * Store manually created DTR record
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        // Validate input
        $validated = $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i|after:time_in',
            'break_hours' => 'nullable|numeric|min:0|max:8',
            'notes' => 'nullable|string|max:500',
        ], [
            'date.before_or_equal' => 'Cannot add DTR for future dates.',
            'time_out.after' => 'Time out must be after time in.',
        ]);
        
        // Check if DTR already exists for this date
        $existingDtr = DtrLog::forUser($user->id)
            ->whereDate('date', $validated['date'])
            ->first();
        
        if ($existingDtr) {
            return redirect()->back()
                ->withErrors(['date' => 'DTR record already exists for this date.'])
                ->withInput();
        }
        
        // Combine date with time
        $timeIn = Carbon::parse($validated['date'] . ' ' . $validated['time_in']);
        $timeOut = Carbon::parse($validated['date'] . ' ' . $validated['time_out']);
        
        // Calculate hours (subtract break)
        $rawHours = $timeOut->diffInMinutes($timeIn) / 60;
        $breakHours = $validated['break_hours'] ?? 0;
        $totalHours = $rawHours - $breakHours;
        
        // Create DTR record
        DtrLog::create([
            'user_id' => $user->id,
            'date' => $validated['date'],
            'time_in' => $timeIn,
            'time_out' => $timeOut,
            'break_hours' => $breakHours,
            'total_hours' => $totalHours,
            'status' => 'completed',
            'notes' => $validated['notes'],
        ]);
        
        return redirect()->route('dtr.index')->with('success', 'DTR record added successfully! Total hours: ' . number_format($totalHours, 2));
    }

    /**
     * Handle time in
     */
    public function timeIn(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();
        
        // Check if already timed in today
        $existingDtr = DtrLog::forUser($user->id)
            ->whereDate('date', $today)
            ->first();
        
        if ($existingDtr) {
            return redirect()->back()->with('error', 'You have already timed in today!');
        }
        
        // Use manual time if provided, otherwise use current time
        $timeIn = $request->manual_time_in 
            ? Carbon::parse($today->format('Y-m-d') . ' ' . $request->manual_time_in)
            : Carbon::now();
        
        // Create new DTR record
        DtrLog::create([
            'user_id' => $user->id,
            'date' => $today,
            'time_in' => $timeIn,
            'break_hours' => 1,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);
        
        return redirect()->route('dashboard')->with('success', 'Successfully timed in!');
    }
    
    /**
     * Handle time out
     */
    public function timeOut(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();
        
        // Get today's DTR
        $dtr = DtrLog::forUser($user->id)
            ->whereDate('date', $today)
            ->first();
        
        if (!$dtr) {
            return redirect()->back()->with('error', 'No time in record found for today!');
        }
        
        if ($dtr->time_out) {
            return redirect()->back()->with('error', 'You have already timed out today!');
        }
        
        // Use manual time if provided, otherwise use current time
        $timeOut = $request->manual_time_out 
            ? Carbon::parse($today->format('Y-m-d') . ' ' . $request->manual_time_out)
            : Carbon::now();
        
        // Update time out, notes, and calculate hours
        $dtr->time_out = $timeOut;
        if ($request->notes) {
            $dtr->notes = $request->notes;
        }
        $dtr->calculateTotalHours();
        
        // Check milestones after time out
        NotificationService::checkMilestones($user);
        
        return redirect()->route('dashboard')->with('success', 'Successfully timed out! Total hours: ' . number_format($dtr->total_hours, 2));
    }
}
