<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreateReportController extends Controller
{
    /**
     * Show the form for creating a new report.
     */
    public function create()
    {
        return view('portal.reports.create');
    }

    /**
     * Store a newly created report in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'date_of_report' => 'required|date',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048', // Allow only specific file types
        ]);

        try {
            // Handle file upload
            $filePath = $request->file('file')->store('reports', 'public');

            // Create the report record
            Report::create([
                'title' => $request->title,
                'date_of_report' => $request->date_of_report,
                'file_path' => $filePath,
                'user_id' => Auth::id(), // Assign the current authenticated user
                'status' => 'submitted', // Default status
            ]);

            // Success message
            return redirect()->route('reports.create')->with('success', 'Report submitted successfully!');
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            report($e);

            // Error message
            return redirect()->route('reports.create')->with('error', 'There was an error submitting the report. Please try again.');
        }
    }
}
