<!-- Pie Chart in a Card -->
<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Activity Requisitions by Project') }}</h3>
        </div>
        <div class="card-body">
            <!-- Program filter dropdown -->
            <form method="GET" action="{{ request()->url() }}">
                <div class="form-group">
                    <label for="program-filter">{{ __('Select Project') }}</label>
                    <select name="programId" id="program-filter" class="form-control" onchange="this.form.submit()">
                        <option value="">{{ __('Select Project') }}</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ request()->query('programId') == $program->id ? 'selected' : '' }}>
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
                <canvas id="activityRequisitionChart"></canvas>
                </div>
            @else
                <!-- No requisitions message -->
                <div class="alert alert-warning" role="alert">
                    {{ __('No requisitions available for the selected project.') }}
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
   @if(count($chartData) > 0)
    const ctx = document.getElementById('activityRequisitionChart').getContext('2d');

    const chartData = @json($chartData);
    const labels = chartData.map(item => item.label);
    const values = chartData.map(item => item.value);

    // Create the pie chart with adjusted size
    const activityRequisitionChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Amount Requested',
                data: values,
                backgroundColor: ['#007bff', '#dc3545', '#28a745', '#ffc107', '#17a2b8'],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Allows you to set a specific height
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': UGX ' + tooltipItem.raw.toLocaleString();
                        }
                    }
                }
            },
            layout: {
                padding: 20 // Add padding if needed
            }
        }
    });
@endif

</script>
