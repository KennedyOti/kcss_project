<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cases;
use Illuminate\Http\Request;

class ManageCasesController extends Controller
{
    /**
     * Display a listing of the cases.
     */
    public function index()
    {
        $cases = Cases::with('assignedStaff')->paginate(10);
        return view('portal.cases.index', compact('cases'));
    }

    /**
     * Show the form for editing the specified case.
     */
    public function edit($id)
    {
        $case = Cases::findOrFail($id);
        $staffMembers = User::all();
        return view('portal.cases.edit', compact('case', 'staffMembers'));
    }

    /**
     * Update the specified case in the database.
     */
    public function update(Request $request, $id)
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

        $case = Cases::findOrFail($id);

        $validatedData['attachments'] = $request->has('attachments')
            ? json_encode(array_map(fn($file) => $file->store('attachments'), $request->file('attachments')))
            : $case->attachments;

        $case->update($validatedData);

        return redirect()->route('cases.index')->with('success', 'Case updated successfully.');
    }

    /**
     * Remove the specified case from the database.
     */
    public function destroy($id)
    {
        $case = Cases::findOrFail($id);
        $case->delete();

        return redirect()->route('cases.index')->with('success', 'Case deleted successfully.');
    }
    // Show functionality
    public function show($id)
    {
        $case = Cases::findOrFail($id);  // Find the case by ID or throw a 404 error
        return view('portal.cases.show', compact('case'));  // Return the 'cases.show' view with the case data
    }
}
