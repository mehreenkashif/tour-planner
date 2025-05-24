
@extends('layouts.app')

@section('content')


<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Dashboard Charts -->
<div class="container">
    <h1 >Admin Dashboard</h1>
<div class="row g-4 mt-4">


    <!-- Bar Chart -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-primary">Tours per Planner</h6>
                <canvas id="barChart" height="220"></canvas>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-warning">Tours by Status</h6>
                <div style="width: 425px; height: 425px; margin: auto;">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Line Chart -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-success">Monthly Tour Creation Trend</h6>
                <canvas id="lineChart" maxHeight="100"></canvas>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Chart Scripts -->
<script>
    // Bar Chart
    const barLabels = @json($toursPerPlanner->pluck('name'));
    const barData = @json($toursPerPlanner->pluck('tours_count'));
    new Chart(document.getElementById('barChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [{
                label: 'Tours',
                data: barData,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
    y: {
        min: 0,
        max: 10,
        ticks: {
            stepSize: 1
        }
    }
}

        }
    });

    // Pie Chart
    const pieLabels = ['Upcoming', 'Ongoing', 'Ended'];
    const pieData = [{{ $toursByStatus['upcoming'] }}, {{ $toursByStatus['ongoing'] }}, {{ $toursByStatus['ended'] }}];
    new Chart(document.getElementById('pieChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: pieLabels,
            maintainAspectRatio: false,
            datasets: [{
                data: pieData,
                backgroundColor: [
                    'rgba(255, 206, 86, 0.7)',   // Yellow
                    'rgba(54, 162, 235, 0.7)',   // Blue
                    'rgba(255, 99, 132, 0.7)'    // Red
                ],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { enabled: true }
            }
        }
    });

    // Line Chart
    const lineLabels = @json($lineChartLabels);
    const lineData = @json($lineChartData);
    new Chart(document.getElementById('lineChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: lineLabels,

            datasets: [{
                label: 'Tours Created',
                data: lineData,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                pointRadius: 4

            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: { enabled: true }
            },
            scales: {
                y: { beginAtZero: true, precision: 0 }
            }
        }
    });
</script>

@endsection
