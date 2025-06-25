<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Requisition Notification</title>
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
            <h2>Reset Password</h2>
        </div>

        <p>Hello,</p>

        <p>
            You requested a password reset for your REQTrack account.
        </p>
        <p>Click the button below to reset your password:</p>

        <center style="margin: 20px 0;">
            <a href="{{ $url }}" class="button">Reset Password</a>
        </center>

        <p>This password reset link will expire in {{ $count }} minutes.</p>
        <p>If you did not request this reset, please ignore this email.</p>

        <p>Thank you,<br>
        {{ config('app.name') }} Team</p>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
