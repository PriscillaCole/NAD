<!DOCTYPE html>
<div class="container-fluid">
    <h4 style="font-size: 16px; margin-bottom: 20px;">Accountability Submission Progress</h4>
    
    <div class="row">
        <!-- Left Panel - Accountability Status -->
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Accountability status</h5>
                    {{-- <small class="text-muted" style="float: right;">Total: 31,863</small> --}}
                </div>
                <div class="panel-body">
                    <div class="progress" style="height: 24px; margin-bottom: 10px; background-color: #f0f0f0;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{$pending}}%; background-color: #6366F1;">
                            <span class="progress-label">Pending({{$pending}}%)</span>
                        </div>
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{$submitted}}%; background-color: #A5B4FC;">
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
                        $rejectedPerc = ($haltedCount / $total) * 100;
                        $pendingPerc = ($pendingCount / $total) * 100;
                        $acceptedPerc = ($acceptedCount / $total) * 100;
        
                    @endphp
                    <div class="progress" style="height: 24px; margin-bottom: 10px; background-color: #f0f0f0;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{$rejectedPerc}}%; background-color: #303053;">
                            <span class="progress-label">Pending({{$rejectedPerc}}%)</span>
                        </div>
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{$pendingPerc}}%; background-color: #8383f3;">
                            <span class="progress-label">Submitted({{$pendingPerc}}%)</span>
                        </div>
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{$acceptedPerc}}%; background-color: #A5B4FC;">
                            <span class="progress-label">Submitted({{$acceptedPerc}}%)</span>
                        </div>
                    </div>
                    {{-- <canvas id="stackedBarChart" height="32" style="border-radius: 15px;"></canvas> --}}
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
    </div>
</div>

<style>
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
        .progress-label {
            color: white;
            padding: 0 10px;
            line-height: 24px;
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
</style>
<script>
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
    </script>