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
        .heatmap-container {
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
        }
        
        .chart-title {
            margin-bottom: 15px;
            color: #333;
            font-size: 16px;
            font-weight: 500;
        }
        
        .panel {
            margin-bottom: 20px;
        }
        
        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .project-select {
            width: auto;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Heatmap -->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span>Budget Utilisation Breakdown</span>
                        <select class="form-control input-sm project-select">
                            <option>Project</option>
                        </select>
                    </div>
                    <div class="panel-body">
                        <div class="heatmap-grid" id="budgetHeatmap"></div>
                    </div>
                </div>
            </div>
            
            <!-- Bar Chart -->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span>Budget vs Spending</span>
                        <form method="GET" action="{{ request()->url() }}">
                        <select name="programId2" id="program-filter" class="form-control project-select" >
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
                        <canvas id="budgetChart"></canvas>
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
                const url = `/dashboard?programId2=${this.value}&year=${currentYear}`;
                window.location.href = url;
            });
            
        });
    </script>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        // Heatmap Data
        const heatmapData = [
            ['PTE', 'APGR', 'JAN', 'FEB', 'MAR', 'APR', 'MAY'],
            ['LLF', 'VRC', 'G', 'DRR', 'DSR', 'RKY', 'TGET'],
            ['DRR', 'DSR', 'RKY', 'PTE', 'APGR', 'G', 'VRC'],
            ['LLF', 'VRC', 'G', 'DRR', 'DSR', 'RKY', 'TGET'],
        ];
        
        const heatmapValues = [
            [85, 75, 65, 60, 55, 50, 45],
            [80, 70, 60, 55, 50, 45, 40],
            [75, 65, 55, 50, 45, 40, 35],
            [80, 70, 60, 55, 50, 45, 80]
        ];

        // Create heatmap
        function createHeatmap() {
            const heatmap = document.getElementById('budgetHeatmap');
            
            heatmapData.forEach((row, i) => {
                row.forEach((cell, j) => {
                    const value = heatmapValues[i][j];
                    const div = document.createElement('div');
                    div.className = 'heatmap-cell';
                    div.textContent = cell;
                    div.style.backgroundColor = `hsl(${60 + (value * 0.6)}, 75%, 60%)`;
                    heatmap.appendChild(div);
                });
            });
        }

        // Create bar chart
        function createBarChart() {
            const ctx = document.getElementById('budgetChart').getContext('2d');
            const chartData = @json($chartData); // Pass data from the backend

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
            createHeatmap();
            createBarChart();
        });
    </script>
</body>
</html>