<div class="card">
    <div class="card-header">
        <h3>Requisition and Accountability Report</h3>
    </div>
    
    <div class="card-body">
        @if($requisitions->isEmpty())
            <p>No requisitions found for the selected criteria.</p>
        @else
            <!-- @foreach($requisitions as $requisition)
            <p>Project Description</p>
            <p>Project Name: {{ $requisition->activity->program->name }}</p>
            <p>Project Description: {{ $requisition->activity->program->description }}</p>

            @endforeach -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Requisition Code</th>
                        <th>Activity</th>
                        <th>Staff</th>
                        <th>Status</th>
                        <th>Updated At</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requisitions as $requisition)
                        <tr>
                            <td>{{ $requisition->code }}</td>
                            <td>{{ $requisition->activity->name }}</td>
                            <td>{{ $requisition->staff->name }}</td>
                            <td>{{ ucfirst($requisition->status) }}</td>
                            <td>{{ $requisition->updated_at->format('Y-m-d') }}</td>
                            <td>{{ $requisition->amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Add a section for the graph -->
    <div class="card-body">
        <h4>Accountability Overview</h4>
        <!-- Dropdown for selecting chart type -->
        <label  class="chartSelection" for="chartType">Select Chart Type: </label>
        <select id="chartType" class="form-control chartSelection " style="width: 200px;">
            <option value="bar">Bar</option>
            <option value="line">Line</option>
            <option value="pie">Pie</option>
            <option value="doughnut">Doughnut</option>
        </select>

       <!-- Add the canvas element with specific dimensions -->
<canvas id="requisitionChart" style="width: 500px; height: 300px;"></canvas>

    </div>

    <button class="print-button" onclick="window.print()">Print Report</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Get chart context
    const ctx = document.getElementById('requisitionChart').getContext('2d');

    // Default chart type
    let chartType = 'bar';

    // Requisition data
    const requisitionCodes = @json($requisitions->pluck('code'));
    const requisitionAmounts = @json($requisitions->pluck('amount'));

    // Generate a random color for each requisition
    function generateRandomColors(length) {
        const colors = [];
        for (let i = 0; i < length; i++) {
            const randomColor = `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.5)`;
            colors.push(randomColor);
        }
        return colors;
    }

    // Function to create chart
    function createChart(type) {
        console.log('Creating chart of type:', type); // Debugging line

        // Check if requisitionChart already exists and destroy it before creating a new one
        if (window.requisitionChart instanceof Chart) {
            console.log('Destroying existing chart...'); // Debugging line
            window.requisitionChart.destroy();
        }

        // Generate dynamic colors for the chart bars/lines/pie slices
        const backgroundColors = generateRandomColors(requisitionCodes.length);

        // Create new chart
        window.requisitionChart = new Chart(ctx, {
            type: type,
            data: {
                labels: requisitionCodes,
                datasets: [{
                    label: 'Requisition Amounts',
                    data: requisitionAmounts,
                    backgroundColor: backgroundColors, // Apply dynamic colors
                    borderColor: backgroundColors.map(color => color.replace('0.5', '1')), // Darker border color
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        console.log('Chart created successfully'); // Debugging line
    }

    // Create initial chart
    createChart(chartType);

    // Listen for chart type changes
    document.getElementById('chartType').addEventListener('change', function (e) {
        chartType = e.target.value;
        createChart(chartType); // Recreate the chart with the new type
    });
});

</script>

<style>
.card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        padding: 20px;
        transition: all 0.3s ease-in-out;
        background-color: #fff;
        border-top: 3px solid #0096FF;
    }

    .card-body {
        padding-left: 20px;
        padding-right: 20px;
    }
    .card-header {
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 5px;
        margin-bottom: 30px;
    }
    table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        th {
            background-color: #f1f1f1;
        }
        canvas {
            max-width: 500px; /* Set the maximum width */
            max-height: 300px; /* Set the maximum height */
            /* center the canvas */
            margin: 0 auto;
        }
        @media print {
            .print-button {
                display: none;
            }
            .receipt-file-link {
                display: block;
            }
            .file-list a {
                color: black;
                text-decoration: none;
            }
            .chartSelection {
                display: none;
            }
        }
        .print-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
        }
        .print-button:hover {
            background-color: #0056b3;
        }
</style>
