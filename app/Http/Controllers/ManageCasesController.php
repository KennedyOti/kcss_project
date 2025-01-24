<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cases;
use Illuminate\Http\Request;

class ManageCasesController extends Controller
{
    /**
     * Display a listing of the cases with filters.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $filters = [
            'client_name' => $request->input('client_name'),
            'description' => $request->input('description'),
            'assigned_staff' => $request->input('assigned_staff'),
            'status' => $request->input('status'),
            'start_date_from' => $request->input('start_date_from'),
            'start_date_to' => $request->input('start_date_to'),
        ];

        // Query with filters
        $cases = Cases::with('assignedStaff')
            ->when($filters['client_name'], function ($query, $clientName) {
                $query->where('client_name', 'like', "%{$clientName}%");
            })
            ->when($filters['description'], function ($query, $description) {
                $query->where('description', 'like', "%{$description}%");
            })
            ->when($filters['assigned_staff'], function ($query, $staffId) {
                $query->where('assigned_staff_id', $staffId);
            })
            ->when($filters['status'], function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($filters['start_date_from'], function ($query, $dateFrom) {
                $query->whereDate('start_date', '>=', $dateFrom);
            })
            ->when($filters['start_date_to'], function ($query, $dateTo) {
                $query->whereDate('start_date', '<=', $dateTo);
            })
            ->paginate(10);

        $staffMembers = User::all(); // Fetch staff members for the filter dropdown

        return view('portal.cases.index', compact('cases', 'filters', 'staffMembers'));
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

    /**
     * Show the details of a specific case.
     */
    public function show($id)
    {
        $case = Cases::findOrFail($id);
        return view('portal.cases.show', compact('case'));
    }
}
