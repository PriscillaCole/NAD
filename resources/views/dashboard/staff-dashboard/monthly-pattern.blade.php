<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .card {
        border: 1px solid orange;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        /* padding around */
        padding: 10px;
        width: 100%;
    }
</style>
<div class="card">
<div class="card-header3">
    <h3 class="card-title">{{ __('Monthly Leave Pattern')}}</h3>
</div>
<div style="width: 80%; margin: auto;">
    <canvas id="monthlyPatternChart" width="400" height="400"></canvas>
</div>
</div>


<script>
    var monthsData = {!! json_encode($monthlyPattern->groupBy('month')->map->count()->toArray()) !!};
    var monthLabels = [];
    var monthValues = [];

    // Prepare data for all months
    for (var i = 1; i <= 12; i++) {
        var monthName = new Date(2000, i - 1, 1).toLocaleString('en-us', { month: 'long' });
        monthLabels.push(monthName);
        monthValues.push(monthsData[i] || 0); // If no data available for the month, set count to 0
    }

    var ctx = document.getElementById('monthlyPatternChart').getContext('2d');
    var monthlyPatternChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Frequency of Leave Requests',
                data: monthValues,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                fill: true // Add fill to show shadow below the line
            }]
        },
        options: {
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Frequency'
                    },
                    beginAtZero: true
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
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
</script>
