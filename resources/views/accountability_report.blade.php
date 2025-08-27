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
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: slideIn 0.8s ease-out;
            padding-left: 0px;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
            width: 1000px
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-50px, -50px) rotate(360deg); }
        }

        .logo1 {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }

        .header .subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .content {
            padding: 40px;
        }

        .section {
            /* margin-bottom: 40px; */
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .section:nth-child(1) { animation-delay: 0.1s; }
        .section:nth-child(2) { animation-delay: 0.2s; }
        .section:nth-child(3) { animation-delay: 0.3s; }
        .section:nth-child(4) { animation-delay: 0.4s; }
        .section:nth-child(5) { animation-delay: 0.5s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
            position: relative;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .section-header i {
            font-size: 1.5rem;
            color: #667eea;
            margin-right: 15px;
        }

        .section-header h2 {
            font-size: 1.8rem;
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
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .status-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
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
            border-radius: 25px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .print-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .info-card {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
            padding-left: 5px;
            border-left: 5px solid #667eea;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .info-card h3 {
            color: #2c3e50;
            font-size: 1.4rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .info-card p {
            color: #5a6c7d;
            font-size: 1.2rem;
            font-weight: 500;
        }

        .money-highlight {
            font-size: 1.3rem;
            font-weight: 700;
            color: #27ae60;
        }

        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .modern-table th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            text-align: left;
            font-weight: 600;
            font-size: 1.3rem;
            position: relative;
        }

        .modern-table th::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: rgba(255, 255, 255, 0.2);
        }

        .modern-table td {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
            transition: all 0.3s ease;
            vertical-align: top;
        }

        .modern-table tr:hover td {
            background-color: #f8f9ff;
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
            border-radius: 25px;
            font-size: 1.2rem;
            font-weight: 500;
            transition: all 0.3s ease;
            gap: 8px;
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
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            font-size: 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
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
            padding: 40px;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: slideInScale 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInScale {
            from {
                opacity: 0;
                transform: scale(0.8) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
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
            font-size: 1.5rem;
        }

        .modal textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1.5rem;
            resize: vertical;
            min-height: 120px;
            transition: border-color 0.3s ease;
        }

        .modal textarea:focus {
            outline: none;
            border-color: #667eea;
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
            padding: 30px;
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
                            @if($accountability->requisition->admin_program_id)
                                {{ $accountability->requisition->admin_program->name }}
                            @else
                                {{ $accountability->requisition->activity->output->outcome->program->name }}
                            @endif
                        </p>
                    </div>
                    @if(!$accountability->requisition->admin_program_id)
                    <div class="info-card">
                        <h3><i class="fas fa-tasks"></i> Activity</h3>
                        <p>{{ $accountability->requisition->activity->name }}</p>
                    </div>
                    @endif
                    <div class="info-card">
                        <h3><i class="fas fa-money-bill-wave"></i> Money Dispensed</h3>
                        <p class="money-highlight">UGX {{ number_format($accountability->requisition->amount)}}</p>
                    </div>
                </div>
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
                                    <a href="{{ asset('storage/'.$accountability->proof_of_funds_returned) }}" target="_blank" class="file-link">
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
                                    <a href="{{ asset('storage/'.$accountability->proof_of_funds_to_be_returned) }}" target="_blank" class="file-link">
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
                    <i class="fas fa-file-alt"></i>
                    <h2>Narrative Report</h2>
                </div>
                
                <div class="info-card">
                    <a href="{{ asset('storage/'.$accountability->narrative_report) }}" target="_blank" class="file-link">
                        <i class="fas fa-download"></i>
                        View Narrative Report
                    </a>
                </div>
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
                                    @if($accountability->requisition->admin_program_id)
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
                                                            <a href="{{ asset('storage/'.$rpt) }}" target="_blank" class="file-link">
                                                                <i class="fas fa-file-invoice"></i>
                                                                Invoice {{ $loop->iteration }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                                @if ($receipt->payment_proof)
                                                    @foreach($receipt->payment_proof as $rpt)
                                                        <li>
                                                            <a href="{{ asset('storage/'.$rpt) }}" target="_blank" class="file-link">
                                                                <i class="fas fa-credit-card"></i>
                                                                Payment Proof {{ $loop->iteration }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                                @if ($receipt->receipt_file)
                                                    @foreach($receipt->receipt_file as $rpt)
                                                        <li>
                                                            <a href="{{ asset('storage/'.$rpt) }}" target="_blank" class="file-link">
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

            <div class="section no-print">
                <div class="section-header">
                    <i class="fas fa-paperclip"></i>
                    <h2>Other Receipt Files</h2>
                </div>
                
                @if($accountability->attachments)
                    <ul class="file-list">
                        @foreach($accountability->attachments as $receipt)
                            <li>
                                <a href="{{ asset('storage/'.$receipt) }}" target="_blank" class="file-link">
                                    <i class="fas fa-file"></i>
                                    Attachment {{ $loop->iteration }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="info-card">
                        <p style="color: #6c757d;">No additional receipts available.</p>
                    </div>
                @endif
            </div>
            <!-- Comments Section -->
            {{-- <div class="section">
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
                            @foreach($accountability->comments as $comment)
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
            </div> --}}

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
                                <img src="{{ asset('storage/signatures/hofs.png') }}" alt="Signature" style="width: 200px; height: 100px; border-radius: 10px; margin-top: 10px;">
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
                    @if ($user->isRole('staff') && $accountability->status == '')
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
        var closeBtn = document.getElementById("closeBtn");
        var forward = document.getElementById("forward");
        
        var haltBtn = document.getElementById("haltBtn");
        var submitReason = document.getElementById("submitReason");
        var reasonInput = document.getElementById("reason");

        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                saveAccept('closed');
                
            });
        }

        if (forward) {
            forward.addEventListener('click', function(e) {
                saveAccept('pending');
                
            });
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
                