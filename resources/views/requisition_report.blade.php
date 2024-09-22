
<div class="card">
    <div class="card-header">
        <h3>Requisition and Accountability Report</h3>
        
    </div>
    <div class="card-body">
        @if($requisitions->isEmpty())
            <p>No requisitions found for the selected criteria.</p>
        @else
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
        <canvas id="requisitionChart"></canvas>
    </div>
    <button class="print-button" onclick="window.print()">Print Report</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // If you have any data to show in a graph, you can pass it here
    @if(!$requisitions->isEmpty())
        const ctx = document.getElementById('requisitionChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($requisitions->pluck('code')),
                datasets: [{
                    label: 'Requisition Amounts',
                    data: @json($requisitions->pluck('amount')),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
    @endif
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
