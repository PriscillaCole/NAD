
<!DOCTYPE html>
<div class="container-fluid" style="background-color: white; ">
    <h4>Fund Request Status Overview</h4>
    
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Requisition Status</h5>
                </div>
                <div class="panel-body" style="display: flex">
                    <div class="chart-legend">
                        <canvas id="pieChart" width="250" height="200" ></canvas>
                    </div>
                    <div class="chart-legend" style="margin-top: 88px;">
                        <div class="row">
                           <span class="legend-dot" style="background-color: #4CAF50"></span> Approved
                        </div>
                        <div class="row">
                            <span class="legend-dot" style="background-color: #FFC107"></span> Pending
                        </div>
                        <div class="row">
                            <span class="legend-dot" style="background-color: #FF5252"></span> Rejected
                        </div>
                        <div class="row">
                            <span class="legend-dot" style="background-color: #90CAF9"></span> Amended
                        </div>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Requisition Status</h5>
                </div>
                <div class="panel-body">
                    <canvas id="funnelChart" height="115"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.legend-dot {
    display: inline-block;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 5px;
}
.panel {
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12);
}
.panel-heading {
    background-color: #fff !important;
    border-bottom: 1px solid #eee;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pie Chart
    var pieCtx = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Approved', 'Pending', 'Rejected', 'Amended'],
            datasets: [{
                data: [{{ $approvedCount }}, {{ $pendingCount }}, {{ $rejectedCount }}, {{ $ammendedCount }}],
                backgroundColor: [
                    '#4CAF50',  // Green
                    '#FFC107',  // Yellow
                    '#FF5252',  // Red
                    '#90CAF9'   // Blue
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            legend: {
                display: false
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return data.labels[tooltipItem.index] + ': ' + 
                               data.datasets[0].data[tooltipItem.index] + '%';
                    }
                }
            }
        }
    });

    // Funnel Chart (using modified bar chart)
    var funnelCtx = document.getElementById('funnelChart').getContext('2d');

    var pending = ({{$pendingCount}} / {{$total}}) * 100
    var accepted = ({{$acceptedCount}} / {{$total}}) * 100
    var approved = ({{$approvedCount}} / {{$total}}) * 100

    var funnelChart = new Chart(funnelCtx, {
        type: 'horizontalBar',
        data: {
            labels: ['Submitted', 'Finance Manager', 'Country Director', 'Approved'],
            datasets: [{
                data: [100, pending, accepted, approved],
                backgroundColor: [
                    '#00BCD4',  // Cyan
                    '#E91E63',  // Pink
                    '#9C27B0',  // Purple
                    '#4CAF50'   // Green
                ],
                borderWidth: 0
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    display: false,
                    ticks: {
                        beginAtZero: true,
                        max: 100
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false
                    }
                }]
            }
        }
    });
});
</script>
