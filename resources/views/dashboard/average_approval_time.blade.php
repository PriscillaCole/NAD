<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Dashboard</title>
    <!-- Bootstrap 3 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <style>
        .navbar {
            height: 2px;
        }
        /* .heatmap-container {
            padding: 15px;
            background: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .heatmap-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
        }
        
        .heatmap-cell {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #333;
            border-radius: 2px;
        } */
        
        .chart-title {
            margin-bottom: 15px;
            color: #333;
            font-size: 16px;
            font-weight: 500;
        }
        
        .panel {
            margin-bottom: 20px;
            /* background-color: #b3c7eb !important; */
        }
        
        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: -webkit-linear-gradient(top, #d1d3f9, #3c8dbc);
            /* background-color: #E6E6FA  !important; */
        }
        
        .project-select {
            display: inline-block;
        }
    </style>
    <style>
        .heatmap-container {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            margin: 20px;
        }

        .heatmap-grid {
            display: block;
            gap: 8px;
            margin-top: 20px;
        }

        /* .level-container {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        } */

        .level-title {
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }

        .level-grid {
            display: grid;
            gap: 8px;
            margin-top: 10px;
            grid-template-columns: repeat(3, 1fr);
        }

        .heatmap-cell {
            /* min-width: 80px;
            min-height: 70px; */
            width: 69px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            cursor: pointer;
            transition: transform 0.2s;
            padding: 8px;
        }

        .heatmap-cell:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .cell-content {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .cell-code {
            font-weight: bold;
            font-size: 8px;
            margin-bottom: 4px;
        }

        .cell-value {
            font-size: 12px;
        }

        .legend {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 4px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }

        .tooltip {
            position: absolute;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 12px;
            display: none;
            z-index: 1000;
            pointer-events: none;
            max-width: 250px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Heatmap -->
            {{-- <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span>Budget Utilisation Breakdown</span>
                        {{-- <select class="form-control input-sm project-select">
                            <option>Project</option>
                        </select> 
                        <form method="GET" action="{{ request()->url() }}">
                            <select name="programId2" id="program-filter" class="form-control input-sm project-select" >
                                <option value="">{{ __('Select Project') }}</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ request()->query('programId2') == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }}
                                    </option>
                                @endforeach
                            </select>
                            </form>
                    </div>
                    <div class="panel-body">
                        <div id="heatmap" class="heatmap-grid"></div>
                        <div class="legend">
                            <div class="legend-item">
                                <div class="legend-color" style="background: #FEF9C3"></div>
                                <span>Low (0-20%)</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background: #FDE047"></div>
                                <span>Medium (40-60%)</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background: #4ADE80"></div>
                                <span>High (80-100%)</span>
                            </div>
                        </div> 
                        
                    </div>
                    
                    <div id="tooltip" class="tooltip"></div>
                </div>
            </div> --}}
            
            <!-- Bar Chart -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">Budget vs Spending</span>
                        <form method="GET" action="{{ request()->url() }}">
                        <select name="programId2" id="program-filter" class="form-control input-sm project-select" >
                            <option value="">{{ __('Select Project') }}</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" {{ request()->query('programId2') == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}
                                </option>
                            @endforeach
                        </select>
                        </form>
                    </div>
                    <div class="panel-body">
                        <canvas id="budgetChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const programSelect = document.getElementById('program-filter');
            
            // If no program is selected, select the first one
            if (!programSelect.value && programSelect.options.length > 0) {
                programSelect.selectedIndex = 0;
            } 
            
            // Handle program select change
            programSelect.addEventListener('change', function() {
                const currentYear = new Date().getFullYear();
                const url = `dashboard?programId2=${this.value}&year=${currentYear}`;
                window.location.href = url;
            });
            
        });
    </script>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
       //heatmap
        
            const heatmapContainer = document.getElementById('heatmap');
            const tooltip = document.getElementById('tooltip');
            
            

        // Create bar chart
        function createBarChart() {
            const ctx = document.getElementById('budgetChart').getContext('2d');
            const chartData = @json($chartData); // Pass data from the backend
            console.log(chartData);

            const labels = chartData.map(item => item.activity_name);
            const budgetData = chartData.map(item => item.budget);
            const amountUsedData = chartData.map(item => item.amount_used);
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Budget',
                        data: budgetData,
                        backgroundColor: '#8884d8',
                        borderColor: '#8884d8',
                        borderWidth: 1
                    },
                    {
                        label: 'Amount Used',
                        data: amountUsedData,
                        backgroundColor: '#82ca9d',
                        borderColor: '#82ca9d',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }

        // Initialize visualizations
        document.addEventListener('DOMContentLoaded', function() {
            // createHeatmap();
            createBarChart();
        });
    </script>

</body>
</html>