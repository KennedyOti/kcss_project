@extends('layouts.portal')

@section('content')
    <div class="container">
        <h2>Activity Details</h2>
        <div class="card">
            <div class="card-body">
                <p><strong>Activity Name:</strong> {{ $activity->activity_name }}</p>
                <p><strong>Description:</strong> {{ $activity->activity_description }}</p>
                <p><strong>Location:</strong> {{ $activity->location }}</p>
                <p><strong>Start Date:</strong> {{ $activity->start_date }}</p>
                <p><strong>End Date:</strong> {{ $activity->end_date }}</p>
                <p><strong>Status:</strong> {{ ucfirst($activity->status) }}</p>
            </div>
        </div>
    </div>
@endsection
