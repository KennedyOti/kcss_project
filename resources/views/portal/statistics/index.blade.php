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
                                <div id="cities-map" style="height: 400px;"></div> <!-- Map container -->
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

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.js"></script>

    <!-- JavaScript for Charts -->
    <script>
        // Activities per Month Line Chart
        var activitiesData = @json($activitiesPerMonth);
        var ctxActivities = document.getElementById('activities-chart').getContext('2d');
        var activitiesChart = new Chart(ctxActivities, {
            type: 'line',
            data: {
                labels: activitiesData.map(activity => 'Month ' + activity.month),
                datasets: [{
                    label: 'Total Activities',
                    data: activitiesData.map(activity => activity.total),
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        // Case Status Pie Chart
        var caseStatusData = @json($caseStatuses);
        var ctxCaseStatus = document.getElementById('case-status-chart').getContext('2d');
        var caseStatusChart = new Chart(ctxCaseStatus, {
            type: 'pie',
            data: {
                labels: caseStatusData.map(status => status.status),
                datasets: [{
                    data: caseStatusData.map(status => status.total),
                    backgroundColor: ['#FF9999', '#FFCC00', '#66CC66', '#6699FF', '#FF6666']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        // Most Active Organizations Bar Chart
        var organizationsData = @json($mostActiveOrganizations);
        var ctxOrganizations = document.getElementById('organizations-bar-chart').getContext('2d');
        var organizationsChart = new Chart(ctxOrganizations, {
            type: 'bar',
            data: {
                labels: organizationsData.map(org => org.organization_name || 'Org ' + org.user_id),
                datasets: [{
                    label: 'Activity Count',
                    data: organizationsData.map(org => org.total),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        // Most Active Cities Map
        var citiesData = @json($mostActiveCities);
        var map = L.map('cities-map').setView([0, 0], 2); // Initialize map globally
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        citiesData.forEach(function(city) {
            L.marker([city.latitude, city.longitude]) // Requires latitude and longitude in the data
                .addTo(map)
                .bindPopup('<b>' + city.location + '</b><br>Activities: ' + city.total);
        });
    </script>
@endsection
