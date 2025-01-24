<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Activity;
use App\Models\Cases; // Replace 'CaseModel' with the actual model name
use App\Models\Report;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch real-time data
        $data = [
            'registered_users' => User::count(),
            'total_activities' => Activity::count(),
            'total_cases' => Cases::count(),
            'pending_cases' => Cases::where('status', 'pending')->count(),
            'resolved_cases' => Cases::where('status', 'resolved')->count(),
            'total_reports' => Report::count(),
            'approved_reports' => Report::where('status', 'approved')->count(),
            'declined_reports' => Report::where('status', 'declined')->count(),
        ];

        return view('portal.dashboard', compact('data'));
    }
}
