<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ __('Generate Dynamic Report') }}</h4>
    </div>
    <div class="card-body">
    <form action="{{ route('generateReport') }}" method="GET">
    <div class="form-group">
        <label for="project">Select Project</label>
        <select name="project_id" id="project" class="form-control">
            <option value="">All Projects</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="activity">Select Activity</label>
        <select name="activity_id" id="activity" class="form-control">
            <option value="">All Activities</option>
            <!-- This will be populated based on the project selection -->
        </select>
    </div>

    <div class="form-group">
        <label for="staff">Select Staff</label>
        <select name="staff_id" id="staff" class="form-control">
           @foreach($staff as $staff)
                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="requisition">Select Requisition</label>
        <select name="requisition_id" id="requisition" class="form-control">
            <option value="">All Requisitions</option>
            <!-- This will be populated based on activity and staff selection -->
        </select>
    </div>

    <div class="form-group">
        <label for="status">Approval Status</label>
        <select name="status" id="status" class="form-control">
            <option value="">All Statuses</option>
            <option value="approved">Approved</option>
            <option value="pending">Pending</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>

    <div class="form-group d-flex align-items-center">
        <label for="start_date" class="mr-2">{{ __('Date Range') }}</label>
        <input type="date" name="start_date" id="start_date" class="form-control mr-2">
        <span class="span">to</span>
        <input type="date" name="end_date" id="end_date" class="form-control">
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </div>
</form>

    </div>
</div>

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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle project change
    document.getElementById('project').addEventListener('change', function () {
        const projectId = this.value;
        let activitySelect = document.getElementById('activity');
        let staffSelect = document.getElementById('staff');
        let requisitionSelect = document.getElementById('requisition');

        activitySelect.innerHTML = '<option value="">All Activities</option>';
        staffSelect.innerHTML = '<option value="">All Staff</option>';
        requisitionSelect.innerHTML = '<option value="">All Requisitions</option>';

        if (projectId) {
            fetch(`/get-activities/${projectId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.activities.length > 0) {
                        data.activities.forEach(activity => {
                            activitySelect.innerHTML += `<option value="${activity.id}">${activity.name}</option>`;
                        });
                    } else {
                        activitySelect.innerHTML = '<option value="">No activities available</option>';
                    }
                });
        }
    });

    // Handle activity change
    document.getElementById('activity').addEventListener('change', function () {
        const activityId = this.value;
        let staffSelect = document.getElementById('staff');
        let requisitionSelect = document.getElementById('requisition');

        staffSelect.innerHTML = '<option value="">All Staff</option>';
        requisitionSelect.innerHTML = '<option value="">All Requisitions</option>';

        if (activityId) {
            // Fetch staff members related to the activity (or those who made requisitions)
            fetch(`/get-staff/${activityId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.staff.length > 0) {
                        data.staff.forEach(staff => {
                            staffSelect.innerHTML += `<option value="${staff.id}">${staff.name}</option>`;
                        });
                    } else {
                        staffSelect.innerHTML = '<option value="">No staff available</option>';
                    }
                });

            // Fetch requisitions related to the activity
            fetch(`/get-requisitions/${activityId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.requisitions.length > 0) {
                        data.requisitions.forEach(requisition => {
                            requisitionSelect.innerHTML += `<option value="${requisition.id}">${requisition.code}</option>`;
                        });
                    } else {
                        requisitionSelect.innerHTML = '<option value="">No requisitions available</option>';
                    }
                });
        }
    });

    // Handle staff change
    document.getElementById('staff').addEventListener('change', function () {
        const staffId = this.value;
        const activityId = document.getElementById('activity').value;
        let requisitionSelect = document.getElementById('requisition');

        requisitionSelect.innerHTML = '<option value="">All Requisitions</option>';

        if (activityId) {
            let url = `/get-requisitions/${activityId}`;
            if (staffId) {
                url += `/${staffId}`;
            }

            // Fetch requisitions based on the selected staff and activity
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.requisitions.length > 0) {
                        data.requisitions.forEach(requisition => {
                            requisitionSelect.innerHTML += `<option value="${requisition.id}">${requisition.code}</option>`;
                        });
                    } else {
                        requisitionSelect.innerHTML = '<option value="">No requisitions available</option>';
                    }
                });
        }
    });
});
</script>

