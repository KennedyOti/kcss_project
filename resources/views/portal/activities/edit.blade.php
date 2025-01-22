@extends('layouts.portal')

@section('content')
    <div class="container">
        <h2>Edit Activity</h2>
        <form action="{{ route('activities.update', $activity->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="activityName" class="form-label">Activity Name</label>
                <input type="text" class="form-control" name="activity_name" value="{{ $activity->activity_name }}" required>
            </div>
            <div class="mb-3">
                <label for="activityDescription" class="form-label">Description</label>
                <textarea class="form-control" name="activity_description" rows="3" required>{{ $activity->activity_description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" name="location" value="{{ $activity->location }}" required>
            </div>
            <div class="mb-3">
                <label for="startDate" class="form-label">Start Date</label>
                <input type="date" class="form-control" name="start_date" value="{{ $activity->start_date }}" required>
            </div>
            <div class="mb-3">
                <label for="endDate" class="form-label">End Date</label>
                <input type="date" class="form-control" name="end_date" value="{{ $activity->end_date }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
@endsection
