@extends('layouts.portal')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Manage Reports</h4>
                    </div>

                    <div class="card-body">
                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('reports.index') }}" class="mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="title" class="form-control" placeholder="Report Title"
                                        value="{{ request('title') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="submitted_by" class="form-control"
                                        placeholder="Submitted By" value="{{ request('submitted_by') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                            Approved</option>
                                        <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>
                                            Declined</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="date" name="date_from" class="form-control"
                                            value="{{ request('date_from') }}">
                                        <input type="date" name="date_to" class="form-control"
                                            value="{{ request('date_to') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('reports.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </form>

                        <!-- Reports Table -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Report Title</th>
                                    <th>Date Submitted</th>
                                    <th>Submitted By</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reports as $report)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $report->title }}</td>
                                        <td>{{ $report->date_of_report }}</td>
                                        <td>{{ $report->user ? $report->user->name : 'N/A' }}</td>
                                        <td>
                                            <span
                                                class="badge 
                                            @if ($report->status == 'approved') bg-success 
                                            @elseif ($report->status == 'declined') bg-danger 
                                            @else bg-warning @endif">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('reports.show', $report->id) }}"
                                                class="btn btn-sm btn-info">View</a>
                                            <form action="{{ route('reports.update-status', $report->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                            </form>
                                            <form action="{{ route('reports.update-status', $report->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="declined">
                                                <button type="submit" class="btn btn-sm btn-warning">Decline</button>
                                            </form>
                                            <form action="{{ route('reports.destroy', $report->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this report?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No reports found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
