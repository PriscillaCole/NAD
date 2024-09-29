
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
      .activity-row {
        background-color: #e7f1ff; /* Light blue color */
    }
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

    .form-group {
        display: flex;
        justify-content: flex-start;
        margin-bottom: 15px;
        padding-left: 50px;
        padding-right: 50px;
    }

    .form-group label {
        margin-right: 10px;
        min-width: 120px; /* Ensures labels align neatly */
    }

    .form-control {
        flex: 1;
    }

    .form-group.d-flex input,
    .form-group.d-flex select {
        width: auto;
    }

/* add padding to the span class */
    .span {
        padding: 0 10px;
    }

    .text-right {
        text-align: right;
    }
    

    
</style>

<!-- Modal -->
<div class="modal fade" id="activitiesModal" tabindex="-1" role="dialog" aria-labelledby="activitiesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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

    // Fetch activities based on the selected program
    fetch(`/fetch-activities/${programId}`)
        .then(response => response.json())
        .then(data => {
            openActivitiesModal(data);
            $('#activitiesModal').modal('show'); // Show the modal
        })
        .catch(error => console.error('Error fetching activities:', error));
});

function openActivitiesModal(programData) {
    // Set the program title
    document.getElementById('programTitle').innerText = programData.program.name;

    // Clear previous content
    const activitiesContainer = document.getElementById('activitiesContainer');
    activitiesContainer.innerHTML = '';

    // Populate activities and requisitions
    programData.activities.forEach(activity => {
        // Create activity section
        const activityDiv = document.createElement('div');
        activityDiv.classList.add('activity-section');

        // Activity name and amount row
        const activityRow = document.createElement('div');
        activityRow.classList.add('row', 'activity-row'); // Light shade of blue

        const activityNameCol = document.createElement('div');
        activityNameCol.classList.add('col-md-6');
        activityNameCol.innerText = activity.name;

        const activityAmountCol = document.createElement('div');
        activityAmountCol.classList.add('col-md-6');
        activityAmountCol.innerText = `Total Budget Amount: ${activity.budget || 0}`; // Use actual total amount if available

        activityRow.appendChild(activityNameCol);
        activityRow.appendChild(activityAmountCol);
        activityDiv.appendChild(activityRow);

        // Loop through requisitions for this activity
        activity.requisitions.forEach(requisition => {
            // Requisition code row
            const requisitionCode = document.createElement('strong');
            requisitionCode.innerText = `Requisition Code: ${requisition.code}`;
            activityDiv.appendChild(requisitionCode);
            requisitionCode.classList.add('req-section');
            
            // Table for requisition items
            const requisitionTable = document.createElement('table');
            requisitionTable.classList.add('table', 'table-bordered', 'mt-2');

            const tableHeader = document.createElement('thead');
            tableHeader.innerHTML = `
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Amount</th>
                </tr>
            `;
            requisitionTable.appendChild(tableHeader);

            const tableBody = document.createElement('tbody');
            requisition.items.forEach(item => {
                const itemRow = document.createElement('tr');
                itemRow.innerHTML = `
                    <td>${item.item}</td>
                    <td>${item.quantity}</td>
                    <td>${item.unit_price}</td>
                    <td>${(item.quantity * item.unit_price).toFixed(2)}</td>
                `;
                tableBody.appendChild(itemRow);
            });

            requisitionTable.appendChild(tableBody);
            activityDiv.appendChild(requisitionTable);
        });

        activitiesContainer.appendChild(activityDiv);
    });
}


</script>