@extends('layouts.portal')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Report</h4>
                    </div>

                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Display Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Report Edit Form -->
                        <form action="{{ route('reports.update', $report->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Report Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Report Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $report->title) }}" required>
                            </div>

                            <!-- Date of Report -->
                            <div class="mb-3">
                                <label for="date_of_report" class="form-label">Date of Report</label>
                                <input type="date" class="form-control" id="date_of_report" name="date_of_report"
                                    value="{{ old('date_of_report', $report->date_of_report) }}" required>
                            </div>

                            <!-- File Upload (Optional) -->
                            <div class="mb-3">
                                <label for="file" class="form-label">Upload New File (Optional)</label>
                                <input type="file" class="form-control" id="file" name="file">
                                <small class="form-text text-muted">Accepted file types: PDF, DOC, DOCX. Max size:
                                    2MB.</small>
                                @if ($report->file_path)
                                    <div class="mt-2">
                                        <strong>Current File:</strong>
                                        <a href="{{ Storage::url($report->file_path) }}" target="_blank">View File</a>
                                    </div>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('reports.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Report</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
