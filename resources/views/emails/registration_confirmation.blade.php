@php
    $url = admin_url('/auth/setting');
    $siteName = config('app.name'); // Utilisez le nom de votre site
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to {{ $siteName }}</title>
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
            <h2>Welcome </h2>
        </div>

        <p>Dear {{ $username }},</p>

        <p>Welcome to the NAD Requisiton Management System! Your Registration was successful.</p>
        <p>Use the credentials below to login into the system.</p>

        <table>
            <tr>
                <th>User name:</th>
                <td>{{ $username }}</td>
            </tr>
            <tr>
                <th>Password:</th>
                <td>{{ $password }}</td>
            </tr>
            
        </table>
        <p>You can change your password in user settings <a href="{{ $url }}">Click here</a> to head to the system.</p>
        {{-- <p>Thank you for joining us! <a href="{{ $url }}">Click here</a> to head to the system.</p> --}}

        <p>Thank you,<br>
        {{ config('app.name') }} Team</p>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>

