@extends('layouts.portal')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Statistics and Analytics</h4>
                    </div>
                    <div class="card-body">
                        <!-- Graphs in a row -->
                        <div class="row">
                            <!-- Total Activities per Month -->
                            <div class="col-md-6">
                                <h5>Total Activities per Month</h5>
                                <canvas id="activities-chart"></canvas>
                            </div>

                            <!-- Case Status Breakdown (Pie Chart) -->
                            <div class="col-md-6">
                                <h5>Case Status Breakdown</h5>
                                <canvas id="case-status-chart"></canvas>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <!-- Most Active Cities (Map or List) -->
                            <div class="col-md-6">
                                <h5>Most Active Cities</h5>
                                <div id="cities-map" style="height: 400px;"></div> <!-- You can use a map library here -->
                            </div>

                            <!-- Most Active Organizations (Bar Chart) -->
                            <div class="col-md-6">
                                <h5>Most Active Organizations</h5>
                                <canvas id="organizations-bar-chart"></canvas>
                            </div>
                        </div>

                        <!-- Download Reports Section -->
                        <h5 class="mt-4">Download Reports</h5>
                        <form action="{{ route('statistics.download') }}" method="POST">
                            @csrf
                            <select name="type" class="form-control">
                                <option value="csv">CSV</option>
                                <option value="excel">Excel</option>
                                <option value="pdf">PDF</option>
                            </select>
                            <button type="submit" class="btn btn-primary mt-3">Download Report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.js"></script> <!-- Ensure Chart.js is correctly loaded -->
    <script>
        // Your JavaScript code remains unchanged
    </script>
@endsection
