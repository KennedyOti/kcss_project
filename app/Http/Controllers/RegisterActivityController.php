<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class RegisterActivityController extends Controller
{
    // Method to display the form for creating a new activity
    public function create()
    {
        return view('portal.activities.create');
    }

    // Method to handle storing the new activity
    public function store(Request $request)
    {
        // Validate the form input
        $validated = $request->validate([
            'activity_name' => 'required|string|max:255',
            'activity_description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'actual_beneficiaries' => 'required|integer|min:0',
            'expected_beneficiaries' => 'required|integer|min:0',
        ]);

        // Create a new activity in the database
        Activity::create([
            'activity_name' => $validated['activity_name'],
            'activity_description' => $validated['activity_description'],
            'location' => $validated['location'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'actual_beneficiaries' => $validated['actual_beneficiaries'],
            'expected_beneficiaries' => $validated['expected_beneficiaries'],
        ]);

        // Redirect back to the activity creation form with a success message
        return redirect()->route('activities.create')->with('success', 'Activity registered successfully.');
    }
}
