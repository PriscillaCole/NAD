<!DOCTYPE html>
<div class="container-fluid">
    <h4 style="font-size: 16px; margin-bottom: 20px;">Fund Disbursement Summary</h4>
    
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form method="GET" action="{{ request()->url() }}">
                        <div class="form-group" style="margin: 0px">
                            {{-- <label for="program-filter2">{{ __('Select Project') }}</label> --}}
                            <select name="programId2" id="program-filter2" class="form-control" >
                                {{-- <option value="">{{ __('Select Project') }}</option> --}}
                                @php
                                    // Get the selected program from the request or use the first program as the default
                                    $selectedProgramId = request()->query('programId2', $programs->first()->id ?? '');
                                @endphp
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ request()->query('programId2') == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }}
                                    </option> 
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="panel-body text-center" style="height: 228px">
                    <div style="width: 300px; height:200px; margin: 0 auto;">
                        <canvas id="gaugeChart" width="300" height="200"></canvas>
                    </div>
                    <div style="margin-top: -113px;">
                        <h3 style="font-size: 24px; margin: 0;">{{$data[0]?? 0}}%</h3>
                        <p style="color: #2e1a1a; font-size: 14px;">Budget: ${{$budget ?? 0}}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                            <h5 class="panel-title" style="margin-top: 7px;">Funds disbursed</h5>
                        
                        <form method="GET" action="{{ request()->url() }}">
                        <div class="col-xs-6 text-right">
                            <select class="form-control input-sm" name="year" id='year-filter'  style="width: 100px; display: inline-block;">
                                @php
                                    $currentYear = date('Y'); // Get the current year dynamically
                                    $startYear = 2020; // Set the starting year
                                @endphp
                                
                                @for ($year = $currentYear; $startYear <= $year; $year--)
                                    <option value="{{ $year }}" {{ request()->query('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        </form>
                </div>
                <div class="panel-body">
                    <canvas id="lineChart" width="400" height="165"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.panel {
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12);
    margin-bottom: 20px;
}
.panel-heading {
    background-color: #fff !important;
    border-bottom: 1px solid #eee;
    padding: 10px 15px;
}
.panel-body {
    padding: 20px;
}
select.form-control {
    border-radius: 4px;
}

/* .container {
    width: max-content;
} */
</style>

<script>
    if (document.readyState === 'loading') {
    console.log('DOM is still loading...');
        const programSelect = document.getElementById('program-filter2');
        const yearSelect = document.getElementById('year-filter');
        
        // If no program is selected, select the first one
        if (!programSelect.value && programSelect.options.length > 0) {
            programSelect.selectedIndex = 0;
        }
        if (!yearSelect.value && yearSelect.options.length > 0) {
            yearSelect.selectedIndex = 0;
        }  
        
        // Handle program select change
        programSelect.addEventListener('change', function() {
            const currentYear = new Date().getFullYear();
            const url = `dashboard?programId2=${this.value}&year=${yearSelect.value}`;
            window.location.href = url;
        });
        yearSelect.addEventListener('change', function() {
            // const currentYear = new Date().getFullYear();
            const url = `dashboard?programId2=${programSelect.value}&year=${this.value}`;
            window.location.href = url;
        });
        
        // Trigger initial load if no program is selected
        if (!window.location.search.includes('programId2')) {
            const currentYear = new Date().getFullYear();
            const url = `dashboard?programId2=${programSelect.value}&year=${currentYear}`;
            window.location.href = url;
        }
    

    if (programSelect) {
        console.log('Program Select found while DOM is loading:', programSelect);
    }
} else {
    console.log('DOM has already been loaded.');
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gauge Chart
    var gaugeCtx = document.getElementById('gaugeChart').getContext('2d');
    const chartData = @json($data);
    new Chart(gaugeCtx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: chartData,
                backgroundColor: [
                    '#4B49AC',  // Blue for used
                    '#E9ECEF'   // Gray for remaining
                ],
                borderWidth: 0,
                circumference: 180,
                rotation: -90
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutoutPercentage: 80,
            legend: {
                display: false
            },
            tooltips: {
                enabled: false
            }
        }
    });

    // Line Chart
    var lineCtx = document.getElementById('lineChart').getContext('2d');
    const fundData = @json($fund);
    let monthlyData = Array(12).fill(0);

    Object.keys(fundData).forEach(month => {
        monthlyData[month - 1] = fundData[month]; // Convert month (1-based) to array index (0-based)
    });

    console.log("Monthly Data for Chart:", monthlyData);

    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Disbursed Funds',
                data: monthlyData ,
                borderColor: '#4CAF50',
                backgroundColor: 'rgba(76, 175, 80, 0.1)',
                borderWidth: 2,
                pointRadius: 3,
                pointBackgroundColor: '#4CAF50',
                fill: true,
                tension: 0.4
            }]
        },
        // data: fundData,

        options: {
            responsive: true,
            maintainAspectRatio: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false
                    }
                }],
                yAxes: [{
                    ticks: {
                        callback: function(value) {
                            return 'Ugx' + value;
                        },
                        beginAtZero: true
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem) {
                        return 'Ugx' + tooltipItem.yLabel.toFixed(2);
                    }
                }
            }
        }
    });
});
</script>


