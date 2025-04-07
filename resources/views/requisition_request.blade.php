<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Toastr CSS & JS from a CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Include Font Awesome for spinner icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Requisition Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
          
        }
        .container {
            max-width: 900px;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #343a40;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            font-size: 1.5em;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            color: #007bff;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table, .table th, .table td {
            border: 1px solid #ddd;
        }
        .table th, .table td {
            padding: 10px;
            text-align: left;
        }
        .table th {
            /* background-color: #f4f4f4; */
            background:  -webkit-linear-gradient(top, #3c8dbc, #b3b6fc);
            color: white;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
        .btn {
            display: inline-block;
            padding: 5px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
           
        }
         
        .btn:hover {
            background-color: #0056b3;
        } */

        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
            max-width: 500px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
      
        .btn-approve {
            background-color: #28a745;
        }
        .btn-reject {
            background-color: #dc3545;
        }
        .btn-amend {
            background-color: #17a2b8;
        }
        img {
            display: block;
            margin: 0 auto;
            border-radius: 50%;
            width: 200px;
            height: 100px;
            object-fit: cover;
            object-position: center;
            margin-bottom: 20px;
        }
        .status-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('login-template/images/logo.webp') }}" alt="Logo" >
        <h1>FUNDS REQUISITION FORM</h1>
        <label>Date Created: {{ $requisition->created_at }}</label>
        <!-- make the concept note a downloadable file -->
       
        <div class="status-container">
        <label >Concept note : <a href="{{ asset('storage/'.$requisition->concept_note) }}" download onclick="forceDownload(event, '{{ asset('storage/' . $requisition->concept_note) }}')">Download Concept Note</a></label>
                <div class="field">
                    <label for="status">Status</label>
                    @if ($requisition->status == 'pending')
                        <span class="label label-warning">Pending</span>
                    @elseif ($requisition->status == 'approved')
                        <span class="label label-success">Authorized</span>
                    @elseif ($requisition->status == 'accepted')
                        <span class="label label-primary">Approved</span>
                    @elseif ($requisition->status == 'rejected')
                        <span class="label label-danger">Rejected</span>
                    @elseif ($requisition->status == 'amended')
                        <span class="label label-info">Amended</span>
                    @else
                        <span class="label label-secondary">Unknown</span>
                    @endif
                </div>
                <button class="btn no-print" onclick="window.print()">Print Request</button>
            </div>
      
        <!-- General Information Section -->
        <div class="section">
        <h2>General Information</h2>
        <table class="table table-bordered">
                <tr>
                    <th>Staff ID</th>
                    <td>{{ $requisition->staff->staff_number}}</td>
                </tr>
                <tr>
                    <th>Requested by</th>
                    <td>{{ $requisition->staff->name }}</td>
                </tr>
                <tr>
                    <th>Code</th>
                    <td>{{ $requisition->code }}</td>
                </tr>
                @if($requisition->admin_program_id)
                <tr>
                    <th>Program</th>
                    <td>{{ $requisition->admin_program->name }}</td>
                </tr>
                @else
                <tr>
                    <th>Outcome</th>
                    <td>{{ $requisition->activity->output->outcome->name }}</td> 
                </tr>
                <tr>
                    <th>Output</th>
                    <td>{{ $requisition->activity->output->name }}</td> 
                </tr>
                
                    {{-- <td>{{ $requisition->activity->name }}</td> --}}
                @endif
                    <th>Activity</th>
                    @if($requisition->admin_program_id)
                        {{-- <td>{{ $requisition->admin_program->name }}</td> --}}
                    @else
                        {{-- <td>{{ $requisition->activity->output->outcome->program->name }}</td>  --}}
                        <td>{{ $requisition->activity->name }}</td>
                    @endif
                </tr>
                <tr>
                    <th>Activity Remaining Budget</th>
                    <td>UGX {{ number_format($remaining) }}</td>
                </tr>
            {{-- <tbody>
                <tr>
                    @if($requisition->admin_program_id)
                        <td>{{ $requisition->admin_program->name }}</td>
                    @else
                        <td>{{ $requisition->activity->output->outcome->program->name }}</td> 
                        <td>{{ $requisition->activity->name }}</td>
                    @endif
                    
                    
                </tr>
            </tbody> --}}
        </table>

        </div>


         <!-- Requisition items Section -->
         <div class="section">
         <h2>Requisition Items</h2>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Unit Price(UGX)</th>
                    <th>Total Price(UGX)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                @foreach($requisition->requisition_items as $item)
                    <?php
                        // Assuming you have fetched $item from the database
                        $unit_price = $item->unit_price;
                        $quantity = $item->quantity;
                        $total_price = $unit_price * $quantity;
                    ?>
                    <tr>
                        <td>{{ $counter++ }}</td>
                        
                        @if($item->admin_budget_line_id)
                            <td>{{ $item->adminbudgetline->name }}</td>
                        @else
                            <td>{{ $item->budgetline->name }}</td>
                        @endif
                        <td>{{ $item->quantity }} {{$item->unit_of_measure}}</td>
                        <td>{{ number_format($item->unit_price) }}</td>
                        <td>{{ number_format($total_price) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5"><b>Overall Estimated Cost (UGX):</b></td>
                    <td>{{ number_format($requisition->amount) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

       <!-- Approval Section -->
<div class="section">
    <h2>Approval list</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Roles</th>
                <th>Reviewed by</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1; // Initialize a counter variable
                // Get unique comments by staff_id
                $uniqueComments = $requisition->comments->unique('commented_by');
            @endphp
            @if($requisition->status == 'amended')
                <tr>
                    <td>1</td>
                    <td>Head of finance</td>
                    <td>Mwebaza Rolaine</td>
                    <td>{{ $requisition->status }}</td>

                </tr>
            @endif
            @foreach($uniqueComments as $comment)
                <tr>
                    <td>{{ $counter++ }}</td> <!-- Display incremental number -->
                    <td>
                        @if($comment->staff && $comment->staff->user)
                            @if($comment->staff->user->roles->isNotEmpty())
                                @foreach($comment->staff->user->roles as $role)
                                    {{ $role->name }}
                                    @if(!$loop->last) 
                                        , 
                                    @endif
                                @endforeach
                            @else
                                No Roles Assigned
                            @endif
                        @else
                            No User or Staff
                        @endif
                    </td>
                    <td>{{ $comment->staff ? $comment->staff->name : 'Unknown' }}</td>
                    <td>{{ $comment->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

        <!-- Comments Section -->
        <div class="section">
        <h2>Comments</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Comment</th>
                    <th>Created by</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1; // Initialize a counter variable
                @endphp
                @foreach($requisition->comments as $comment)
                    <tr>
                        <td>{{ $counter++ }}</td> <!-- Display incremental number -->
                        <td>{{ $comment->comment }}</td>
                        <td>{{ $comment->staff ? $comment->staff->name : 'Unknown' }}</td>
                        <td>{{ $comment->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Ammendment notes if any  -->
    @if ($requisition->amendment_notes != null)
    <div class="section">
        <h2>Ammendment Notes</h2>
        <p>{{ $requisition->amendment_notes }}</p>
    </div>
    @endif

    <!-- signatures -->
    <div class="section">
       
        <div class="status-container">
        
        <div class="field" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            @if ($requisition->status != null)
                <div style="text-align: center;">
                    <label for="signature">Mwebaza Rolaine, Head of Finance</label><br>
                    <img src="{{ asset('storage/signatures/hofs.png') }}" alt="signature" style="width: 200px; height: 100px;">
                </div>
                @if($requisition->status == 'approved')
                    <div style="text-align: center;">
                        <label for="signature">Edson Ngirabakunzi, Country Director</label><br>
                        <img src="{{ asset('storage/signatures/cds.png') }}" alt="signature" style="width: 200px; height: 100px;">
                    </div>
                @endif
            @endif
        </div>

</div>

        </div>
    
        <!-- check the role of the logged in user -->
        @if(auth()->user()!=null)
            @if(auth()->user()->roles->isNotEmpty())
                @foreach(auth()->user()->roles as $role)
                    @if($role->slug == 'finance' )
                        <a href="#" id="acceptBtn" class="btn btn-accept no-print">Approve</a>
                        <a href="#" id="rejectBtn" class="btn btn-reject no-print">Reject</a>
                        <a href="#" id="haltBtn" class="btn btn-halt no-print">On Hold</a>
                        <a href="/requisitions/{{$requisition->id}}/edit" id="amendBtn" class="btn btn-amend no-print">Amend</a>
                    @elseif($role->slug == 'director' && $requisition->status == 'accepted')
                        <a href="#" id="approveBtn" class="btn btn-approve no-print">Authorize</a>
                        <a href="#" id="rejectBtn" class="btn btn-reject no-print">Reject</a>
                        <a href="#" id="haltBtn" class="btn btn-halt no-print">Halt</a>
                        <a href="/requisitions/{{$requisition->id}}/edit" id="amendBtn" class="btn btn-amend no-print">Amend</a>
                    @endif
                        
                @endforeach
            @endif
        @endif
        </div>

        <!-- Modal -->
        <div id="reasonModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Enter Comment</h3>
                <form id="reasonForm">
                    <textarea id="reason" rows="4" style="width: 100%;" placeholder="Enter comment here..."></textarea>
                    <br><br>
                    <button type="button" id="submitReason" class="btn btn-approve">
                        <span id="spinner" class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> <!-- Font Awesome Spinner Icon -->
                        </span>
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functionality
        var modal = document.getElementById("reasonModal");
        // var modal = document.getElementByClassName("modal");
        var closeBtn = document.getElementsByClassName("close")[0];
        
        var approveBtn = document.getElementById("approveBtn");
        var acceptBtn = document.getElementById("acceptBtn");
        var rejectBtn = document.getElementById("rejectBtn");
        var haltBtn = document.getElementById("haltBtn");
        var submitReason = document.getElementById("submitReason");
        var reasonInput = document.getElementById("reason");

        if (approveBtn) {
            approveBtn.onclick = function() {
                modal.style.display = "block";
                submitReason.onclick = function() {
                    sendReason('approved');
                }
            }
        } else {
            acceptBtn.onclick = function() {
                modal.style.display = "block";
                submitReason.onclick = function() {
                    sendReason('accepted');
                }
            }
        }
        

        rejectBtn.onclick = function() {
            modal.style.display = "block";
            submitReason.onclick = function() {
                sendReason('rejected');
            }
        }

        haltBtn.onclick = function() {
            modal.style.display = "block";
            submitReason.onclick = function() {
                sendReason('halted');
            }
        }

      

        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Function to force download a file
        function forceDownload(event, url) {
            event.preventDefault(); // Prevent default link action
            
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.blob();
                })
                .then(blob => {
                    const filename = url.split('/').pop();
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('There was an error downloading the file.', 'Error'); // Show error message
                });
        }

        function sendReason(action) {
            var reason = reasonInput.value;
            var submitButton = document.getElementById('submitReason'); // Select the submit button
            var spinner = document.getElementById('spinner'); // Select the spinner

            if (reason.trim() === '') {
                toastr.error('Please enter a reason.', 'Error'); // Use Toastr for error message
                return;
            }

            // Disable the submit button and show the spinner
            submitButton.disabled = true;
            spinner.style.display = 'inline-block'; // Show spinner
            submitButton.innerHTML = 'Submitting...'; // Show loading text

            // Assuming you have the requisition ID available
            var requisitionId = '{{ $requisition->id }}'; // Ensure this is correctly set

            // Prepare the data to be sent
            var data = {
                action: action,
                reason: reason,
                requisition_id: requisitionId
            };

            console.log(data);
            // Perform the AJAX request to send data to the server
            fetch('/comments', { // Adjust the URL to your server endpoint
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for Laravel
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    // If the response status is not OK, throw an error
                    return response.text().then(text => { throw new Error(text); });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
                toastr.success('Your decision has been recorded.', 'Success'); // Show success message
                modal.style.display = "none"; // Close the modal on success

                // Reset button state
                submitButton.disabled = false; 
                spinner.style.display = 'none'; // Hide spinner
                submitButton.innerHTML = 'Submit'; // Reset the button text
            })
            .catch((error) => {
                console.error('Error:', error);
                toastr.error('There was an error recording your decision.', 'Error'); // Show error message

                // Reset button state on error
                submitButton.disabled = false;
                spinner.style.display = 'none'; // Hide spinner
                submitButton.innerHTML = 'Submit'; // Reset the button text
            });
        }

        function saveAccept(action) {
            var requisitionId = '{{ $requisition->id }}'; // Ensure it's properly set in Blade

            var data = {
                action: action,
                requisition_id: requisitionId
            };

            console.log("Sending data:", data);

            fetch('/comments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text); });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
                toastr.success('Your decision has been recorded.', 'Success');
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('There was an error recording your decision.', 'Error');
            });
        }

    </script>
    </body>
    </html>
