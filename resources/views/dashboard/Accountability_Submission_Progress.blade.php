<!DOCTYPE html>
<div class="container">
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
                            <span class="progress-label">Pending</span>
                        </div>
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{$submitted}}%; background-color: #A5B4FC;">
                            <span class="progress-label">Submitted</span>
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
        {{-- <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Accountability Report</h5>
                </div>
                <div class="panel-body">
                    <div class="stacked-bars">
                        <div class="bar-container">
                            <div class="bar-label">
                                <span>Rejected</span>
                                <span class="count">16</span>
                            </div>
                            <div class="progress" style="height: 24px;">
                                <div class="progress-bar" style="width: 10%; background-color: #EF4444;"></div>
                            </div>
                        </div>
                        
                        <div class="bar-container">
                            <div class="bar-label">
                                <span>Pending</span>
                                <span class="count">45</span>
                            </div>
                            <div class="progress" style="height: 24px;">
                                <div class="progress-bar" style="width: 30%; background-color: #FCD34D;"></div>
                            </div>
                        </div>
                        
                        <div class="bar-container">
                            <div class="bar-label">
                                <span>Accepted</span>
                                <span class="count">2,113</span>
                            </div>
                            <div class="progress" style="height: 24px;">
                                <div class="progress-bar" style="width: 90%; background-color: #4ADE80;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Accountability Report</h5>
                </div>
                <div class="panel-body">
                    <canvas id="stackedBarChart" height="32" width="430" style="border-radius: 15px;"></canvas>
                    <div class="legend mt-3" style="display: flex; align-items: center; gap: 20px;">
                        <div class="legend-item">
                            <span class="dot" style="background: #EF4444;"></span>
                            <span>Rejected</span>
                            <span class="count">{{$haltedCount}}</span>
                        </div>
                        <div class="legend-item">
                            <span class="dot" style="background: #FCD34D;"></span>
                            <span >Pending</span>
                            <span class="count">{{$pendingCount}}</span>
                        </div>
                        <div class="legend-item">
                            <span class="dot" style="background: #4ADE80;"></span>
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
                    backgroundColor: '#EF4444',
                    borderWidth: 0
                }, {
                    label: 'Pending',
                    data: [pendingPerc],
                    backgroundColor: '#FCD34D',
                    borderWidth: 0
                }, {
                    label: 'Accepted',
                    data: [acceptedPerc],
                    backgroundColor: '#4ADE80',
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