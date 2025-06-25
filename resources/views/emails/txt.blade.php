{{-- resources/views/emails/auth/reset-password.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Your REQTrack Password</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 30px;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        .button {
            background-color: #4a6cf7;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #888;
            text-align: center;
        }
        .logo {
            width: 100px;
            margin-bottom: 20px;
            margin-left:-114px;
        }
    </style>
</head>
<body>
    <div class="container">
        <center>
            <img src="{{asset('login-template')}}/images/logo-removebg-preview.png" class="logo" alt="REQTrack Logo">
        </center>
        <h2>Hello,</h2>
        <p>You requested a password reset for your REQTrack account.</p>
        <p>Click the button below to reset your password:</p>

        <center style="margin: 20px 0;">
            <a href="{{ $url }}" class="button">Reset Password</a>
        </center>

        <p>This password reset link will expire in {{ $count }} minutes.</p>
        <p>If you did not request this reset, please ignore this email.</p>

        <div class="footer">
            &copy; {{ date('Y') }} REQTrack by Eight Tech Consults Ltd.
        </div>
    </div>
</body>
</html>
