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
            background-color: #f1f1f1;
        }
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
                    @elseif ($accountability->status == 'rejected')
                        <span class="label label-danger">Rejected</span>
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
                            <td>{{$accountability->requisition->activity->program->name}}</td>
                            <td>{{$accountability->requisition->activity->name}}</td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong>Money Dispensed:</strong> {{$accountability->requisition->amount}} Ugx
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
                        <td>{{ $accountability->returned_amount }} Ugx</td>
                        <td>
                            @if($accountability->proof_of_funds_returned)
                                <a href="{{ asset('storage/'.$accountability->proof_of_funds_returned) }}" target="_blank">View Receipt</a>
                            @else
                                No Receipt
                            @endif
                        </td>
                        <td>{{ $accountability->amount_to_be_returned }} Ugx</td>
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

        <div class="section">
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
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Amount</th>
                    <th>Receipts</th>
                </tr>
            </thead>
            <tbody>
                @foreach($accountability->requisition->requisition_items as $item)
                    <tr>
                        <td>{{ $item->item }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 2) }} Ugx</td>
                        <td>{{ number_format($item->quantity * $item->unit_price, 2) }} Ugx</td>
                        <td>
                            @if($item->requisitionItemReceipts->isNotEmpty())
                                <ul class="file-list">
                                    @foreach($item->requisitionItemReceipts as $receipt)
                                        <li>
                                            <a href="{{ asset('storage/'.$receipt->receipt_file) }}" target="_blank">Receipt {{ $loop->iteration }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No receipts available for this item.</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


        <div class="section">
            <h2>Other Receipt Files</h2>
            <p>Total Amount Used: {{$accountability->amount_used}} Ugx</p> 

            @if($accountability->receiptFiles->isNotEmpty())
                <ul class="file-list" id="receipt_files">
                    @foreach($accountability->receiptFiles as $receipt)
                        <li>
                            <a href="{{ asset('storage/'.$receipt->receipt_path) }}" target="_blank">
                                Receipt {{ $loop->iteration }}
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
                <p id="created_at" class="timestamp">{{ $accountability->created_at }}</p>
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
                
            </div>
        </div>
        <!-- button to redirect to the edit page -->

        <div class="section">
        @php
            $redirectUrl = route('accountabilities.show', $accountability->id);
            $loginUrl = url('/') . '?redirect_to=' . urlencode($redirectUrl);
        @endphp  

        <div class="field">
            <label for="accountability_link">Link to accountability Form:</label>
            <!-- Hidden input field for the link -->
            <input type="hidden" id="accountability_link" value="{{ $loginUrl }}" />
            <button onclick="copyLink()">Copy Link</button>
        </div>

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


       
        <div class="section">
            <!-- get the role of the logged in user -->
            @php
                $user = Admin::user();
            @endphp
            <!-- check if the role is finance officer -->
            @if ($user->isRole('finance'))
            @if ($accountability->status != 'closed')
                <a href="{{ admin_url('accountabilities/'.$accountability->id.'/edit') }}" class="btn btn-primary">
                    Close Requisition
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
    </div>
</body>
</html>
