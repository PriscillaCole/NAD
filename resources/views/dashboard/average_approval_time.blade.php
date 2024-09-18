<!-- resources/views/dashboard/average_approval_time_chart.blade.php -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Average Approval Time by Month') }}</h3>
    </div>
    <div class="card-body">
        <!-- Period filter dropdown -->
        <form method="GET" action="{{ request()->url() }}">
            <div class="form-group mb-4">
                <label for="period-filter">{{ __('Select Period') }}</label>
                <select name="period" id="period-filter" class="form-control" onchange="this.form.submit()">
                    <option value="month" {{ request()->query('period') == 'month' ? 'selected' : '' }}>
                        {{ __('Monthly') }}
                    </option>
                    <option value="year" {{ request()->query('period') == 'year' ? 'selected' : '' }}>
                        {{ __('Yearly') }}
                    </option>
                </select>
            </div>
        </form>

        <!-- Check if there is data for the selected period -->
        @if(count($chartData) > 0)
            <!-- Chart Container -->
            <div class="chart-container mb-4">
                <canvas id="averageApprovalTimeChart"></canvas>
            </div>
        @else
            <!-- No data message -->
            <div class="alert alert-warning" role="alert">
                {{ __('No approval data available for the selected period.') }}
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartElement = document.getElementById('averageApprovalTimeChart');
        if (chartElement) {
            const ctx = chartElement.getContext('2d');
            const chartData = @json($chartData); // Pass data from the backend

            const labels = chartData.map(item => item.period);
            const avgDaysData = chartData.map(item => item.avg_days);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Average Approval Time (Days)',
                            data: avgDaysData,
                            backgroundColor: 'rgba(40, 167, 69, 0.2)',
                            borderColor: 'rgba(40, 167, 69, 1)',
                            borderWidth: 2,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.dataset.label + ': ' + tooltipItem.raw.toFixed(2) + ' days';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Period'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Average Days'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toFixed(2);
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>


