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

        <!-- Recent Activities Section -->
        <div class="mb-5">
            <h3>Recent Activities</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Activity Name</th>
                        <th>Date</th>
                        <th>Organization</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentActivities as $activity)
                        <tr>
                            <td>{{ $activity->activity_name }}</td>
                            <td>{{ $activity->created_at->format('d M Y') }}</td>
                            <td>{{ $activity->organization_name ?? 'N/A' }}</td>
                            <td>
                                <span
                                    class="badge 
                                @if ($activity->status == 'in progress') bg-warning 
                                @elseif ($activity->status == 'completed') bg-success @endif">
                                    {{ ucfirst($activity->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-info btn-sm">View</a>
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
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pending Requests Section -->
        <div>
            <h3>Pending Requests</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Activity Name</th>
                        <th>Date</th>
                        <th>Organization</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingRequests as $request)
                        <tr>
                            <td>{{ $request->activity_name }}</td>
                            <td>{{ $request->created_at->format('d M Y') }}</td>
                            <td>{{ $request->organization_name ?? 'N/A' }}</td>
                            <td>
                                <form action="{{ route('activities.approve', $request->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('activities.decline', $request->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Decline</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
