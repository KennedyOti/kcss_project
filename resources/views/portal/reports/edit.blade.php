@extends('layouts.portal')

@section('content')
    <div class="container">
        <h2>Edit Report</h2>
        <form action="{{ route('reports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="{{ $report->title }}" required>
            </div>

            <div class="mb-3">
                <label for="date_of_report" class="form-label">Date of Report</label>
                <input type="date" class="form-control" name="date_of_report" value="{{ $report->date_of_report }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">Upload File (Optional)</label>
                <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx">
                @if ($report->file_path)
                    <small>Current file: <a href="{{ Storage::url($report->file_path) }}" target="_blank">View
                            File</a></small>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
@endsection
