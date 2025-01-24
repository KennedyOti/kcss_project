<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Report;
use Illuminate\Http\Request;

class ManageReportsController extends Controller
{
    /**
     * Display a listing of the reports.
     */
    public function index()
    {
        // Ensure the relationship 'user' is used correctly, and data is fetched with 'user_id'
        $reports = Report::with('user')->orderBy('created_at', 'desc')->get();
        return view('portal.reports.index', compact('reports'));
    }

    /**
     * Show the details of a specific report.
     */
    public function show($id)
    {
        // Use the correct relationship name 'user' as defined in the Report model
        $report = Report::with('user')->findOrFail($id);
        return view('portal.reports.show', compact('report'));
    }

    /**
     * Update the report details.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date_of_report' => 'required|date',
        ]);

        $report = Report::findOrFail($id);
        $report->title = $request->input('title');
        $report->date_of_report = $request->input('date_of_report');

        if ($request->hasFile('file')) {
            // Delete the old file if it exists
            if ($report->file_path) {
                Storage::delete($report->file_path);
            }

            // Save the new file
            $filePath = $request->file('file')->store('reports');
            $report->file_path = $filePath;
        }

        $report->save();

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }

    /**
     * Update the status of the report (Approve/Decline).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,declined',
        ]);

        $report = Report::findOrFail($id);
        $report->status = $request->input('status');
        $report->save();

        return redirect()->route('reports.index')->with('success', 'Report status updated successfully.');
    }

    /**
     * Delete the specified report.
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        // Optionally delete the associated file from storage
        if ($report->file_path) {
            Storage::delete($report->file_path); // Use Storage facade correctly
        }

        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }
}
