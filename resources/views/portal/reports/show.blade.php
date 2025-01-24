@extends('layouts.portal')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Report Details</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Title:</strong> {{ $report->title }}</p>
                        <p><strong>Date of Report:</strong> {{ $report->date_of_report }}</p>
                        <p><strong>Submitted By:</strong> {{ $report->user->name }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($report->status) }}</p>
                        @if ($report->file_path)
                            <p>
                                <strong>File:</strong>
                                <a href="{{ Storage::url($report->file_path) }}" target="_blank">View Report</a>
                            </p>
                        @endif
                        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
