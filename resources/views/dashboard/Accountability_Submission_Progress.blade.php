<!DOCTYPE html>
<div class="container-fluid">
    <h4 style="font-size: 16px; margin-bottom: 20px;">Accountability Submission Progress</h4>
    
    {{-- <div class="row">
        <!-- Left Panel - Accountability Status -->
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Accountability status</h5>
                    
                </div>
                <div class="panel-body">
                    <div class="progress" style="height: 24px; margin-bottom: 10px; background-color: #f0f0f0;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{ $pending > 0 ? $pending : 1 }}%; background-color: #6366F1;">
                            <span class="progress-label">Pending({{$pending}}%)</span>
                        </div>
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{ $submitted > 0 ? $submitted : 1 }}%; background-color: #A5B4FC;">
                            <span class="progress-label">Submitted({{$submitted}}%)</span>
                        </div>
                    </div>
                    <div class="legend" style="display: flex; justify-content: flex-start; gap: 20px;">
                        <div>
                            <span class="dot" style="background-color: #6366F1;"></span>
                            Pending
                        </div>
                        <div>
                            <span class="dot" style="background-color: #A5B4FC;"></span>
                            Submitted
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        
        <!-- Right Panel - Accountability Report -->
        
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Accountability Report</h5>
                </div>
                <div class="panel-body">
                    @php
                        $total = $haltedCount + $pendingCount + $acceptedCount;
                        $rejectedPerc = $total == 0 ? 0 : round(($haltedCount / $total) * 100, 0);
                        $pendingPerc  = $total == 0 ? 0 : round(($pendingCount / $total) * 100, 0);
                        $acceptedPerc = $total == 0 ? 0 : round(($acceptedCount / $total) * 100, 0);

        
                    @endphp
                    <div class="progress" style="height: 24px; margin-bottom: 10px; background-color: #f0f0f0;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{ $rejectedPerc > 0 ? $rejectedPerc : 1 }}%; background-color: #303053;">
                            <span class="progress-label">Rejected({{$rejectedPerc}}%)</span>
                        </div>
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{ $pendingPerc > 0 ? $pendingPerc : 1 }}%; background-color: #8383f3;">
                            <span class="progress-label">Pending({{$pendingPerc}}%)</span>
                        </div>
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{ $acceptedPerc > 0 ? $acceptedPerc : 1 }}%; background-color: #A5B4FC;">
                            <span class="progress-label">Accepted({{$acceptedPerc}}%)</span>
                        </div>
                    </div>
                    
                    <div class="legend mt-3" style="display: flex; align-items: center; gap: 20px;">
                        <div class="legend-item">
                            <span class="dot" style="background: #303053;"></span>
                            <span>Rejected</span>
                            <span class="count">{{$haltedCount}}</span>
                        </div>
                        <div class="legend-item">
                            <span class="dot" style="background: #8383f3;"></span>
                            <span >Pending</span>
                            <span class="count">{{$pendingCount}}</span>
                        </div>
                        <div class="legend-item">
                            <span class="dot" style="background: #bcbcee ;"></span>
                            <span >Accepted</span>
                            <span class="count">{{$acceptedCount}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="accountability-grid">
        <!-- Accountability Status -->
        <div class="chart-card" style="height: 222px">
            <div class="card-header">
                <h3 class="card-title">Accountability Status</h3>
            </div>
            
            <div class="progress-container">
                <div class="progress-bar">
                    <div class="progress-segments">
                        <div class="progress-segment progress-pending" style="width: {{ $pending > 0 ? $pending : 0 }}%;"></div>
                        <div class="progress-segment progress-submitted" style="width: {{ $submitted > 0 ? $submitted : 0 }}%;"></div>
                    </div>
                </div>
                
                <div class="progress-labels">
                    <div class="progress-label">
                        <div class="label-dot dot-pending"></div>
                        <span>Pending ({{ $pending > 0 ? $pending : 0 }}%)</span>
                    </div>
                    <div class="progress-label">
                        <div class="label-dot dot-submitted"></div>
                        <span>Submitted ({{ $submitted > 0 ? $submitted : 0 }}%)</span>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 2rem;">
                <div style="font-size: 2rem; font-weight: 700; color: #2d3748; margin-bottom: 0.5rem;">
                    {{$haltedCount + $pendingCount + $acceptedCount}} Total
                </div>
                <div style="color: #718096;">
                    Accountability Reports
                </div>
            </div>
        </div>

        <!-- Accountability Report -->
        <div class="chart-card" style="height: 222px">
            <div class="card-header">
                <h3 class="card-title">Accountability Report</h3>
            </div>
            
            <div class="report-stats">
                <div class="stat-circle">
                    <div class="stat-circle-bg stat-rejected">{{$haltedCount}}</div>
                    <div class="stat-circle-label">Rejected</div>
                </div>
                
                <div class="stat-circle">
                    <div class="stat-circle-bg stat-pending">{{$pendingCount}}</div>
                    <div class="stat-circle-label">Pending</div>
                </div>
                
                <div class="stat-circle">
                    <div class="stat-circle-bg stat-accepted">{{$acceptedCount}}</div>
                    <div class="stat-circle-label">Accepted</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <style>
        .panel {
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            margin-bottom: 20px;
            border: none;
        }
        .panel-heading {
            background-color: #fff !important;
            border-bottom: 1px solid #eee;
            padding: 15px;
        }
        .panel-body {
            padding: 20px;
        }
        .progress {
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 10px;
            background-color: #f0f0f0;
        }
        
        .dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }
        .bar-container {
            margin-bottom: 15px;
        }
        .bar-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 14px;
        }
        .count {
            font-weight: bold;
        }
        .stacked-bars .progress {
            margin-bottom: 15px;
        }
</style> --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('stackedBarChart').getContext('2d');
        const haltedCount = @json($haltedCount); // Pass data from the backend
        const pendingCount = @json($pendingCount); // Pass data from the backend
        const acceptedCount = @json($acceptedCount); // Pass data from the backend

        
        // Calculate percentages
        const total = haltedCount + pendingCount + acceptedCount;
        const rejectedPerc = (haltedCount / total) * 100;
        const pendingPerc = (pendingCount / total) * 100;
        const acceptedPerc = (acceptedCount / total) * 100;
        
        new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'Rejected',
                    data: [rejectedPerc],
                    backgroundColor: '#303053',
                    borderWidth: 0
                }, {
                    label: 'Pending',
                    indexAxis:'y',
                    data: [pendingPerc],
                    backgroundColor: '#8383f3',
                    borderWidth: 0
                }, {
                    label: 'Accepted',
                    data: [acceptedPerc],
                    backgroundColor: '#bcbcee',
                    borderWidth: 0
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                },
                scales: {
                    xAxes: [{
                        stacked: true,
                        display: false,
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        display: false,
                        gridLines: {
                            display: false
                        }
                    }]
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                }
            }
        });
    });
</script> --}}