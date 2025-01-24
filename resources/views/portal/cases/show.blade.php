@extends('layouts.portal')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Case Details</h4>
                    </div>

                    <div class="card-body">
                        <p><strong>Client Name:</strong> {{ $case->client_name }}</p>
                        <p><strong>Description:</strong> {{ $case->description }}</p>
                        <p><strong>Assigned Staff:</strong> {{ $case->assignedStaff->name }}</p>
                        <p><strong>Status:</strong>
                            <span
                                class="badge 
                                @if ($case->status == 'pending') bg-warning 
                                @elseif($case->status == 'in_progress') bg-info 
                                @else bg-success @endif">
                                {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                            </span>
                        </p>
                        <p><strong>Start Date:</strong> {{ $case->start_date }}</p>
                        <p><strong>End Date:</strong> {{ $case->end_date ?? 'N/A' }}</p>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cases.index') }}" class="btn btn-secondary">Back to Cases List</a>
                            <a href="{{ route('cases.edit', $case->id) }}" class="btn btn-warning">Edit Case</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
