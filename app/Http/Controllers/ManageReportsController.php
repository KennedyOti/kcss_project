<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Report;
use Illuminate\Http\Request;

class ManageReportsController extends Controller
{
    /**
     * Display a listing of the reports with filters.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $filters = [
            'title' => $request->input('title'),
            'status' => $request->input('status'),
            'user_name' => $request->input('user_name'),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
        ];

        // Query with filters
        $reports = Report::with('user')
            ->when($filters['title'], function ($query, $title) {
                $query->where('title', 'like', "%{$title}%");
            })
            ->when($filters['status'], function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($filters['user_name'], function ($query, $userName) {
                $query->whereHas('user', function ($q) use ($userName) {
                    $q->where('name', 'like', "%{$userName}%");
                });
            })
            ->when($filters['date_from'], function ($query, $dateFrom) {
                $query->whereDate('date_of_report', '>=', $dateFrom);
            })
            ->when($filters['date_to'], function ($query, $dateTo) {
                $query->whereDate('date_of_report', '<=', $dateTo);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('portal.reports.index', compact('reports', 'filters'));
    }

    /**
     * Show the details of a specific report.
     */
    public function show($id)
    {
        $report = Report::with('user')->findOrFail($id);
        return view('portal.reports.show', compact('report'));
    }

    /**
     * Show the form for editing a specific report.
     */
    public function edit($id)
    {
        $report = Report::findOrFail($id);
        return view('portal.reports.edit', compact('report'));
    }

    /**
     * Update the report details.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date_of_report' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // Allow optional file upload
        ]);

        $report = Report::findOrFail($id);
        $report->title = $validated['title'];
        $report->date_of_report = $validated['date_of_report'];

        if ($request->hasFile('file')) {
            // Delete old file if it exists
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
        $validated = $request->validate([
            'status' => 'required|in:approved,declined',
        ]);

        $report = Report::findOrFail($id);
        $report->status = $validated['status'];
        $report->save();

        return redirect()->route('reports.index')->with('success', 'Report status updated successfully.');
    }

    /**
     * Delete the specified report.
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        // Delete associated file if it exists
        if ($report->file_path) {
            Storage::delete($report->file_path);
        }

        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }
}
