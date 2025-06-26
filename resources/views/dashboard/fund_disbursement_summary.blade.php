<!DOCTYPE html>
<div class="container-fluid">
    <h4 style="font-size: 16px; margin-bottom: 20px;">Fund Disbursement Summary</h4>
    
    <div class="row">
        <div class="col-md-6">
            {{-- <div class="panel panel-default">
                <div class="panel-heading">
                    
                </div>
                <div class="panel-body text-center" style="height: 228px">
                    <div style="width: 300px; height:200px; margin: 0 auto;">
                        <canvas id="gaugeChart" width="300" height="200"></canvas>
                    </div>
                    <div style="margin-top: -113px;">
                        <h3 style="font-size: 24px; margin: 0;">{{$data[0]?? 0}}%</h3>
                        <p style="color: #2e1a1a; font-size: 14px;">Budget: ${{number_format($budget ?? 0)}}</p>
                    </div>
                </div>
            </div> --}}
            <div class="chart-card">
            <div class="card-header">
                <h3 class="card-title">Budget Utilization</h3>
                <form method="GET" action="{{ request()->url() }}">
                    <div class="year-selector" style="margin: 0px">
                        <select name="programId2" id="program-filter2" class="year-dropdown" >
                            @php
                                // Get the selected program from the request or use the first program as the default
                                $selectedProgramId = request()->query('programId2', $programs->first()->id ?? '');
                            @endphp
                            @foreach($programs as $program)
                                <option style="color: black" value="{{ $program->id }}" {{ request()->query('programId2') == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}
                                </option> 
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            
            <div class="budget-container">
                <div class="budget-circle">
                    <svg class="progress-ring" width="200" height="200">
                        <defs>
                            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" style="stop-color:#667eea"/>
                                <stop offset="100%" style="stop-color:#764ba2"/>
                            </linearGradient>
                        </defs>
                        
                        <circle class="progress-ring-bg" cx="100" cy="100" r="90"/>
                        <circle class="progress-ring-fill" cx="100" cy="100" r="90" data-percentage="{{$data[0]?? 0}}"/>

                        {{-- <circle class="progress-ring-fill" cx="100" cy="100" r="90"/> --}}
                    </svg>
                    <div class="budget-text">
                        <div class="budget-percentage">{{$data[0]?? 0}}%</div>
                        <div class="budget-amount">Used</div>
                    </div>
                </div>
                
                <div class="budget-stats">
                    <div class="stat-item">
                        <div class="stat-value">UGX 171K</div>
                        <div class="stat-label">Disbursed</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">UGX {{number_format($budget ?? 0)}}</div>
                        <div class="stat-label">Total Budget</div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
        
        <div class="col-md-6">
            {{-- <div class="panel panel-default">
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
            </div> --}}
            <!-- Funds Disbursed Chart -->
            <div class="chart-card">
                <div class="card-header">
                    <h3 class="card-title">Funds Disbursed</h3>
                    <form method="GET" action="{{ request()->url() }}">
                        <div class="year-selector">
                            <select class="year-dropdown" name="year" id='year-filter'  style="width: 100px; display: inline-block;">
                                @php
                                    $currentYear = date('Y'); // Get the current year dynamically
                                    $startYear = 2020; // Set the starting year
                                @endphp
                                
                                @for ($year = $currentYear; $startYear <= $year; $year--)
                                    <option style="color: black" value="{{ $year }}" {{ request()->query('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        </form>
                </div>
                <div class="chart-container">
                    <canvas id="disbursementChart"></canvas>
                </div>
            </div>
        </div>
       
    </div>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem;
        color: #2d3748;
    } */

    .container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: white;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-icon {
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    /* Fund Disbursement Section */
    .disbursement-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .chart-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .chart-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
    }

    .year-selector {
        position: relative;
    }

    .year-dropdown {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .year-dropdown:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    /* Budget Progress Circle */
    .budget-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 300px;
    }

    .budget-circle {
        position: relative;
        width: 200px;
        height: 200px;
        margin-bottom: 1rem;
    }

    .progress-ring {
        transform: rotate(-90deg);
    }

    .progress-ring-bg {
        fill: none;
        stroke: #e2e8f0;
        stroke-width: 12;
    }

    .progress-ring-fill {
        fill: none;
        stroke: url(#gradient);
        stroke-width: 12;
        stroke-linecap: round;
        stroke-dasharray: 565.48;
        stroke-dashoffset: 565.48;
        transition: stroke-dashoffset 2s ease-in-out;
        /* animation: fillProgress 2s ease-in-out forwards; */
    }

    @keyframes fillProgress {
        to {
            stroke-dashoffset: 562.48; /* 0.5% used */
        }
    }

    .budget-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .budget-percentage {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.25rem;
    }

    .budget-amount {
        font-size: 1rem;
        color: #718096;
        font-weight: 500;
    }

    .budget-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        width: 100%;
        margin-top: 1rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        background: rgba(102, 126, 234, 0.05);
        border-radius: 12px;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #718096;
    }

    /* Line Chart Container */
    .chart-container {
        position: relative;
        height: 300px;
    }

    /* Accountability Section */
    .accountability-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .accountability-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: white;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* Progress Bar */
    .progress-container {
        margin-bottom: 2rem;
        display: grid;
    }

    .progress-bar {
        width: 100%;
        height: 12px;
        background: #e2e8f0;
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .progress-segments {
        display: flex;
        height: 100%;
    }

    .progress-segment {
        transition: all 0.5s ease;
    }

    .progress-pending {
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        /* width: 67%; */
    }

    .progress-submitted {
        background: linear-gradient(90deg, #a855f7, #7c3aed);
        width: 33%;
    }

    .progress-labels {
        display: flex;
        justify-content: space-between;
        margin-top: 1rem;
    }

    .progress-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    .label-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .dot-pending { background: #3b82f6; }
    .dot-submitted { background: #a855f7; }

    /* Report Stats */
    .report-stats {
        display: flex;
        justify-content: space-around;
        align-items: center;
        height: 200px;
        margin-top: -56px;
    }

    .stat-circle {
        text-align: center;
        position: relative;
    }

    .stat-circle-bg {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 2rem;
        font-weight: 700;
        color: white;
    }

    .stat-rejected { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .stat-pending { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stat-accepted { background: linear-gradient(135deg, #10b981, #059669); }

    .stat-circle-label {
        font-size: 0.875rem;
        color: #4a5568;
        font-weight: 500;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .disbursement-grid,
        .accountability-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }
        
        .budget-stats {
            grid-template-columns: 1fr;
        }
        
        .report-stats {
            flex-direction: column;
            gap: 2rem;
            height: auto;
            padding: 2rem 0;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const circle = document.querySelector('.progress-ring-fill');
    const radius = circle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;

    const percent = parseFloat(circle.dataset.percentage) || 0;
    const offset = circumference - (percent / 100) * circumference;
    console.log('circle.dataset.percentage', circle.dataset.percentage)
    console.log('percent', offset)
    circle.style.strokeDasharray = `${circumference} ${circumference}`;
    circle.style.strokeDashoffset = offset;

    // if (document.readyState === 'loading') {
    // console.log('DOM is still loading...');
        const programSelect = document.getElementById('program-filter2');
        const yearSelect = document.getElementById('year-filter');
        console.log('going to the program select')
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
    // } else {
    //     console.log('DOM has already been loaded.');
    // }

    const ctx = document.getElementById('disbursementChart').getContext('2d');
    const fundData = @json($fund);
    let monthlyData = Array(12).fill(0);

    Object.keys(fundData).forEach(month => {
        monthlyData[month - 1] = fundData[month]; // Convert month (1-based) to array index (0-based)
    });

    console.log("Monthly Data for Chart:", monthlyData);
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Funds Disbursed (UGX)',
                // data: [0, 0, 0, 0, 0, 150000, 0, 0, 0, 0, 0, 0],
                data: monthlyData ,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#718096',
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(113, 128, 150, 0.1)'
                    },
                    ticks: {
                        color: '#718096',
                        font: {
                            size: 12
                        },
                        callback: function(value) {
                            return 'UGX' + (value / 1000) + 'K';
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script> --}}
{{-- <script>
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
</script> --}}
