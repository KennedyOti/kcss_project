@extends('layouts.portal')

@section('content')
    <div class="container">
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h2 class="mb-4">Manage Activities</h2>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('activities.index') }}" class="mb-4">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="activity_name" class="form-control" placeholder="Activity Name"
                        value="{{ $filters['activity_name'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="organization" class="form-control" placeholder="Organization"
                        value="{{ $filters['organization'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="in_progress" {{ ($filters['status'] ?? '') == 'in_progress' ? 'selected' : '' }}>
                            In Progress
                        </option>
                        <option value="completed" {{ ($filters['status'] ?? '') == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>
                        <option value="cancelled" {{ ($filters['status'] ?? '') == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <!-- Recent Activities Section -->
        <div class="mb-5">
            <h3>Recent Activities</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Activity Name</th>
                        <th>Organization</th>
                        <th>Location</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentActivities as $activity)
                        <tr>
                            <td>{{ $activity->activity_name }}</td>
                            <td>{{ $activity->organization }}</td>
                            <td>{{ $activity->location }}</td>
                            <td>{{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($activity->end_date)->format('d M Y') }}</td>
                            <td>
                                <span
                                    class="badge 
                                @if ($activity->status == 'in_progress') bg-warning 
                                @elseif ($activity->status == 'completed') bg-success 
                                @elseif ($activity->status == 'cancelled') bg-danger @endif">
                                    {{ ucfirst(str_replace('_', ' ', $activity->status)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('activities.show', $activity->id) }}"
                                    class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('activities.edit', $activity->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('activities.destroy', $activity->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No recent activities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
