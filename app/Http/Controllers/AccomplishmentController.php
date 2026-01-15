<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accomplishment;
use Carbon\Carbon;

class AccomplishmentController extends Controller
{
    /**
     * Display all accomplishments
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Get search query and per page
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);
        
        // Get all accomplishments ordered by date descending
        $query = Accomplishment::forUser($user->id);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('task_description', 'LIKE', "%{$search}%")
                  ->orWhere('tools_used', 'LIKE', "%{$search}%")
                  ->orWhereRaw("DATE_FORMAT(date, '%M %d, %Y') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("DATE_FORMAT(date, '%b %d, %Y') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("DATE_FORMAT(date, '%M') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("DATE_FORMAT(date, '%W') LIKE ?", ["%{$search}%"]);
            });
        }
        
        $accomplishments = $query->orderBy('date', 'desc')->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);
        
        // Calculate totals
        $totalAccomplishments = Accomplishment::forUser($user->id)->count();
        
        return view('accomplishments.index', compact('accomplishments', 'totalAccomplishments', 'search'));
    }

    /**
     * Store new accomplishment
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        // Validate input
        $validated = $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'task_description' => 'required|string|max:1000',
            'tools_used' => 'nullable|string|max:255',
        ], [
            'date.before_or_equal' => 'Cannot add accomplishment for future dates.',
        ]);
        
        // Create accomplishment
        Accomplishment::create([
            'user_id' => $user->id,
            'date' => $validated['date'],
            'task_description' => $validated['task_description'],
            'tools_used' => $validated['tools_used'],
        ]);
        
        return redirect()->route('accomplishments.index')->with('success', 'Accomplishment added successfully!');
    }

    /**
     * Update accomplishment
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        
        $accomplishment = Accomplishment::forUser($user->id)->findOrFail($id);
        
        // Validate input
        $validated = $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'task_description' => 'required|string|max:1000',
            'tools_used' => 'nullable|string|max:255',
        ]);
        
        $accomplishment->update($validated);
        
        return redirect()->route('accomplishments.index')->with('success', 'Accomplishment updated successfully!');
    }

    /**
     * Delete accomplishment
     */
    public function destroy($id)
    {
        $user = auth()->user();
        
        $accomplishment = Accomplishment::forUser($user->id)->findOrFail($id);
        $accomplishment->delete();
        
        return redirect()->route('accomplishments.index')->with('success', 'Accomplishment deleted successfully!');
    }
}

