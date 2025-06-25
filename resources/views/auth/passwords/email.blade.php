<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REQTrack - Forgot Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #213172 0%, #885cf7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container { /* Renamed from login-container for consistency */
            background: white;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .logo {
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            position: relative;
        }

        /* The original logo circles are not used with your provided image, but keeping them for consistency in style */
        .logo-circles {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            border: 3px solid;
        }

        .circle-1 {
            width: 60px;
            height: 60px;
            border-color: #4a6cf7;
            top: 0;
            left: 0;
        }

        .circle-2 {
            width: 45px;
            height: 45px;
            border-color: #2196F3;
            top: 7.5px;
            left: 7.5px;
        }

        .circle-3 {
            width: 30px;
            height: 30px;
            border-color: #03A9F4;
            top: 15px;
            left: 15px;
        }

        /* Removed .nad-text as it seems specific to the original logo */

        .app-title {
            font-size: 36px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .app-subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
            text-align: left;
        }

        .input-container {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
        }

        /* Password toggle specific styles are not needed here, but keeping in case of future use */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
            cursor: pointer;
            user-select: none;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #4a6cf7;
        }

        .form-input {
            width: 100%;
            padding: 15px 15px 15px 50px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input.password-input {
            padding-right: 50px; /* Still useful if icons are used on right */
        }

        .form-input:focus {
            border-color: #4a6cf7;
            background: white;
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.1);
        }

        .form-input::placeholder {
            color: #999;
        }

        /* Remember-forgot specific styles are not needed here */
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 26px;
            background: #4a6cf7;
            border-radius: 13px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .toggle-switch::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            top: 3px;
            right: 3px;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .toggle-switch.off {
            background: #ccc;
        }

        .toggle-switch.off::before {
            transform: translateX(-24px);
        }

        .remember-text {
            color: #333;
            font-size: 14px;
            font-weight: 500;
        }

        .link-text { /* Modified from .forgot-password */
            color: #4a6cf7;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
            display: block; /* Make it a block element for better spacing */
            margin-top: 20px; /* Add some space from the button */
        }

        .link-text:hover {
            color: #3854d6;
        }

        .submit-btn { /* Renamed from login-btn */
            width: 100%;
            padding: 15px;
            background: #4a6cf7;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .submit-btn:hover {
            background: #3854d6;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(74, 108, 247, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .powered-by {
            color: #666;
            font-size: 14px;
        }

        .validation-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: none; /* Hidden by default, shown by JS/Laravel errors */
        }

        .success-message {
            color: #27ae60;
            font-size: 14px;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #d4edda;
            background-color: #d4edda33; /* Light success background */
            border-radius: 8px;
            display: none; /* Hidden by default, shown by JS/Laravel status */
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            
            .app-title {
                font-size: 28px;
            }
            
            .app-subtitle {
                font-size: 16px;
            }
        }
    </style>
	<!-- ====================favicon==================== --> 
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.png') }}">

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <!-- ======================================================================== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- ======================================================================== -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="login-container">
		<!-- Laravel Session Status Message -->
        @if (session('status'))
            <div class="success-message" id="serverSuccessMessage" style="display: block;">
                {{ session('status') }}
            </div>
        @endif
        <div class="logo">
            <div style="display: flex; align-items: center; justify-content: center;">
                <div class="logo-icon">
                    <!-- Ensure the asset path is correct for your Laravel setup -->
                    <img style="width: 220%; margin-left: -37px;" src="{{asset('login-template')}}/images/logo-removebg-preview.png" alt="REQTrack Logo">
                </div>
            </div>
        </div>

        <h1 class="app-title">Forgot Password</h1>
        <p class="app-subtitle">Enter your email to receive a password reset link.</p>

        <!-- Client-side/AJAX Success Message -->
        <div class="success-message" id="jsSuccessMessage">
            We have emailed your password reset link!
        </div>
        
        <!-- General Server-Side Error (if any, e.g., from validation failed on reload) -->
        @if ($errors->any())
            <div class="validation-message" style="display: block; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="forgotPasswordForm" action="{{ route('password.email') }}" method="POST">
            @csrf <!-- Laravel CSRF token for form security -->
            <div class="form-group">
                <div class="input-container">
                    <span class="input-icon"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="email" class="form-input" id="email" 
                           placeholder="Email address" value="{{ old('email') }}" required autofocus>
                </div>
                <!-- Laravel Blade error display -->
                @error('email')
                    <div class="validation-message" style="display: block;">{{ $message }}</div>
                @enderror
                <!-- Client-side error display -->
                <div class="validation-message" id="emailError">Please enter a valid email address.</div>
            </div>

            <button type="submit" class="submit-btn" id="submitButton">Send Password Reset Link</button>
        </form>

        <a href="{{ route('signin') }}" class="link-text">Back to Login</a>

        <p class="powered-by">Powered by Eight Tech Consults Ltd</p>
    </div>

    <script>
        const forgotPasswordForm = document.getElementById('forgotPasswordForm');
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const submitButton = document.getElementById('submitButton');
        const jsSuccessMessage = document.getElementById('jsSuccessMessage');
        const serverSuccessMessage = document.getElementById('serverSuccessMessage'); // For Laravel's session('status')

        // Function to validate email format
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Real-time validation on blur
        emailInput.addEventListener('blur', function() {
            if (this.value && !validateEmail(this.value)) {
                emailError.textContent = 'Please enter a valid email address.';
                emailError.style.display = 'block';
                this.style.borderColor = '#e74c3c';
            } else {
                emailError.style.display = 'none';
                this.style.borderColor = '#e0e0e0';
            }
        });

        // Form submission handler
        // forgotPasswordForm.addEventListener('submit', function(e) {
        //     e.preventDefault();

        //     // Clear previous messages and styling
        //     emailError.style.display = 'none';
        //     emailError.textContent = '';
        //     emailInput.style.borderColor = '#e0e0e0';
        //     jsSuccessMessage.style.display = 'none';
        //     if (serverSuccessMessage) { // Hide server-side message on new submission
        //         serverSuccessMessage.style.display = 'none';
        //     }

        //     const email = emailInput.value.trim();
        //     let isValid = true;

        //     // Client-side validation
        //     if (!email) {
        //         emailError.textContent = 'Email address is required.';
        //         emailError.style.display = 'block';
        //         emailInput.style.borderColor = '#e74c3c';
        //         isValid = false;
        //     } else if (!validateEmail(email)) {
        //         emailError.textContent = 'Please enter a valid email address.';
        //         emailError.style.display = 'block';
        //         emailInput.style.borderColor = '#e74c3c';
        //         isValid = false;
        //     }

        //     if (isValid) {
        //         submitButton.textContent = 'Sending...';
        //         submitButton.disabled = true;

        //         const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        //         fetch("{{ route('password.email') }}", {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': csrfToken,
        //                 'Accept': 'application/json'
        //             },
        //             body: JSON.stringify({ email: email })
        //         })
        //         .then(response => {
        //             if (response.ok) {
        //                 return response.json(); // Successful response, parse JSON
        //             } else {
        //                 // Not a 2xx status code (e.g., 422, 404, 500)
        //                 return response.json().then(errorData => {
        //                     const error = new Error(errorData.message || 'An error occurred.');
        //                     error.errors = errorData.errors || {}; // Attach specific errors if present
        //                     throw error;
        //                 });
        //             }
        //         })
        //         .then(data => {
        //             // This block runs if response.ok was true
        //             jsSuccessMessage.textContent = data.status || 'We have emailed your password reset link!';
        //             jsSuccessMessage.style.display = 'block';
        //             emailInput.value = ''; // Clear email input on success
                    
        //             submitButton.disabled = false;
        //             submitButton.textContent = 'Send Password Reset Link';
        //         })
        //         .catch(error => {
        //             console.error('Forgot password error:', error);
        //             submitButton.disabled = false;
        //             submitButton.textContent = 'Send Password Reset Link';

        //             // Display error messages
        //             if (error.errors && error.errors.email) {
        //                 emailError.textContent = error.errors.email[0];
        //                 emailError.style.display = 'block';
        //                 emailInput.style.borderColor = '#e74c3c';
        //             } else {
        //                 // Fallback for general errors or if message is not under 'errors.email'
        //                 emailError.textContent = error.message || 'Failed to send password reset link. Please try again.';
        //                 emailError.style.display = 'block';
        //                 emailInput.style.borderColor = '#e74c3c';
        //             }
        //         });
        //     }
        // });

        // Add some interactive effects for form inputs
        const formInputs = document.querySelectorAll('.form-input');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Add loading animation to submit button
        submitButton.addEventListener('mouseenter', function() {
            if (!this.disabled) {
                this.style.transform = 'translateY(-2px)';
            }
        });

        submitButton.addEventListener('mouseleave', function() {
            if (!this.disabled) {
                this.style.transform = 'translateY(0)';
            }
        });
    </script>
</body>
</html>