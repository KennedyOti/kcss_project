<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class ManageActivitiesController extends Controller
{
    /**
     * Display the recent activities and pending requests with filters.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $filters = [
            'activity_name' => $request->input('activity_name'),
            'organization' => $request->input('organization'),
            'status' => $request->input('status'),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
        ];

        // Query recent activities with filters
        $recentActivities = Activity::query()
            ->when($filters['activity_name'], function ($query, $activityName) {
                $query->where('activity_name', 'like', "%{$activityName}%");
            })
            ->when($filters['organization'], function ($query, $organization) {
                $query->where('organization', 'like', "%{$organization}%");
            })
            ->when($filters['status'], function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($filters['date_from'], function ($query, $dateFrom) {
                $query->whereDate('start_date', '>=', $dateFrom);
            })
            ->when($filters['date_to'], function ($query, $dateTo) {
                $query->whereDate('end_date', '<=', $dateTo);
            })
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        // Query pending requests
        $pendingRequests = Activity::query()
            ->where('status', 'in_progress')
            ->orderBy('start_date', 'desc')
            ->get();

        return view('portal.activities.index', compact('recentActivities', 'pendingRequests', 'filters'));
    }

    /**
     * Approve a pending activity.
     */
    public function approve($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->status = 'completed';
        $activity->save();

        return redirect()->route('activities.index')->with('success', 'Activity approved successfully.');
    }

    /**
     * Decline a pending activity.
     */
    public function decline($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->status = 'cancelled';
        $activity->save();

        return redirect()->route('activities.index')->with('success', 'Activity declined successfully.');
    }

    /**
     * View a specific activity.
     */
    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        return view('portal.activities.show', compact('activity'));
    }

    /**
     * Edit a specific activity.
     */
    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        return view('portal.activities.edit', compact('activity'));
    }

    /**
     * Update a specific activity.
     */
    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);

        $validated = $request->validate([
            'activity_name' => 'required|string|max:255',
            'activity_description' => 'required|string',
            'location' => 'required|string|max:255',
            'status' => 'required|in:in_progress,cancelled,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'actual_beneficiaries' => 'required|integer|min:0',
            'expected_beneficiaries' => 'required|integer|min:0',
        ]);

        $activity->update($validated);

        return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
    }

    /**
     * Delete a specific activity.
     */
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
    }
}
