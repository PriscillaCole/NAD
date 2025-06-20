<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accountability Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
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
        .field {
            margin-bottom: 15px;
        }
        .field label {
            display: block;
            font-weight: bold;
            color: #495057;
        }
        .field p {
            margin: 5px 0;
            color: #212529;
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
            /* background-color: #f4f4f4; */
            background: -webkit-linear-gradient(top, #3c8dbc, #b3b6fc);
            color: white;
        }
        /* th {
            background-color: #f1f1f1;
        } */
        .file-list {
            list-style: none;
            padding: 0;
        }
        .file-list li {
            margin-bottom: 5px;
        }
        .file-list a {
            color: #007bff;
            text-decoration: none;
        }
        .file-list a:hover {
            text-decoration: underline;
        }
        .timestamp {
            font-size: 0.9em;
            color: #6c757d;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #6c757d;
        }
        .label {
            display: inline-block;
            padding: 0.2em 0.6em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }
        .label-warning { background-color: #ffc107; }
        .label-success { background-color: #28a745; }
        .label-danger { background-color: #dc3545; }
        .label-info { background-color: #17a2b8; }
        .label-secondary { background-color: #6c757d; }
        .status-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        .btn-approve {
            background-color: #28a745;
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
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('login-template/images/logo.webp') }}" alt="Logo" >
        <h1>Accountability Report</h1>

        <div class="section">
            <div class="status-container">
                <h2>Report Details</h2>
                <div class="field">
                    <label for="status">Status</label>
                    @if ($accountability->status == null)
                        <span class="label label-warning">Pending</span>
                    @elseif ($accountability->status == 'closed')
                        <span class="label label-success">Closed</span>
                    @elseif ($accountability->status == 'halted')
                        <span class="label label-danger">Halted</span>
                    @elseif ($accountability->status == 'amended')
                        <span class="label label-info">Amended</span>
                    @else
                        <span class="label label-secondary">Unknown</span>
                    @endif
                </div>
                <button class="print-button" onclick="window.print()">Print Report</button>
            </div>
            <div class="field">
                <table>
                    <thead>
                        <tr>
                            <th>Staff Member</th>
                            <th>Requisition ID</th>
                            <th>Program</th>
                            <th>Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$accountability->requisition->staff->name}}</td>
                            <td>{{$accountability->requisition->code}}</td>
                            @if($accountability->requisition->admin_program_id)
                                <td>{{ $accountability->requisition->admin_program->name }}</td>
                            @else
                                <td>{{ $accountability->requisition->activity->output->outcome->program->name }}</td>
                                <td>{{ $accountability->requisition->activity->name }}</td>
                            @endif
                            {{-- <td>{{$accountability->requisition->activity->output->outcome->program->name}}</td>
                            <td>{{$accountability->requisition->activity->name}}</td> --}}
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong>Money Dispensed : </strong>{{ number_format($accountability->requisition->amount)}} Ugx
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <h2>Financial Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Amount Returned to finance</th>
                        <th>Receipt for Returned Amount to finance</th>
                        <th>Excess Amount Returned to staff</th>
                        <th>Receipt for Excess Amount returned to staff</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> Ugx {{ $accountability->returned_amount?? 0 }}</td>
                        <td>
                            @if($accountability->proof_of_funds_returned)
                                <a href="{{ asset('storage/'.$accountability->proof_of_funds_returned) }}" target="_blank">View Receipt</a>
                            @else
                                No Receipt
                            @endif
                        </td>
                        <td>Ugx {{ $accountability->returned_amount?? 0 }}</td>
                        <td>
                            @if($accountability->proof_of_funds_to_be_returned)
                                <a href="{{ asset('storage/'.$accountability->proof_of_funds_to_be_returned) }}" target="_blank">View Receipt</a>
                            @else
                                No Receipt
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section no-print">
            <h2>Narrative Report</h2>
            <div class="field">
                <label for="narrative_report">Narrative Report</label>
                <a href="{{ asset('storage/'.$accountability->narrative_report) }}" target="_blank">
                    View Narrative Report
                </a>
            </div>
        </div>

        <div class="section">
        <h2>Requisition Item Receipts</h2>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Amount Disbursed</th>
                    <th>Amount Used</th>
                    <th>Transfer charge</th>
                    <th>Total Amount</th>
                    <th class="no-print">Receipts</th>
                </tr>
            </thead>
            <tbody>
                @foreach($accountability->requisition->requisition_items as $item)
                    <tr>
                        @if($accountability->requisition->admin_program_id)
                            <td>{{ $item->adminbudgetline->name }}</td> 
                        @else
                            <td>{{ $item->budgetline->name }}</td> 
                        @endif
                        <td>UGX {{ number_format($item->total_price, 2)}}</td>
                        
                        @foreach($item->requisitionItemReceipts as $receipt)
                            <td>{{ number_format($receipt->amount, 2) }} Ugx</td>
                            <td>{{ $receipt->transfer_charges}}</td>
                            <td> UGX {{ number_format(($receipt->amount + $receipt->transfer_charges), 2) }}</td>
                        @endforeach
                       
                        <td class="no-print">
                            @if($item->requisitionItemReceipts->isNotEmpty())
                                <ul class="file-list">
                                    @foreach($item->requisitionItemReceipts as $receipt)
                                        @if ($receipt->Invoice)
                                        @foreach($receipt->Invoice as $rpt)
                                            <li>
                                                <a href="{{ asset('storage/'.$rpt) }}" target="_blank" > Invoice {{ $loop->iteration }}</a>
                                            </li>

                                        @endforeach
                                        @endif
                                        @if ($receipt->payment_proof)
                                        @foreach($receipt->payment_proof as $rpt)
                                            <li>
                                                <a href="{{ asset('storage/'.$rpt) }}" target="_blank" > Proof of payment {{ $loop->iteration }}</a>
                                            </li>

                                        @endforeach
                                        @endif
                                        @if ($receipt->receipt_file)
                                        @foreach($receipt->receipt_file as $rpt)
                                            <li>
                                                <a href="{{ asset('storage/'.$rpt) }}" target="_blank" > Receipt {{ $loop->iteration }}</a>
                                            </li>

                                        @endforeach
                                        @endif
                                        
                                    @endforeach
                                </ul>
                            @else
                                <p>No receipts available for this item.</p>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
            {{-- <thead> --}}
                <tr>
                    <td colspan="4">Total Amount Used</td>
                    <td>Ugx {{ number_format($accountability->amount_used)}} </td>
                </tr>
            {{-- </thead> --}}
            
        </table>
    </div>


        <div class="section no-print">
            <h2>Other Receipt Files</h2>
            
            @if($accountability->attachments)
                <ul class="file-list" id="receipt_files">
                    @foreach($accountability->attachments as $receipt)
                        <li>
                            <a href="{{ asset('storage/'.$receipt) }}" target="_blank">
                                Attachment {{ $loop->iteration }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No receipts available.</p>
            @endif
        </div>

        <div class="section">
            <h2>Additional Information</h2>
            <div class="field">
                <label for="created_at">Created At</label>
                <p id="created_at" class="timestamp">{{ $accountability->created_at->format('d F, Y') }}</p>
                @if ($accountability->status == 'closed')
                <label for="closed by">Closed by</label>
                <p id="closed_by" class="timestamp">
                    @if ($accountability->staff)
                        {{ $accountability->staff->name }}, Head of Finance
                    @else
                        No review yet
                    @endif
                </p>

                <!-- add signature -->
                @if ($accountability->staff)
                <label for="signature">Signature</label>
                <img src="{{ asset('storage/'.$accountability->signature) }}" alt="signature" style="width: 200px; height: 100px;">
                @endif
                @endif
                
            </div>
        </div>
        <!-- button to redirect to the edit page -->

        <div class="section">
        @php
            $redirectUrl = route('accountabilities.show', $accountability->id);
            $loginUrl = url('/') . '?redirect_to=' . urlencode($redirectUrl);
        @endphp  

        {{-- <div class="field">
            <label for="accountability_link">Link to accountability Form:</label>
            <!-- Hidden input field for the link -->
            <input type="hidden" id="accountability_link" value="{{ $loginUrl }}" />
            <button onclick="copyLink()">Copy Link</button>
        </div> --}}

        <script>
            function copyLink() {
                // Get the hidden input field
                var copyText = document.getElementById("accountability_link");
                
                // Create a temporary input to copy from
                var tempInput = document.createElement("input");
                tempInput.value = copyText.value; // Set the value to the hidden link
                document.body.appendChild(tempInput); // Append it to the body

                // Select the temporary input
                tempInput.select();
                tempInput.setSelectionRange(0, 99999); // For mobile devices

                // Copy the text inside the temporary input
                document.execCommand("copy");

                // Remove the temporary input from the body
                document.body.removeChild(tempInput);

                toastr.success('Link copied to clipboard!');
            }
        </script>


       
        <div class="section no-print">
            <!-- get the role of the logged in user -->
            @php
                $user = Admin::user();
            @endphp
            <!-- check if the role is finance officer -->
            @if ($user->isRole('finance'))
            @if ($accountability->status != 'closed')

                <a href="#" id="closeBtn" class="btn btn-primary no-print">
                    Close Requisition
                </a>
                <a href="#"id="haltBtn" class="btn btn-danger">
                    Halt Requisition
                </a>
            @else
                <button class="btn btn-primary btn-disabled" disabled>
                    Closed Requisition
                </button>
            @endif
            @endif
        </div>

        <div class="footer">
            <p>Generated by ReQTrack System</p>
        </div>
        <div id="reasonModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Enter Comment</h3>
                <form id="reasonForm">
                    <textarea id="reason" rows="4" style="width: 100%;" placeholder="Enter reason here..."></textarea>
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
        var cross = document.getElementsByClassName("close")[0];
        var closeBtn = document.getElementById("closeBtn");
        
        var haltBtn = document.getElementById("haltBtn");
        var submitReason = document.getElementById("submitReason");
        var reasonInput = document.getElementById("reason");

        closeBtn.addEventListener('click', function(e) {
            saveAccept('closed');
            
        });

        cross.onclick = function() {
            modal.style.display = "none";
        }

        haltBtn.onclick = function() {
            modal.style.display = "block";
            submitReason.onclick = function() {
                sendReason('halted');
            }
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
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
            var accountabilityId = '{{ $accountability->id }}'; // Ensure this is correctly set

            // Prepare the data to be sent
            var data = {
                status: action,
                accountability: accountabilityId,
                remarks: reason
            };

            console.log(data);
            // Perform the AJAX request to send data to the server
            fetch('/approve/edit', { // Adjust the URL to your server endpoint
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
            var accountabilityId = '{{ $accountability->id }}'; // Ensure this is correctly set

            var data = {
                status: action,
                accountability: accountabilityId
                // remarks: requisitionId
            };

            console.log("Sending data:", data);

            fetch('/approve/edit', {
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
