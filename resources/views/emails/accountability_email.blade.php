<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Accountability Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            color: #333;
            line-height: 1.5;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .header {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 6px 6px 0 0;
        }
        .footer {
            font-size: 12px;
            color: #aaa;
            text-align: center;
            margin-top: 30px;
        }
        .status {
            font-weight: bold;
            color: #007bff;
        }
        .button {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 20px;
            text-decoration: none;
        }
        .button:hover {
            background: #0056b3;
        }
        table {
            margin-top: 10px;
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 8px 0;
        }
        th {
            width: 40%;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Accountability Notification</h2>
        </div>

        <p>Dear {{ $user->name }},</p>

        <p>
            This is to inform you that accountability for the requisition
            <strong>{{ $accountability->requisition->code ?? 'N/A' }}</strong> 
            has been <span class="status">{{ ucfirst($action) }}</span>
            by {{$by}}.
        </p>

        <table>
            <tr>
                <th>Requisition ID:</th>
                <td>{{ $accountability->requisition->code ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Program:</th>
                <td>{{ $accountability->requisition->program->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Amount Used:</th>
                <td>UGX {{ number_format($accountability->amount_used ?? 0) }}</td>
            </tr>
            <tr>
                <th>Date Submitted:</th>
                <td>{{ \Carbon\Carbon::parse($accountability->created_at)->format('d M, Y') }}</td>
            </tr>
            
        </table>

        <p>You can view the accountability details in the system.</p>

        <a href="{{ url('/accountabilities/' . $accountability->id) }}" class="button">View Accountability</a>

        <p>Thank you,<br>
        {{ config('app.name') }} Team</p>

        <div class="footer">
            &copy; {{ date('Y') }} NAD Uganda. All rights reserved.
        </div>
    </div>
</body>
</html>
