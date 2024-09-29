<!-- Program Selection Form -->
<style>
    .activity-row {
        background-color: #e7f1ff; /* Light blue color */
    }
</style>

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
    <button type="button" class="btn btn-primary" id="viewActivitiesBtn">View Program Budget</button>
</form>

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