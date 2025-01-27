<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;

class RegisterActivityController extends Controller
{
    /**
     * Display the form for creating a new activity.
     */
    public function create()
    {
        return view('portal.activities.create');
    }

    /**
     * Store a newly created activity in storage.
     */
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

        // Add the organization field
        $validated['organization'] = Auth::user()->name ?? 'Default Organization';

        // Create a new activity in the database
        Activity::create($validated);

        // Redirect to the create form with a success message
        return redirect()->route('activities.create')->with('success', 'Activity registered successfully.');
    }
}
