<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateCaseController extends Controller
{
    /**
     * Show the form for creating a new case.
     */
    public function create()
    {
        $staffMembers = User::all(); // Adjust to fetch staff members if there's a role distinction
        return view('portal.cases.create', compact('staffMembers'));
    }

    /**
     * Store a newly created case in the database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string',
            'assigned_staff_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,in_progress,resolved',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240', // Max 10MB per file
        ]);

        $validatedData['client_name'] = Auth::user()->name; // Automatically set client_name to the logged-in user's name
        $validatedData['attachments'] = $request->has('attachments')
            ? json_encode(array_map(fn($file) => $file->store('attachments'), $request->file('attachments')))
            : null;

        Cases::create($validatedData);

        return redirect()->route('cases.create')->with('success', 'Case created successfully.');
    }
}
