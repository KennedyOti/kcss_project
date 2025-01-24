@extends('layouts.portal')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- Success Message -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Cases List</h4>
                        <a href="{{ route('cases.create') }}" class="btn btn-primary">Create New Case</a>
                    </div>

                    <div class="card-body">
                        @if ($cases->isEmpty())
                            <p class="text-center">No cases available. <a href="{{ route('cases.create') }}">Create one
                                    now.</a></p>
                        @else
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client Name</th>
                                        <th>Description</th>
                                        <th>Assigned Staff</th>
                                        <th>Status</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cases as $case)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $case->client_name }}</td>
                                            <td>{{ Str::limit($case->description, 50) }}</td>
                                            <td>{{ $case->assignedStaff->name }}</td>
                                            <td>
                                                <span
                                                    class="badge 
                                                    @if ($case->status == 'pending') bg-warning 
                                                    @elseif($case->status == 'in_progress') bg-info 
                                                    @else bg-success @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                                                </span>
                                            </td>
                                            <td>{{ $case->start_date }}</td>
                                            <td>{{ $case->end_date ?? 'N/A' }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('cases.show', $case->id) }}"
                                                        class="btn btn-sm btn-info me-2">View</a>
                                                    <a href="{{ route('cases.edit', $case->id) }}"
                                                        class="btn btn-sm btn-warning me-2">Edit</a>
                                                    <form action="{{ route('cases.destroy', $case->id) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this case?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    @if ($cases->hasPages())
                        <div class="card-footer">
                            {{ $cases->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
