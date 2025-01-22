<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class ManageActivitiesController extends Controller
{
    /**
     * Display the recent activities and pending requests.
     */
    public function index()
    {
        $recentActivities = Activity::orderBy('created_at', 'desc')->limit(10)->get();
        $pendingRequests = Activity::where('status', 'pending')->orderBy('created_at', 'desc')->get();

        return view('portal.activities.index', compact('recentActivities', 'pendingRequests'));
    }

    /**
     * Approve a pending activity.
     */
    public function approve($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->status = 'approved';
        $activity->save();

        return redirect()->route('activities.index')->with('success', 'Activity approved successfully.');
    }

    /**
     * Decline a pending activity.
     */
    public function decline($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->status = 'declined';
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
        $activity->update($request->all());

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
