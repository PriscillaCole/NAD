<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Toastr CSS & JS from a CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Funds Requisition Report</title>
    <style>
        /* * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        } */

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding-left: 0;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
            width: 1000px;
        }

        .logo1 {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #667eea;
            font-weight: bold;
            overflow: hidden;
        }

        .header h1 {
            font-size: 2.5em;
            font-weight: 300;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .header .subtitle {
            font-size: 1.1em;
            opacity: 0.9;
            font-weight: 300;
        }

        .content {
            padding: 40px;
        }

        .status-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 15px;
            border-left: 4px solid #667eea;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-approved { background: #d1ecf1; color: #0c5460; }
        .status-accepted { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }
        .status-amended { background: #e2e3e5; color: #383d41; }

        .section {
            margin-bottom: 40px;
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            margin-right: 15px;
        }

        .section-title {
            font-size: 1.4em;
            font-weight: 600;
            color: #2c3e50;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            border-left: 4px solid #667eea;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .info-label {
            font-size: 0.9em;
            color: #666;
            font-weight: 500;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .info-label i {
            margin-right: 8px;
            color: #667eea;
        }

        .info-value {
            font-size: 1.1em;
            font-weight: 600;
            color: #2c3e50;
            word-break: break-word;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 15px;
            font-weight: 600;
            text-align: left;
            font-size: 0.9em;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            color: #495057;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .total-row {
            background: #f8f9fa !important;
            font-weight: 600;
            color: #2c3e50;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9em;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            margin: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-approve {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }

        .btn-reject {
            background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
            color: white;
        }

        .btn-amend {
            background: linear-gradient(135deg, #17a2b8 0%, #6610f2 100%);
            color: white;
        }

        .signatures-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin-top: 40px;
        }

        .signatures-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .signature-card {
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .signature-img {
            width: 150px;
            height: 75px;
            object-fit: contain;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .signature-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9em;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #e9ecef;
        }

        .download-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .download-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .close {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #999;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close:hover {
            color: #333;
        }

        .modal h3 {
            margin-bottom: 20px;
            color: #2c3e50;
            font-size: 1.3em;
        }

        .modal textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-family: inherit;
            font-size: 1em;
            resize: vertical;
            min-height: 100px;
        }

        .modal textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .spinner {
            display: none;
            margin-right: 8px;
        }

        @media print {
            .no-print { display: none !important; }
            body { background: white; padding: 0; }
            .container { box-shadow: none; border-radius: 0; }
            .header { background: #667eea !important; -webkit-print-color-adjust: exact; }
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .status-bar {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <div class="logo1">
                <img style="width: 100%" src="{{ asset('login-template/images/logo.webp') }}" alt="Logo" >
                {{-- NAD --}}</div>
            <h1>Funds Requisition Report</h1>
            <div class="subtitle">Financial Accountability & Transparency</div>
        </div>

        <div class="content">
            <!-- Status Bar -->
            <div class="status-bar">
                <div>
                    <div class="info-label"><i class="fas fa-calendar"></i> Date Created</div>
                    <div class="info-value">{{ $requisition->created_at }}</div>
                </div>
                
                <div>
                    <div class="info-label"><i class="fas fa-file-download"></i> Concept Note</div>
                    @php 
                        if ($requisition->program?->type == 2){
                            $activityConcept = \App\Models\Requisition::where('outcome_id', $requisition->adminoutcome?->id)->first();
                        }else {
                            $activityConcept = \App\Models\Requisition::where('activity_id', $requisition->activity->id)->where('concept_note', '!=', null)->first();
                            Log::info('Activity Concept Note: ' . ($activityConcept->concept_note ?? 'Not found'));
                        }
                
                    @endphp
                    
                    <a href="{{ asset('storage/'.$activityConcept->concept_note) }}" 
                       download 
                       class="download-link no-print"
                       onclick="forceDownload(event, '{{ asset('storage/' . ($activityConcept->concept_note ?? '')) }}')">
                        Download Concept Note
                    </a>
                </div>
                
                <div>
                    <div class="info-label"><i class="fas fa-info-circle"></i> Status</div>
                    
                    <span class="status-badge status-{{ $requisition->status ?? 'pending' }}">
                        {{ ucfirst($requisition->status ?? 'Pending') }}
                    </span>
                </div>
                
                <button class="btn btn-primary no-print" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Report
                </button>
            </div>

            <!-- Report Details Section -->
            <div class="section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="section-title">Report Details</div>
                </div>
                
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label"><i class="fas fa-id-badge"></i> Staff ID</div>
                        <div class="info-value">{{ $requisition->staff->staff_number }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label"><i class="fas fa-user"></i> Staff Member</div>
                        <div class="info-value">{{ $requisition->staff->name  }}</div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label"><i class="fas fa-hashtag"></i> Requisition ID</div>
                        <div class="info-value">{{ $requisition->code }}</div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label"><i class="fas fa-project-diagram"></i> Program</div>
                        <div class="info-value">{{ $requisition->program?->name }}</div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label"><i class="fas fa-tasks"></i> Activity</div>
                        @if ($requisition->program?->type == 2)
                            <div class="info-value">{{ $requisition->adminoutcome->name }}</div> 
                        @else
                            <div class="info-value">{{ $requisition->activity->name }}</div>   
                        @endif
                        
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label"><i class="fas fa-wallet"></i> Activity Remaining Budget</div>
                        <div class="info-value">UGX {{ number_format($remaining ) }}</div>
                    </div>
                    
                    
                </div>
            </div>

            <!-- Financial Details Section -->
            <div class="section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="section-title">Financial Details</div>
                </div>
                
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Frequency</th>
                                <th>Unit Price (UGX)</th>
                                <th>Total Price (UGX)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample data - replace with actual loop -->
                            @php
                                $counter = 1;
                            @endphp
                            @foreach($requisition->requisition_items as $item)
                                <?php
                                    // Assuming you have fetched $item from the database
                                    $unit_price = $item->unit_price;
                                    $quantity = $item->quantity;
                                    $frequency = $item->frequency;
                                    $total_price = $unit_price * $quantity* $frequency ;
                                ?>
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    @if($item->admin_budget_line_id)
                                        <td>{{ $item->adminbudgetline->name }}</td>
                                    @else
                                        <td>{{ $item->budgetline->name }}</td>
                                    @endif
                                    <td>{{ $item->quantity }} {{$item->unit_of_measure}}</td>
                                    <td>{{ $item->frequency }} </td>
                                    <td>{{ number_format($item->unit_price) }}</td>
                                    <td>{{ number_format($total_price) }}</td>
                                </tr>
                            @endforeach
                           
                            <tr class="total-row">
                                <td colspan="5"><strong>Total Estimated Cost (UGX):</strong></td>
                                <td><strong>{{ number_format($requisition->amount) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Approval Section -->
            {{-- <div class="section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="section-title">Approval Process</div>
                </div>
                
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Role</th>
                                <th>Reviewed By</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Program Manager</td>
                                <td>{{ $requisition->staff->name ?? 'Nantabo Hildah' }}</td>
                                <td><span class="status-badge status-accepted">Submitted</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Head of Finance</td>
                                <td>Mwebaza Rolaine</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> --}}

            <!-- Comments Section -->
            <div class="section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="section-title">Comments & Feedback</div>
                </div>
                
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Comment</th>
                                <th>Created By</th>
                                <th>Date</th>
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
            </div>

            <!-- Signatures Section -->
            <div class="signatures-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-signature"></i>
                    </div>
                    <div class="section-title">Digital Signatures</div>
                </div>
                
                <div class="signatures-grid">
                    <div class="signature-card">
                        {{-- <img src="data:image/svg+xml,%3Csvg xmlns='{{ asset('storage/'.$requisition->staff->signature) }}' width='150' height='75' viewBox='0 0 150 75'%3E%3Crect width='150' height='75' fill='%23f8f9fa' stroke='%23dee2e6'/%3E%3Ctext x='75' y='40' text-anchor='middle' font-family='Arial' font-size='12' fill='%23666'%3ESignature%3C/text%3E%3C/svg%3E" 
                             alt="Signature" class="signature-img"> --}}
                        <img src="{{ asset('storage/'.$requisition->staff->signature) }}" alt="Signature" class="signature-img">
                        <div class="signature-name">{{ $requisition->staff->name ?? 'Nantabo Hildah' }}<br>Program Manager</div>
                    </div>
                    @if ($requisition->status != 'pending')
                        <div class="signature-card">
                            <img src="{{ asset('storage/signatures/hofs.png') }}" alt="signature" class="signature-img">
                            <div class="signature-name">Mwebaza Rolaine<br>Head of Finance</div>
                        </div>
                        @if($requisition->status == 'approved')
                            <div class="signature-card">
                                <img src="{{ asset('storage/signatures/cds.png') }}" alt="signature" class="signature-img">
                                <div class="signature-name">Edson Ngirabakunzi<br>Country Director</div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            @if(auth()->user()!=null)
                @if(auth()->user()->roles->isNotEmpty())
                    @foreach(auth()->user()->roles as $role)
                        @if($role->slug == 'finance' && $requisition->status == 'pending')
                <!-- Action Buttons -->
                            <div class="action-buttons no-print">
                                <a href="#" id="acceptBtn" class="btn btn-approve">
                                    <i class="fas fa-check"></i> Accept
                                </a>
                                <a href="#" id="rejectBtn" class="btn btn-reject">
                                    <i class="fas fa-times"></i> Reject
                                </a>
                                <a href="#" id="haltBtn" class="btn btn-amend">
                                    <i class="fas fa-pause"></i> On Hold
                                </a>
                                <a href="#" id="amendBtn" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Amend
                                </a>
                            </div>
                            @elseif($role->slug == 'director' && $requisition->status == 'accepted')
                                <div class="action-buttons no-print">
                                    <a href="#" id="approveBtn" class="btn btn-approve">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                    <a href="#" id="rejectBtn" class="btn btn-reject">
                                        <i class="fas fa-times"></i> Reject
                                    </a>
                                    <a href="#" id="haltBtn" class="btn btn-amend">
                                        <i class="fas fa-pause"></i> On Hold
                                    </a>
                                    <a href="#" id="amendBtn" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Amend
                                    </a>
                                </div>

                            {{-- @endif --}}
                        @endif
                            
                    @endforeach
                @endif
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div id="reasonModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3><i class="fas fa-comment"></i> Enter Comment</h3>
            <form id="reasonForm">
                <textarea id="reason" placeholder="Enter your comment here..." required></textarea>
                <br><br>
                <button type="button" id="submitReason" class="btn btn-approve">
                    <span id="spinner" class="spinner">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                    <i class="fas fa-paper-plane"></i> Submit
                </button>
            </form>
        </div>
    </div>

    <script>
        // Modal functionality
        var modal = document.getElementById("reasonModal");
        var closeBtn = document.getElementsByClassName("close")[0];
        
        var approveBtn = document.getElementById("approveBtn");
        var acceptBtn = document.getElementById("acceptBtn");
        var rejectBtn = document.getElementById("rejectBtn");
        var haltBtn = document.getElementById("haltBtn");
        var submitReason = document.getElementById("submitReason");
        var reasonInput = document.getElementById("reason");

        // Event listeners for buttons
        if (acceptBtn) {
            acceptBtn.onclick = function(e) {
                e.preventDefault();
                modal.style.display = "block";
                submitReason.onclick = function() {
                    sendReason('accepted');
                }
            }
        }
        // Event listeners for buttons
        if (approveBtn) {
            approveBtn.onclick = function(e) {
                e.preventDefault();
                modal.style.display = "block";
                submitReason.onclick = function() {
                    sendReason('approved');
                }
            }
        }


        if (rejectBtn) {
            rejectBtn.onclick = function(e) {
                e.preventDefault();
                modal.style.display = "block";
                submitReason.onclick = function() {
                    sendReason('rejected');
                }
            }
        }

        if (haltBtn) {
            haltBtn.onclick = function(e) {
                e.preventDefault();
                modal.style.display = "block";
                submitReason.onclick = function() {
                    sendReason('halted');
                }
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
            event.preventDefault();
            
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
                    if (typeof toastr !== 'undefined') {
                        toastr.error('There was an error downloading the file.', 'Error');
                    }
                });
        }

        function sendReason(action) {
            var reason = reasonInput.value;
            var submitButton = document.getElementById('submitReason');
            var spinner = document.getElementById('spinner');

            if (reason.trim() === '') {
                if (typeof toastr !== 'undefined') {
                    toastr.error('Please enter a reason.', 'Error');
                }
                return;
            }

            // Show loading state
            submitButton.disabled = true;
            spinner.style.display = 'inline-block';
            submitButton.innerHTML = '<span class="spinner"><i class="fas fa-spinner fa-spin"></i></span> Submitting...';

            var requisitionId = '{{ $requisition->id }}'; // Ensure this is correctly set

            var data = {
                action: action,
                reason: reason,
                requisition_id: requisitionId
            };
            // Simulate API call (replace with actual implementation)
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
                window.location.reload();

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
            /* setTimeout(() => {
                console.log('Action:', action, 'Reason:', reason);
                
                if (typeof toastr !== 'undefined') {
                    toastr.success('Your decision has been recorded.', 'Success');
                }
                
                modal.style.display = "none";
                
                // Reset button state
                submitButton.disabled = false;
                spinner.style.display = 'none';
                submitButton.innerHTML = '<i class="fas fa-paper-plane"></i> Submit';
                reasonInput.value = '';
            }, 2000); */
        }

        // Add smooth scrolling for better UX
        // document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        //     anchor.addEventListener('click', function (e) {
        //         e.preventDefault();
        //         const target = document.querySelector(this.getAttribute('href'));
        //         if (target) {
        //             target.scrollIntoView({
        //                 behavior: 'smooth',
        //                 block: 'start'
        //             });
        //         }
        //     });
        // });
    </script>
</body>
</html>