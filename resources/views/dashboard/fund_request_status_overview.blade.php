
<!DOCTYPE html>
<div class="container-fluid" style="background-color: white; ">
    {{-- <h4>Fund Request Status Overview</h4> --}}
    
    <div class="row">
        <div class="col-md-6">
           {{--  <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Requisition Status</h5>
                </div>
                <div class="panel-body" style="display: flex">
                    <div class="chart-legend" style="max-width: 500px">
                        <canvas id="pieChart"  height="200" ></canvas>
                    </div>
                    
                </div>
            </div> --}}
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Fund Request Status Overview</h3>
                    <p class="chart-subtitle">Distribution of requisition statuses</p>
                </div>
                <div class="chart-container" style="height: 180px;">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            {{-- <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Requisition Status</h5>
                </div>
                <div class="panel-body">
                    <canvas id="funnelChart" height="115"></canvas>
                </div>
            </div> --}}
            <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Requisition Progress</h3>
                        <p class="chart-subtitle">Current processing status</p>
                    </div>
                    <div style="padding-top: 2rem;">
                        <div class="status-item">
                            <span class="status-label">Submitted</span>
                            <div class="status-bar">
                                <div class="status-progress submitted"></div>
                            </div>
                            <span class="status-count">{{$total}}</span>
                        </div>
                        <div class="status-item">
                            <span class="status-label">Finance Manager</span>
                            <div class="status-bar">
                                <div class="status-progress finance"></div>
                            </div>
                            <span class="status-count">{{$pendingCount}}</span>
                        </div>
                        <div class="status-item">
                            <span class="status-label">Country Director</span>
                            <div class="status-bar">
                                <div class="status-progress approved"></div>
                            </div>
                            <span class="status-count">{{$acceptedCount}}</span>
                        </div>
                        <div class="status-item">
                            <span class="status-label">Approved</span>
                            <div class="status-bar">
                                <div class="status-progress approved"></div>
                            </div>
                            <span class="status-count">{{$approvedCount}}</span>
                        </div>
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
        /* border-bottom: 1px solid #eee; */
        border-color:transparent !important; 
    }
</style>
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .content{
            background: white;
        }

        /* body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #2d3748;
        } */

        /* .dashboard {
            display: flex;
            min-height: 100vh;
        } */

        /* Sidebar */
        /* .sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2rem 0;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        } */

        .logo {
            padding: 0 2rem 2rem;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            margin-bottom: 2rem;
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .user-info {
            padding: 0 2rem 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-details h3 {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d3748;
        }

        .user-details p {
            font-size: 0.8rem;
            color: #718096;
        }

        /* .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin: 0.25rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            text-decoration: none;
            color: #4a5568;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .nav-link:hover:not(.active) {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
        } */

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        .header {
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
        }

        /* KPI Cards */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .kpi-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .kpi-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .kpi-icon.pending { background: rgba(251, 146, 60, 0.15); color: #f59e0b; }
        .kpi-icon.approved { background: rgba(34, 197, 94, 0.15); color: #22c55e; }
        .kpi-icon.finance { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
        .kpi-icon.director { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
        .kpi-icon.total { background: rgba(168, 85, 247, 0.15); color: #a855f7; }
        .kpi-icon.funds { background: rgba(16, 185, 129, 0.15); color: #10b981; }

        .kpi-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
        }

        .kpi-label {
            font-size: 1.1rem;
            color: #718096;
            font-weight: 500;
        }

        /* Charts Section */
        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .chart-header {
            margin-bottom: 1.5rem;
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .chart-subtitle {
            color: #718096;
            font-size: 0.9rem;
        }


        /* Status Bars */
        .status-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .status-item:last-child {
            border-bottom: none;
        }

        .status-label {
            font-weight: 500;
            color: #4a5568;
        }

        .status-bar {
            flex: 1;
            height: 8px;
            background: #f7fafc;
            border-radius: 4px;
            margin: 0 1rem;
            overflow: hidden;
        }

        .status-progress {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .status-progress.submitted { background: linear-gradient(90deg, #06b6d4, #0891b2); width: 85%; }
        .status-progress.finance { background: linear-gradient(90deg, #ec4899, #db2777); width: 45%; }
        .status-progress.approved { background: linear-gradient(90deg, #10b981, #059669); width: 95%; }

        .status-count {
            font-weight: 600;
            color: #2d3748;
            min-width: 40px;
            text-align: right;
        }

        /* @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .kpi-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
        } */
    </style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script> --}}


<script>
    // Initialize the pie chart
    const ctx = document.getElementById('pieChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Approved', 'Pending', 'Rejected', 'Amended'],
            datasets: [{
                // data: [55, 25, 15, 5],
                data: [{{ $approvedCount }}, {{ $pendingCount }}, {{ $rejectedCount }}, {{ $ammendedCount }}],
                backgroundColor: [
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#6b7280'
                ],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 14,
                            weight: '500'
                        }
                    }
                }
            },
            cutout: '60%',
            elements: {
                arc: {
                    borderRadius: 8
                }
            }
        }
    });
</script>
