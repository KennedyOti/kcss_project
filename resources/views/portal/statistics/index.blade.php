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
                        <!-- Total Activities per Month -->
                        <h5>Total Activities per Month</h5>
                        <canvas id="activities-chart"></canvas>

                        <!-- Case Status Breakdown (Pie Chart) -->
                        <h5>Case Status Breakdown</h5>
                        <canvas id="case-status-chart"></canvas>

                        <!-- Most Active Cities (Map or List) -->
                        <h5>Most Active Cities</h5>
                        <div id="cities-map" style="height: 400px;"></div> <!-- You can use a map library here -->

                        <!-- Most Active Organizations (Bar Chart) -->
                        <h5>Most Active Organizations</h5>
                        <canvas id="organizations-bar-chart"></canvas>

                        <!-- Download Reports Section -->
                        <h5>Download Reports</h5>
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
        // Activities per Month Line Chart
        var activitiesData = @json($activitiesPerMonth);
        var ctx = document.getElementById('activities-chart').getContext('2d');
        var activitiesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: activitiesData.map(activity => 'Month ' + activity.month),
                datasets: [{
                    label: 'Total Activities',
                    data: activitiesData.map(activity => activity.total),
                    borderColor: 'rgb(75, 192, 192)',
                    fill: false
                }]
            },
            options: {
                responsive: true
            }
        });

        // Case Status Pie Chart
        var caseStatusData =
        @json($caseStatuses); // Update the variable name to match what's passed from the controller
        var ctxCase = document.getElementById('case-status-chart').getContext('2d');
        var caseStatusChart = new Chart(ctxCase, {
            type: 'pie',
            data: {
                labels: caseStatusData.map(status => status.status),
                datasets: [{
                    data: caseStatusData.map(status => status.total),
                    backgroundColor: ['#FF9999', '#FFCC00', '#66CC66'],
                }]
            },
            options: {
                responsive: true
            }
        });

        // Most Active Organizations Bar Chart
        var organizationsData = @json($mostActiveOrganizations);
        var ctxOrg = document.getElementById('organizations-bar-chart').getContext('2d');
        var organizationsChart = new Chart(ctxOrg, {
            type: 'bar',
            data: {
                labels: organizationsData.map(org => 'Org ' + org.user_id),
                datasets: [{
                    label: 'Most Active Organizations',
                    data: organizationsData.map(org => org.total),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
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
                }
            }
        });

        // (Optional) Active Cities Map - Using a map library (e.g., Leaflet.js or Google Maps API)
        var citiesData = @json($mostActiveCities);
        var map = L.map('cities-map').setView([0, 0], 2); // Initialize map centered globally

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        citiesData.forEach(function(city) {
            L.marker([city.latitude, city.longitude]) // You need to include latitude and longitude in your data
                .addTo(map)
                .bindPopup('<b>' + city.location + '</b><br>Activities: ' + city.total);
        });
    </script>
@endsection
