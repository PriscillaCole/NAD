<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accountability Report</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* body {
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
            width: 100%;
        }

        .logo1 {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: contain;
            background: white;
            margin-bottom: 20px;
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

        .section-header i {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            font-size: 16px;
            margin-right: 15px;
        }

        .section-header h2 {
            font-size: 1.4em;
            color: #2c3e50;
            font-weight: 600;
        }

        .status-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .status-badge {
            display: inline-block;
            align-items: center;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: none;
            transition: none;
        }

        .status-badge i {
            margin-right: 8px;
        }

        .status-pending {
            background: linear-gradient(135deg, #ffeaa7, #fdcb6e);
            color: #2d3436;
        }

        .status-closed {
            background: linear-gradient(135deg, #55efc4, #00b894);
            color: white;
        }

        .status-halted {
            background: linear-gradient(135deg, #fd79a8, #e84393);
            color: white;
        }

        .status-amended {
            background: linear-gradient(135deg, #74b9ff, #0984e3);
            color: white;
        }

        .status-not-submitted {
            background: linear-gradient(135deg, #a29bfe, #6c5ce7);
            color: white;
        }

        .print-button {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 0.9em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .print-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
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
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .info-card h3 {
            color: #2c3e50;
            font-size: 1.1em;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .info-card p {
            color: #2c3e50;
            font-size: 1em;
            font-weight: 600;
        }

        .money-highlight {
            font-size: 1.1em;
            font-weight: 700;
            color: #27ae60;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            margin-bottom: 20px;
        }

        .modern-table th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9em;
            letter-spacing: 0.5px;
        }

        .modern-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            color: #495057;
            vertical-align: top;
        }

        .modern-table tr:hover td {
            background-color: #f8f9fa;
        }

        .modern-table tr:last-child td {
            border-bottom: none;
        }

        .file-list {
            list-style: none;
            padding: 0;
        }

        .file-list li {
            margin-bottom: 12px;
        }

        .file-link {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.9em;
            font-weight: 600;
            transition: all 0.3s ease;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .file-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(102, 126, 234, 0.3);
            color: white;
            text-decoration: none;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #e9ecef;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 0.9em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #fd79a8, #e84393);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
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
            animation: fadeIn 0.3s ease-out;
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #667eea;
        }

        .modal h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.3em;
        }

        .modal textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1em;
            resize: vertical;
            min-height: 100px;
            transition: border-color 0.3s ease;
        }

        .modal textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .preview-modal-content {
            max-width: 900px;
            padding: 20px;
            position: relative;
        }

        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .preview-header h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #2c3e50;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .preview-frame {
            width: 100%;
            height: 65vh;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            background: #f8f9fa;
        }

        .preview-image {
            width: 100%;
            max-height: 65vh;
            object-fit: contain;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            background: #f8f9fa;
            display: none;
        }

        .preview-fallback {
            display: none;
            padding: 24px;
            text-align: center;
            color: #495057;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            background: #f8f9fa;
        }

        .preview-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 15px;
        }

        .spinner {
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .no-print {
            /* Will be hidden in print styles */
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .info-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
            
            .container {
                box-shadow: none;
                border-radius: 0;
                background: white;
            }
            
            .header {
                background: #667eea !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            
            .no-print {
                display: none !important;
            }
            
            .file-link {
                background: #667eea !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }

        @media (max-width: 768px) {
            /* .container {
                margin: 10px;
                border-radius: 15px;
            } */
            
            .container {
                flex-wrap: nowrap; /* don't wrap rows, stay in single line */
                overflow-x: auto;  /* allow horizontal scroll on small screens */
                -webkit-overflow-scrolling: touch; /* smooth scroll on iOS */
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .content {
                padding: 20px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .status-container {
                flex-direction: column;
                align-items: stretch;
            }
            
            .modern-table {
                font-size: 0.9rem;
            }
            
            .modern-table th,
            .modern-table td {
                padding: 15px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('login-template/images/logo.webp') }}" alt="Logo" class="logo1">
            <h1>Accountability Report</h1>
            <p class="subtitle">Financial Accountability & Transparency</p>
        </div>

        <div class="content">
            <div class="section">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i>
                    <h2>Report Details</h2>
                </div>
                
                <div class="status-container">
                    <div>
                        @if ($accountability->status == 'pending')
                            <span class="status-badge status-pending">
                                <i class="fas fa-clock"></i>
                                Pending
                            </span>
                        @elseif ($accountability->status == 'closed')
                            <span class="status-badge status-closed">
                                <i class="fas fa-check-circle"></i>
                                Closed
                            </span>
                        @elseif ($accountability->status == 'halted')
                            <span class="status-badge status-halted">
                                <i class="fas fa-exclamation-triangle"></i>
                                Halted
                            </span>
                        @elseif ($accountability->status == 'amended')
                            <span class="status-badge status-amended">
                                <i class="fas fa-edit"></i>
                                Amended
                            </span>
                        @else
                            <span class="status-badge status-not-submitted">
                                <i class="fas fa-file-alt"></i>
                                Not Submitted
                            </span>
                        @endif
                    </div>
                    <button class="print-button no-print" onclick="window.print()">
                        <i class="fas fa-print"></i>
                        Print Report
                    </button>
                </div>

                <div class="info-grid">
                    <div class="info-card">
                        <h3><i class="fas fa-user"></i> Staff Member</h3>
                        <p>{{$accountability->requisition->staff->name}}</p>
                    </div>
                    <div class="info-card">
                        <h3><i class="fas fa-hashtag"></i> Requisition ID</h3>
                        <p>{{$accountability->requisition->code}}</p>
                    </div>
                    <div class="info-card">
                        <h3><i class="fas fa-project-diagram"></i> Program</h3>
                        <p>  
                            {{-- @if($accountability->requisition->program?->type == 2) --}}
                                {{ $accountability->requisition->program->name }}
                            {{-- @else
                                {{ $accountability->requisition->activity->output->outcome->program->name }}
                            @endif --}}
                        </p>
                    </div>
                    @if(!$accountability->requisition->admin_program_id)
                    <div class="info-card">
                        <h3><i class="fas fa-tasks"></i> Activity</h3>
                        @if($accountability->requisition->program?->type == 2)
                            <p>{{ $accountability->requisition->adminoutcome->name }}</p>
                        @else
                            <p>{{ $accountability->requisition->activity->name }}</p>
                        @endif
                    </div>
                    @endif
                    <div class="info-card">
                        <h3><i class="fas fa-money-bill-wave"></i> Money Dispensed</h3>
                        <p class="money-highlight">UGX {{ number_format($accountability->requisition->amount)}}</p>
                    </div>
                </div>
            </div>

            <div class="section no-print">
                <div class="section-header">
                    <i class="fas fa-file-alt"></i>
                    <h2>Narrative Report</h2>
                </div>
                
                {{-- <div class="info-card"> --}}
                    <a href="{{ asset('storage/'.$accountability->narrative_report) }}" target="_blank" class="file-link no-print preview-doc-link">
                        <i class="fas fa-download"></i>
                        View Narrative Report
                    </a>
                {{-- </div> --}}
            </div>

            <div class="section">
                <div class="section-header">
                    <i class="fas fa-shopping-cart"></i>
                    <h2>Requisition Item Receipts</h2>
                </div>
                
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-tag"></i> Item Name</th>
                            <th><i class="fas fa-coins"></i> Amount Disbursed</th>
                            <th><i class="fas fa-money-check"></i> Amount Used</th>
                            <th><i class="fas fa-exchange-alt"></i> Transfer Charge</th>
                            <th><i class="fas fa-calculator"></i> Total Amount</th>
                            <th class="no-print"><i class="fas fa-paperclip"></i> Receipts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accountability->requisition->requisition_items as $item)
                            <tr>
                                <td>
                                    @if($accountability->requisition->program?->type == 2)
                                        {{ $item->adminbudgetline->name }}
                                    @else
                                        {{ $item->budgetline->name }}
                                    @endif
                                </td>
                                <td><span class="money-highlight">UGX {{ number_format($item->total_price, 2)}}</span></td>
                                
                                @foreach($item->requisitionItemReceipts as $receipt)
                                    <td><span class="money-highlight">UGX {{ number_format($receipt->amount, 2) }}</span></td>
                                    <td>UGX {{ number_format($receipt->transfer_charges ?? 0)}}</td>
                                    <td><span class="money-highlight">UGX {{ number_format(($receipt->amount + ($receipt->transfer_charges ?? 0)), 2) }}</span></td>
                                @endforeach
                               
                                <td class="no-print">
                                    @if($item->requisitionItemReceipts->isNotEmpty())
                                        <ul class="file-list">
                                            @foreach($item->requisitionItemReceipts as $receipt)
                                                @if ($receipt->Invoice)
                                                    @foreach($receipt->Invoice as $rpt)
                                                        <li>
                                                            <a href="{{ asset('storage/'.$rpt) }}" target="_blank" class="file-link no-print preview-doc-link">
                                                                <i class="fas fa-file-invoice"></i>
                                                                Invoice {{ $loop->iteration }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                                @if ($receipt->payment_proof)
                                                    @foreach($receipt->payment_proof as $rpt)
                                                        <li>
                                                            <a href="{{ asset('storage/'.$rpt) }}" target="_blank" class="file-link no-print preview-doc-link">
                                                                <i class="fas fa-credit-card"></i>
                                                                Payment Proof {{ $loop->iteration }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                                @if ($receipt->receipt_file)
                                                    @foreach($receipt->receipt_file as $rpt)
                                                        <li>
                                                            <a href="{{ asset('storage/'.$rpt) }}" target="_blank" class="file-link no-print preview-doc-link">
                                                                <i class="fas fa-receipt"></i>
                                                                Receipt {{ $loop->iteration }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </ul>
                                    @else
                                        <p style="color: #6c757d;">No receipts available for this item.</p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); font-weight: bold;">
                            <td colspan="4"><strong><i class="fas fa-calculator"></i> Total Amount Used</strong></td>
                            <td><span class="money-highlight">UGX {{ number_format($accountability->amount_used)}}</span></td>
                            <td class="no-print"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="section">
                <div class="section-header">
                    <i class="fas fa-calculator"></i>
                    <h2>Financial Details</h2>
                </div>
                
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-arrow-left"></i> Amount Returned to Finance</th>
                            <th><i class="fas fa-receipt"></i> Receipt (Finance)</th>
                            <th><i class="fas fa-arrow-right"></i> Excess Returned to Staff</th>
                            <th><i class="fas fa-receipt"></i> Receipt (Staff)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <span class="money-highlight">UGX {{ number_format($accountability->returned_amount ?? 0) }}</span>
                            </td>
                            <td>
                                @if($accountability->proof_of_funds_returned)
                                    <a href="{{ asset('storage/'.$accountability->proof_of_funds_returned) }}" target="_blank" class="file-link no-print preview-doc-link">
                                        <i class="fas fa-eye"></i>
                                        View Receipt
                                    </a>
                                @else
                                    <span style="color: #6c757d;">No Receipt</span>
                                @endif
                            </td>
                            <td>
                                <span class="money-highlight">UGX {{ number_format($accountability->amount_to_be_returned ?? 0) }}</span>
                            </td>
                            <td>
                                @if($accountability->proof_of_funds_to_be_returned)
                                    <a href="{{ asset('storage/'.$accountability->proof_of_funds_to_be_returned) }}" target="_blank" class="file-link no-print preview-doc-link">
                                        <i class="fas fa-eye"></i>
                                        View Receipt
                                    </a>
                                @else
                                    <span style="color: #6c757d;">No Receipt</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="section no-print">
                <div class="section-header">
                    <i class="fas fa-paperclip"></i>
                    <h2>Other Attachment Files</h2>
                </div>
                
                @if($accountability->attachments)
                    <ul class="file-list">
                        @foreach($accountability->attachments as $receipt)
                            <li>
                                <a href="{{ asset('storage/'.$receipt) }}" target="_blank" class="file-link no-print preview-doc-link">
                                    <i class="fas fa-file"></i>
                                    Attachment {{ $loop->iteration }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{-- <div class="info-card"> --}}
                        <p style="color: #6c757d;">No additional attachments available.</p>
                    {{-- </div> --}}
                @endif
            </div>
            
            <div class="section">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i>
                    <h2>Additional Information</h2>
                </div>
                
                <div class="info-grid">
                    <div class="info-card">
                        <h3><i class="fas fa-calendar"></i> Created Date</h3>
                        <p>{{ $accountability->created_at->format('d F, Y') }}</p>
                    </div>
                    @if ($accountability->remarks != null)
                    <div class="info-card">
                        <h3><i class="fas fa-calendar"></i> Comment</h3>
                        <p>{{ $accountability->remarks }}</p>
                    </div>
                    @endif
                    
                    @if ($accountability->status == 'closed')
                        <div class="info-card">
                            <h3><i class="fas fa-user-check"></i> Closed By</h3>
                            <p>
                                @php
                                    $HOF = \App\Models\Staff::where('user_id', $accountability->signature)->first()
                                @endphp
                                @if ($accountability->signature)
                                    
                                    {{ $HOF->name }}, Head of Finance
                                @else
                                    No review yet
                                @endif
                            </p>
                        </div>
                        
                        @if ($accountability->staff)
                            <div class="info-card">
                                <h3><i class="fas fa-signature"></i> Authorized Signature</h3>
                                <img src="{{ asset('storage/'. $HOF->signature) }}" alt="Signature" style="width: 200px; height: 100px; border-radius: 10px; margin-top: 10px;">
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <div class="section no-print">
                @php
                    $user = Admin::user();
                @endphp
                
                <div class="action-buttons">
                    @if (($user->isRole('staff') || $user->isRole('admin')) && $accountability->status == '')
                        <a href="#" id="forward" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Forward to Finance
                        </a>
                    @endif
                    
                    @if ($user->isRole('finance') && $accountability->status != 'closed')
                        <a href="#" id="closeBtn" class="btn btn-primary">
                            <i class="fas fa-check-circle"></i>
                            Close Requisition
                        </a>
                        <a href="#" id="haltBtn" class="btn btn-danger">
                            <i class="fas fa-stop-circle"></i>
                            Halt Requisition
                        </a>
                    @elseif ($user->isRole('finance') && $accountability->status == 'closed')
                        <button class="btn btn-primary" disabled>
                            <i class="fas fa-lock"></i>
                            Closed Requisition
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="footer">
            <p><i class="fas fa-cogs"></i> Generated by ReQTrack System</p>
        </div>

        <!-- Modal -->
        <div id="reasonModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Enter Comment</h3>
                <form id="reasonForm">
                    <textarea id="reason" rows="4" style="width: 100%;" placeholder="Enter reason here..."></textarea>
                    <br><br>
                    <button type="button" id="submitReason" {{-- class="btn btn-approve" --}} class="status-badge status-closed">
                        <span id="spinner" class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> <!-- Font Awesome Spinner Icon -->
                        </span>
                        Submit
                    </button>
                </form>
            </div>
        </div>

        
    </div>
    <div id="previewModal" class="modal no-print">
            <div class="modal-content preview-modal-content">
                <span class="close" id="previewClose">&times;</span>
                <div class="preview-header">
                    <h3 id="previewTitle"><i class="fas fa-file-alt"></i> Document Preview</h3>
                </div>
                <iframe id="previewFrame" class="preview-frame" title="Document Preview"></iframe>
                <img id="previewImage" class="preview-image" alt="Document Preview">
                <div id="previewFallback" class="preview-fallback">
                    Preview is not available for this file type in-browser.
                </div>
                <div class="preview-actions">
                    <a id="openPreviewDoc" class="btn btn-primary" target="_blank" rel="noopener">
                        <i class="fas fa-external-link-alt"></i>
                        Open in New Tab
                    </a>
                    <a id="downloadPreviewDoc" class="btn btn-primary" download>
                        <i class="fas fa-download"></i>
                        Download
                    </a>
                </div>
            </div>
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
    <script>
        // Modal functionality
        var modal = document.getElementById("reasonModal");
        var cross = document.getElementsByClassName("close")[0];
        var previewModal = document.getElementById("previewModal");
        var previewClose = document.getElementById("previewClose");
        var previewFrame = document.getElementById("previewFrame");
        var previewImage = document.getElementById("previewImage");
        var previewFallback = document.getElementById("previewFallback");
        var previewTitle = document.getElementById("previewTitle");
        var openPreviewDoc = document.getElementById("openPreviewDoc");
        var downloadPreviewDoc = document.getElementById("downloadPreviewDoc");
        var previewLinks = document.querySelectorAll(".preview-doc-link");
        var currentPreviewUrl = "";

        var closeBtn = document.getElementById("closeBtn");
        var forward = document.getElementById("forward");
        
        var haltBtn = document.getElementById("haltBtn");
        var submitReason = document.getElementById("submitReason");
        var reasonInput = document.getElementById("reason");

        if (closeBtn) {
            closeBtn.onclick = function(e) {
                e.preventDefault();
                saveAccept('closed');
            }
        }

        if (forward) {
            forward.onclick = function(e) {
                e.preventDefault();
                saveAccept('pending');
                
            };
        }
        cross.onclick = function() {
            modal.style.display = "none";
        }

        if (closeBtn) {
            haltBtn.onclick = function() {
                modal.style.display = "block";
                submitReason.onclick = function() {
                    sendReason('halted');
                }
            }
        }

        function resetPreviewView() {
            previewFrame.style.display = "none";
            previewImage.style.display = "none";
            previewFallback.style.display = "none";
            previewFrame.removeAttribute('src');
            previewImage.removeAttribute('src');
        }

        function getFileExtension(url) {
            var cleanUrl = url.split('?')[0].split('#')[0];
            return cleanUrl.includes('.') ? cleanUrl.split('.').pop().toLowerCase() : '';
        }

        function openDocumentPreview(url, title) {
            currentPreviewUrl = url;
            resetPreviewView();
            previewTitle.innerHTML = '<i class="fas fa-file-alt"></i> ' + title;

            var extension = getFileExtension(url);
            var imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
            var frameExtensions = ['pdf', 'txt'];

            if (imageExtensions.indexOf(extension) !== -1) {
                previewImage.src = url;
                previewImage.style.display = 'block';
            } else if (frameExtensions.indexOf(extension) !== -1) {
                previewFrame.src = url;
                previewFrame.style.display = 'block';
            } else {
                previewFallback.style.display = 'block';
            }

            openPreviewDoc.href = url;
            downloadPreviewDoc.href = url;
            previewModal.style.display = 'block';
        }

        previewLinks.forEach(function(link, index) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                var documentTitle = this.textContent.trim() || ('Document ' + (index + 1));
                openDocumentPreview(this.getAttribute('href'), documentTitle);
            });
        });
        if (downloadPreviewDoc) {
            downloadPreviewDoc.onclick = function() {
                if (!currentPreviewUrl) {
                    return;
                }
                forceDownload(event, currentPreviewUrl);

            }
        }

        if (previewClose) {
            previewClose.onclick = function() {
                previewModal.style.display = 'none';
                resetPreviewView();
            }
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }

            if (event.target == previewModal) {
                previewModal.style.display = 'none';
                resetPreviewView();
            }
        }

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
                window.location.reload();

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
                window.location.reload();

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
                