<!-- resources/views/dashboard/budget_comparison_chart.blade.php -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Budget vs Actual Spending') }}</h3>
    </div>
    <div class="card-body">
        <!-- Program filter dropdown -->
        <form method="GET" action="{{ request()->url() }}">
            <div class="form-group">
                <label for="program-filter2">{{ __('Select Project') }}</label>
                <select name="programId2" id="program-filter2" class="form-control" onchange="this.form.submit()">
                    <option value="">{{ __('Select Project') }}</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" {{ request()->query('programId2') == $program->id ? 'selected' : '' }}>
                            {{ $program->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <!-- Check if there are any requisitions for the selected project -->
        @if(count($chartData) > 0)
            <!-- Chart Container -->
            <div class="chart-container">
                <canvas id="budgetComparisonChart"></canvas>
            </div>
        @else
            <!-- No requisitions message -->
            <div class="alert alert-warning" role="alert">
                {{ __('No budgets available for the selected program.') }}
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Example of handling a single chart
        const chartElement = document.getElementById('budgetComparisonChart');
        if (chartElement) {
            const ctx = chartElement.getContext('2d');
            const chartData = @json($chartData); // Pass data from the backend

            const labels = chartData.map(item => item.name);
            const budgetData = chartData.map(item => item.budget);
            const amountUsedData = chartData.map(item => item.amount_used);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Initial Budget',
                            data: budgetData,
                            backgroundColor: 'rgba(0, 123, 255, 0.6)',
                            borderColor: 'rgba(0, 123, 255, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Amount Used',
                            data: amountUsedData,
                            backgroundColor: 'rgba(220, 53, 69, 0.6)',
                            borderColor: 'rgba(220, 53, 69, 1)',
                            borderWidth: 1
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
                                    return tooltipItem.dataset.label + ': UGX ' + tooltipItem.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'UGX ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
