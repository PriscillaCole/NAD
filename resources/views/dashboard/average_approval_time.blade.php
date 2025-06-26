<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Dashboard</title>
    <!-- Bootstrap 3 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script> --}}
   
    <style>
        .budget-dropdown:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .budget-dropdown:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
        }

         .chart-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .chart-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .chart-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .title-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .budget-selector {
            position: relative;
        }

        .budget-dropdown {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            min-width: 200px;
        }

    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Bar Chart -->
            {{-- <div class="col-md-12">
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
            </div> --}}

            <div class="chart-card">
                <div class="chart-header">
                    <h2 class="chart-title">
                        <div class="title-icon">📊</div>
                        Budget vs Spending
                    </h2>
                    <div class="budget-selector">
                        <form method="GET" action="{{ request()->url() }}">
                            <select name="programId2" id="program-filter" class="budget-dropdown" >
                                <option value="">{{ __('Select Project') }}</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ request()->query('programId2') == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    {{-- <div class="budget-selector">
                        <select class="budget-dropdown" id="budgetSelect">
                            <option value="country">Country Coordination Budget</option>
                            <option value="program">Program Implementation Budget</option>
                            <option value="operations">Operations Budget</option>
                            <option value="emergency">Emergency Response Budget</option>
                        </select>
                    </div> --}}
                </div>
            
                <div class="chart-container">
                    <canvas id="budgetChart"></canvas>
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
        // Budget vs Spending Chart
        const budgetCtx = document.getElementById('budgetChart').getContext('2d');
        const chartData = @json($chartData); // Pass data from the backend
            console.log(chartData);

            const labels = chartData.map(item => item.activity_name);
            const budgetData = chartData.map(item => item.budget);
            const amountUsedData = chartData.map(item => item.amount_used);
        const budgetChart = new Chart(budgetCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Budget',
                        data: budgetData,
                        backgroundColor: 'rgba(102, 126, 234, 0.8)',
                        borderColor: '#667eea',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    },
                    {
                        label: 'Amount Spent',
                        data: amountUsedData,
                        backgroundColor: 'rgba(34, 197, 94, 0.8)',
                        borderColor: '#22c55e',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
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

    </script>

</body>
</html>