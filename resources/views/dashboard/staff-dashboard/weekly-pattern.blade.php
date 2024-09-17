<!DOCTYPE html>
<html>
<head>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Weekly Leave Pattern</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('weekly-pattern') }}" method="GET" id="filterForm">
                @csrf <!-- Ensure CSRF token is included for Laravel -->
                <label for="month">Select Month:</label>
                <select name="month" id="month">
                    <option value="1" {{ $selectedMonth == 1 ? 'selected' : '' }}>January</option>
                    <option value="2" {{ $selectedMonth == 2 ? 'selected' : '' }}>February</option>
                    <option value="3" {{ $selectedMonth == 3 ? 'selected' : '' }}>March</option>
                    <option value="4" {{ $selectedMonth == 4 ? 'selected' : '' }}>April</option>
                    <option value="5" {{ $selectedMonth == 5 ? 'selected' : '' }}>May</option>
                    <option value="6" {{ $selectedMonth == 6 ? 'selected' : '' }}>June</option>
                    <option value="7" {{ $selectedMonth == 7 ? 'selected' : '' }}>July</option>
                    <option value="8" {{ $selectedMonth == 8 ? 'selected' : '' }}>August</option>
                    <option value="9" {{ $selectedMonth == 9 ? 'selected' : '' }}>September</option>
                    <option value="10" {{ $selectedMonth == 10 ? 'selected' : '' }}>October</option>
                    <option value="11" {{ $selectedMonth == 11 ? 'selected' : '' }}>November</option>
                    <option value="12" {{ $selectedMonth == 12 ? 'selected' : '' }}>December</option>
                </select>
                <button type="submit">Filter</button>
            </form>
            <canvas id="weeklyPatternChart" width="400" height="400"></canvas>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('weeklyPatternChart').getContext('2d');
        var weeklyPatternChart;

        function updateChart(daysOfWeek, counts) {
            // If chart already exists, destroy it before re-rendering
            if (weeklyPatternChart) {
                weeklyPatternChart.destroy();
            }

            weeklyPatternChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: daysOfWeek,
                    datasets: [{
                        label: 'Number of Leave Requests',
                        data: counts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Leave Requests'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Day of the Week'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        }

        // Initial rendering of the chart
        updateChart(@json($daysOfWeek), @json($counts));

        // Handle form submission to update chart
        document.getElementById('filterForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            var url = '{{ route("weekly-pattern") }}?' + new URLSearchParams(formData).toString();

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                updateChart(data.daysOfWeek, data.counts);
            })
            .catch(error => console.error('Error fetching data:', error));
        });
    });
</script>

</body>
</html>
