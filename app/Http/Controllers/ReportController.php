<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DtrLog;
use App\Models\Accomplishment;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display reports page
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Get filter parameters
        $filter = $request->input('filter', 'this_week');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Determine date range
        switch ($filter) {
            case 'this_week':
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
                break;
            case 'this_month':
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
                break;
            case 'last_month':
                $start = Carbon::now()->subMonth()->startOfMonth();
                $end = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'custom':
                $start = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfMonth();
                $end = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfDay();
                break;
            default:
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
        }
        
        // Get DTR records for the period
        $dtrRecords = DtrLog::forUser($user->id)
            ->whereBetween('date', [$start, $end])
            ->orderBy('date', 'desc')
            ->get();
        
        // Get accomplishments for the period
        $accomplishments = Accomplishment::forUser($user->id)
            ->whereBetween('date', [$start, $end])
            ->orderBy('date', 'desc')
            ->get();
        
        // Calculate statistics
        $totalHours = $dtrRecords->where('status', 'completed')->sum('total_hours');
        $daysCompleted = $dtrRecords->where('status', 'completed')->count();
        $accomplishmentsCount = $accomplishments->count();
        
        // Calculate average hours per day
        $avgHoursPerDay = $daysCompleted > 0 ? $totalHours / $daysCompleted : 0;
        
        return view('reports.index', compact(
            'dtrRecords',
            'accomplishments',
            'totalHours',
            'daysCompleted',
            'accomplishmentsCount',
            'avgHoursPerDay',
            'filter',
            'start',
            'end',
            'startDate',
            'endDate'
        ));
    }
    
    /**
     * Export report to PDF
     */
    public function exportPdf(Request $request)
    {
        $user = auth()->user();
        
        // Get filter parameters
        $filter = $request->input('filter', 'this_week');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Determine date range
        switch ($filter) {
            case 'this_week':
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
                break;
            case 'this_month':
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
                break;
            case 'last_month':
                $start = Carbon::now()->subMonth()->startOfMonth();
                $end = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'custom':
                $start = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfMonth();
                $end = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfDay();
                break;
            default:
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
        }
        
        // Get DTR records for the period
        $dtrRecords = DtrLog::forUser($user->id)
            ->whereBetween('date', [$start, $end])
            ->orderBy('date', 'asc')
            ->get();
        
        // Get accomplishments for the period
        $accomplishments = Accomplishment::forUser($user->id)
            ->whereBetween('date', [$start, $end])
            ->orderBy('date', 'asc')
            ->get();
        
        // Calculate statistics
        $totalHours = $dtrRecords->where('status', 'completed')->sum('total_hours');
        $daysCompleted = $dtrRecords->where('status', 'completed')->count();
        $accomplishmentsCount = $accomplishments->count();
        $avgHoursPerDay = $daysCompleted > 0 ? $totalHours / $daysCompleted : 0;
        
        // Generate PDF
        $pdf = Pdf::loadView('reports.pdf', compact(
            'user',
            'dtrRecords',
            'accomplishments',
            'totalHours',
            'daysCompleted',
            'accomplishmentsCount',
            'avgHoursPerDay',
            'start',
            'end'
        ));
        
        $filename = 'OJT_Report_' . $start->format('Y-m-d') . '_to_' . $end->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}
