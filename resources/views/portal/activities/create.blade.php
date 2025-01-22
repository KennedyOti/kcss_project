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

        <!-- Activity Registration Form -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h2>Register New Activity</h2>
                <div class="card">
                    <div class="card-body">
                        <form id="activityForm" action="{{ route('activities.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="activityName" class="form-label">Activity Name</label>
                                <input type="text" class="form-control" name="activity_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="activityDescription" class="form-label">Description</label>
                                <textarea class="form-control" name="activity_description" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" name="location" list="cities" required>
                                <datalist id="cities">
                                    <option value="Nairobi">
                                    <option value="Mombasa">
                                    <option value="Kisumu">
                                        <!-- Add more cities dynamically -->
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" name="start_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" class="form-control" name="end_date" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="actualBeneficiaries" class="form-label">Number of Beneficiaries</label>
                                    <input type="number" class="form-control" name="actual_beneficiaries" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="expectedBeneficiaries" class="form-label">Expected Beneficiaries</label>
                                    <input type="number" class="form-control" name="expected_beneficiaries" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
