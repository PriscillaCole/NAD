<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ __('Generate Program Budget') }}</h4>
    </div>
    <div class="card-body">
        <form id="programForm" method="POST">
            @csrf
            <div class="form-group">
                <label for="programSelect">Select a Program:</label>
                <select id="programSelect" class="form-control" name="program_id">
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="text-right">
                <button type="button" class="btn btn-primary" id="viewActivitiesBtn">View Program Budget</button>
            </div>
        </form>
    </div>
</div>

<style>
    .outcome-section {
        margin-bottom: 30px;
        padding: 20px;
        border: 2px solid #007bff;
        border-radius: 8px;
        background-color: #f8f9fa;
    }

    .output-section {
        margin: 15px 0;
        padding: 15px;
        border: 1px solid #6c757d;
        border-radius: 6px;
        background-color: #fff;
        margin-left: 20px;
    }

    .activity-section {
        margin: 10px 0;
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        background-color: #f9f9f9;
        margin-left: 20px;
    }

    .budgetline-section {
        margin: 10px 0;
        padding: 10px;
        border: 1px dashed #dee2e6;
        border-radius: 4px;
        background-color: #fff;
        margin-left: 20px;
    }

    .section-header {
        padding: 8px;
        margin-bottom: 10px;
        border-radius: 4px;
    }

    .outcome-header {
        background-color: #cce5ff;
    }

    .output-header {
        background-color: #e2e3e5;
    }

    .activity-header {
        background-color: #e7f1ff;
    }

    .total-row {
        background-color: #e0ffe0;
        padding: 8px;
        margin-top: 10px;
        border-radius: 4px;
    }

    .balance-row {
        background-color: #fff2e6;
        padding: 8px;
        margin-top: 5px;
        border-radius: 4px;
    }

    .table-budgetlines {
        margin-top: 10px;
        width: 100%;
    }

    .indent-content {
        margin-left: 20px;
    }

    .section-title {
        font-weight: bold;
        margin-bottom: 5px;
    }

    /* Keep your existing styles here */
    .card { /* ... */ }
    .card-body { /* ... */ }
    .card-header { /* ... */ }
    .form-group { /* ... */ }
    .text-right { /* ... */ }
</style>

<!-- Modal -->
<div class="modal fade" id="activitiesModal" tabindex="-1" role="dialog" aria-labelledby="activitiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activitiesModalLabel">Program Budget</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 id="programTitle"></h4>
                <div id="activitiesContainer">
                    <!-- Dynamic content will be inserted here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('viewActivitiesBtn').addEventListener('click', function() {
    const programId = document.getElementById('programSelect').value;

    fetch(`/fetch-activities/${programId}`)
        .then(response => response.json())
        .then(data => {
            openActivitiesModal(data);
            $('#activitiesModal').modal('show');
        })
        .catch(error => console.error('Error fetching program structure:', error));
});

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function openActivitiesModal(programData) {
    document.getElementById('programTitle').innerText = programData.program.name;
    const container = document.getElementById('activitiesContainer');
    container.innerHTML = '';

    programData.outcomes.forEach(outcome => {
        const outcomeSection = document.createElement('div');
        outcomeSection.classList.add('outcome-section');

        // Outcome Header
        const outcomeHeader = document.createElement('div');
        outcomeHeader.classList.add('section-header', 'outcome-header');
        outcomeHeader.innerHTML = `<h5>Outcome: ${outcome.name}</h5>`;
        outcomeSection.appendChild(outcomeHeader);

        // Process Outputs
        outcome.outputs.forEach(output => {
            const outputSection = document.createElement('div');
            outputSection.classList.add('output-section');

            // Output Header
            const outputHeader = document.createElement('div');
            outputHeader.classList.add('section-header', 'output-header');
            outputHeader.innerHTML = `<h6>Output: ${output.name}</h6>`;
            outputSection.appendChild(outputHeader);

            // Process Activities
            output.activities.forEach(activity => {
                const activitySection = document.createElement('div');
                activitySection.classList.add('activity-section');

                // Activity Header
                const activityHeader = document.createElement('div');
                activityHeader.classList.add('section-header', 'activity-header');
                activityHeader.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <span>Activity: ${activity.name}</span>
                        <span>Budget: ${formatCurrency(activity.budget || 0)}</span>
                    </div>
                `;
                activitySection.appendChild(activityHeader);

                // Process Budget Lines
                if (activity.budgetlines && activity.budgetlines.length > 0) {
                    const budgetTable = document.createElement('table');
                    budgetTable.classList.add('table', 'table-bordered', 'table-budgetlines');
                    
                    budgetTable.innerHTML = `
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Unit Cost</th>
                                <th>Quantity</th>
                                <th>Frequency</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${activity.budgetlines.map(line => `
                                <tr>
                                    <td>${line.name}</td>
                                    <td>${formatCurrency(line.unit_cost)}</td>
                                    <td>${line.quantity}</td>
                                    <td>${line.frequency}</td>
                                    <td>${formatCurrency(line.total_cost)}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    `;
                    
                    activitySection.appendChild(budgetTable);

                    // Calculate and display totals
                    const totalCost = activity.budgetlines.reduce((sum, line) => sum + line.total_cost, 0);
                    const balance = activity.budget - totalCost;

                    const totalRow = document.createElement('div');
                    totalRow.classList.add('total-row');
                    totalRow.innerHTML = `<strong>Total Used: ${formatCurrency(totalCost)}</strong>`;
                    activitySection.appendChild(totalRow);

                    const balanceRow = document.createElement('div');
                    balanceRow.classList.add('balance-row');
                    balanceRow.innerHTML = `
                        <strong>Balance: 
                            <span style="color: ${balance < 0 ? 'red' : 'black'}">
                                ${formatCurrency(balance)}
                            </span>
                        </strong>
                    `;
                    activitySection.appendChild(balanceRow);
                }

                outputSection.appendChild(activitySection);
            });

            outcomeSection.appendChild(outputSection);
        });

        container.appendChild(outcomeSection);
    });
}
</script>