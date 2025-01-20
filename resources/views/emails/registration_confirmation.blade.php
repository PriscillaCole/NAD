@php
    $url = admin_url('/auth/setting');
    $siteName = config('app.name'); // Utilisez le nom de votre site
@endphp
<!DOCTYPE html>
<html>

<head>
    <title>Welcome to {{ $siteName }}</title>
</head>

<body>
    <p>Hello {{ $username }},</p>
    <p>Welcome to the NAD Requisiton Management System! Your Registration was successful.</p>
    <p>Use <strong>{{ $username }}</strong> as the username and <strong>{{ $password }}</strong> as the password to login.</p>
    <p>Thank you for joining us! <a href="{{ $url }}">Click here</a> to head to the system.</p>
    <p>Sincerely,<br> NAD {{ $siteName }}</p>
</body>

</html>

