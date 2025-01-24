<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Cases; // Assuming your Case model is named CaseModel
use App\Models\Report;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Display the statistics dashboard.
     */
    public function index()
    {
        // Total Activities per Month (using Carbon for better date handling)
        $activitiesPerMonth = Activity::select(DB::raw('MONTH(start_date) as month, COUNT(*) as total'))
            ->groupBy(DB::raw('MONTH(start_date)'))
            ->orderBy(DB::raw('MONTH(start_date)'))
            ->get()
            ->map(function ($activity) {
                // Return the data in a more readable format
                return [
                    'month' => Carbon::createFromFormat('m', $activity->month)->format('F'), // Month name instead of number
                    'total' => $activity->total
                ];
            });

        // Case Status Breakdown (Pending, In Progress, Resolved)
        $caseStatuses = Cases::select(DB::raw('status, COUNT(*) as total'))
            ->groupBy('status')
            ->get()
            ->map(function ($case) {
                // Map status names for better visualization (optional)
                return [
                    'status' => $case->status,
                    'total' => $case->total
                ];
            });

        // Most Active Cities (Top 5 by total activities)
        $mostActiveCities = Activity::select('location', DB::raw('COUNT(*) as total'))
            ->groupBy('location')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($city) {
                // You may need to add latitude and longitude here if using a map visualization
                return [
                    'location' => $city->location,
                    'total' => $city->total
                    // Add 'latitude' and 'longitude' if available for map rendering
                ];
            });

        // Most Active Organizations (Top 5)
        $mostActiveOrganizations = Report::select('user_id', DB::raw('COUNT(*) as total'))
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($org) {
                return [
                    'user_id' => $org->user_id,
                    'total' => $org->total
                ];
            });

        // Prepare Data for Charts and Reports
        return view('portal.statistics.index', compact(
            'activitiesPerMonth',
            'caseStatuses',
            'mostActiveCities',
            'mostActiveOrganizations'
        ));
    }

    /**
     * Generate and download reports as CSV, PDF, or Excel.
     */
    public function downloadReport(Request $request)
    {
        // Handle CSV, PDF, or Excel downloads based on user selection
        // For simplicity, assume you use packages like Laravel Excel or DomPDF for downloads.
        // Example for CSV:
        if ($request->type == 'csv') {
            return $this->downloadCSV();
        }

        // Handle other types (Excel/PDF)
        // Example for Excel using Laravel Excel package:
        // return Excel::download(new StatisticsExport, 'statistics.xlsx');
    }

    // Helper function for downloading CSV
    private function downloadCSV()
    {
        $reports = Report::all();
        $csvFile = fopen('php://output', 'w');
        fputcsv($csvFile, ['ID', 'Title', 'Date', 'User', 'Status']);

        foreach ($reports as $report) {
            fputcsv($csvFile, [
                $report->id,
                $report->title,
                $report->date_of_report,
                $report->user->name,
                $report->status,
            ]);
        }

        fclose($csvFile);

        // Return CSV download response
        return response()->stream(function () use ($csvFile) {
            fpassthru($csvFile);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="reports.csv"',
        ]);
    }
}
