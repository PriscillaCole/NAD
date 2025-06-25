<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REQTrack - Reset Password</title>
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

        .login-container { /* Consistent class name for styling */
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
            padding-right: 50px;
        }

        .form-input:focus {
            border-color: #4a6cf7;
            background: white;
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.1);
        }

        .form-input::placeholder {
            color: #999;
        }

        .link-text {
            color: #4a6cf7;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
            display: block;
            margin-top: 20px;
        }

        .link-text:hover {
            color: #3854d6;
        }

        .submit-btn {
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
            display: none;
        }

        .success-message {
            color: #27ae60;
            font-size: 14px;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #d4edda;
            background-color: #d4edda33;
            border-radius: 8px;
            display: none;
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
        <div class="logo">
            <div style="display: flex; align-items: center; justify-content: center;">
                <div class="logo-icon">
                    <!-- Ensure the asset path is correct for your Laravel setup -->
                    <img style="width: 220%; margin-left: -37px;" src="{{asset('login-template')}}/images/logo-removebg-preview.png" alt="REQTrack Logo">
                </div>
            </div>
        </div>

        <h1 class="app-title">Reset Password</h1>
        <p class="app-subtitle">Enter your new password below.</p>

        <!-- Laravel Session Status Message (for success or general messages after redirect) -->
        @if (session('status'))
            <div class="success-message" id="serverStatusMessage" style="display: block;">
                {{ session('status') }}
            </div>
        @endif

        <!-- Client-side/AJAX Success Message -->
        <div class="success-message" id="jsSuccessMessage">
            Your password has been reset! Redirecting to login...
        </div>
        
        <!-- General Server-Side Error (if any, e.g., from validation failed on reload) -->
        @if ($errors->any())
            <div class="validation-message" style="display: block; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="resetPasswordForm" action="{{ route('password.update') }}" method="POST">
            @csrf <!-- Laravel CSRF token for form security -->
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <div class="input-container">
                    <span class="input-icon"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="email" class="form-input" id="email" 
                           placeholder="Email address" value="{{ $email ?? old('email') }}" required readonly>
                </div>
                <!-- Laravel Blade error display -->
                @error('email')
                    <div class="validation-message" style="display: block;">{{ $message }}</div>
                @enderror
                <!-- Client-side error display -->
                <div class="validation-message" id="emailError">Please enter a valid email address.</div>
            </div>

            <div class="form-group">
                <div class="input-container">
                    <span class="input-icon" style="font-size: 21px;"><i class="fa fa-lock"></i></span>
                    <input type="password" name="password" class="form-input password-input" id="password" 
                           placeholder="New Password" required>
                    <span class="password-toggle" id="passwordToggle"><i class="fa fa-eye"></i></span>
                </div>
                @error('password')
                    <div class="validation-message" style="display: block;">{{ $message }}</div>
                @enderror
                <div class="validation-message" id="passwordError">Password must be at least 8 characters.</div>
            </div>

            <div class="form-group">
                <div class="input-container">
                    <span class="input-icon" style="font-size: 21px;"><i class="fa fa-lock"></i></span>
                    <input type="password" name="password_confirmation" class="form-input password-input" id="password_confirmation" 
                           placeholder="Confirm New Password" required>
                    <span class="password-toggle" id="confirmPasswordToggle"><i class="fa fa-eye"></i></span>
                </div>
                <div class="validation-message" id="passwordConfirmationError">Passwords do not match.</div>
            </div>

            <button type="submit" class="submit-btn" id="submitButton">Reset Password</button>
        </form>

        <a href="{{ route('signin') }}" class="link-text">Back to Login</a>

        <p class="powered-by">Powered by Eight Tech Consults Ltd</p>
    </div>

    <script>
        const resetPasswordForm = document.getElementById('resetPasswordForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        const passwordConfirmationError = document.getElementById('passwordConfirmationError');
        const submitButton = document.getElementById('submitButton');
        const jsSuccessMessage = document.getElementById('jsSuccessMessage');
        const serverStatusMessage = document.getElementById('serverStatusMessage');

        // Password visibility toggles
        const passwordToggle = document.getElementById('passwordToggle');
        const confirmPasswordToggle = document.getElementById('confirmPasswordToggle');

        function setupPasswordToggle(inputElement, toggleElement) {
            let isPasswordVisible = false;
            toggleElement.addEventListener('click', function() {
                isPasswordVisible = !isPasswordVisible;
                if (isPasswordVisible) {
                    inputElement.type = 'text';
                    this.innerHTML = '<i class="fa fa-eye-slash"></i>';
                    this.title = 'Hide password';
                } else {
                    inputElement.type = 'password';
                    this.innerHTML = '<i class="fa fa-eye"></i>';
                    this.title = 'Show password';
                }
            });
        }

        setupPasswordToggle(passwordInput, passwordToggle);
        setupPasswordToggle(passwordConfirmationInput, confirmPasswordToggle);

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

        passwordInput.addEventListener('blur', function() {
            if (this.value.length > 0 && this.value.length < 8) {
                passwordError.textContent = 'Password must be at least 8 characters.';
                passwordError.style.display = 'block';
                this.style.borderColor = '#e74c3c';
            } else {
                passwordError.style.display = 'none';
                this.style.borderColor = '#e0e0e0';
            }
            // Also re-check password confirmation if main password changes
            if (passwordConfirmationInput.value.length > 0 && this.value !== passwordConfirmationInput.value) {
                passwordConfirmationError.textContent = 'Passwords do not match.';
                passwordConfirmationError.style.display = 'block';
                passwordConfirmationInput.style.borderColor = '#e74c3c';
            } else {
                passwordConfirmationError.style.display = 'none';
                passwordConfirmationInput.style.borderColor = '#e0e0e0';
            }
        });

        passwordConfirmationInput.addEventListener('blur', function() {
            if (this.value.length > 0 && this.value !== passwordInput.value) {
                passwordConfirmationError.textContent = 'Passwords do not match.';
                passwordConfirmationError.style.display = 'block';
                this.style.borderColor = '#e74c3c';
            } else {
                passwordConfirmationError.style.display = 'none';
                this.style.borderColor = '#e0e0e0';
            }
        });

        // Form submission handler
        // resetPasswordForm.addEventListener('submit', function(e) {
        //     e.preventDefault();

        //     // Clear previous messages and styling
        //     emailError.style.display = 'none';
        //     passwordError.style.display = 'none';
        //     passwordConfirmationError.style.display = 'none';
        //     emailError.textContent = '';
        //     passwordError.textContent = '';
        //     passwordConfirmationError.textContent = '';
        //     emailInput.style.borderColor = '#e0e0e0';
        //     passwordInput.style.borderColor = '#e0e0e0';
        //     passwordConfirmationInput.style.borderColor = '#e0e0e0';
        //     jsSuccessMessage.style.display = 'none';
        //     if (serverStatusMessage) {
        //         serverStatusMessage.style.display = 'none';
        //     }

        //     const email = emailInput.value.trim();
        //     const password = passwordInput.value;
        //     const passwordConfirmation = passwordConfirmationInput.value;
        //     const token = this.querySelector('input[name="token"]').value; // Get the token from hidden input
        //     let isValid = true;

        //     // Client-side validation
        //     if (!email || !validateEmail(email)) {
        //         emailError.textContent = 'Please enter a valid email address.';
        //         emailError.style.display = 'block';
        //         emailInput.style.borderColor = '#e74c3c';
        //         isValid = false;
        //     }

        //     if (!password || password.length < 8) {
        //         passwordError.textContent = 'Password must be at least 8 characters.';
        //         passwordError.style.display = 'block';
        //         passwordInput.style.borderColor = '#e74c3c';
        //         isValid = false;
        //     }

        //     if (!passwordConfirmation || password !== passwordConfirmation) {
        //         passwordConfirmationError.textContent = 'Passwords do not match.';
        //         passwordConfirmationError.style.display = 'block';
        //         passwordConfirmationInput.style.borderColor = '#e74c3c';
        //         isValid = false;
        //     }

        //     if (isValid) {
        //         submitButton.textContent = 'Resetting...';
        //         submitButton.disabled = true;

        //         const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        //         fetch("{{ route('password.update') }}", {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': csrfToken,
        //                 'Accept': 'application/json'
        //             },
        //             body: JSON.stringify({
        //                 email: email,
        //                 password: password,
        //                 password_confirmation: passwordConfirmation,
        //                 token: token // Include the token in the request body
        //             })
        //         })
        //         .then(response => {
        //             if (response.ok) {
        //                 return response.json();
        //             } else {
        //                 return response.json().then(errorData => {
        //                     const error = new Error(errorData.message || 'An error occurred.');
        //                     error.errors = errorData.errors || {};
        //                     throw error;
        //                 });
        //             }
        //         })
        //         .then(data => {
        //             jsSuccessMessage.textContent = data.status || 'Your password has been reset successfully!';
        //             jsSuccessMessage.style.display = 'block';
        //             // Clear form fields on success
        //             emailInput.value = '';
        //             passwordInput.value = '';
        //             passwordConfirmationInput.value = '';
                    
        //             submitButton.disabled = false;
        //             submitButton.textContent = 'Reset Password';

        //             // Redirect to login page after a delay
        //             setTimeout(() => {
        //                 window.location.href = "{{ route('login') }}";
        //             }, 2000); // 2 second delay before redirect
        //         })
        //         .catch(error => {
        //             console.error('Reset password error:', error);
        //             submitButton.disabled = false;
        //             submitButton.textContent = 'Reset Password';

        //             // Display errors from backend
        //             if (error.errors) {
        //                 if (error.errors.email) {
        //                     emailError.textContent = error.errors.email[0];
        //                     emailError.style.display = 'block';
        //                     emailInput.style.borderColor = '#e74c3c';
        //                 }
        //                 if (error.errors.password) {
        //                     passwordError.textContent = error.errors.password[0];
        //                     passwordError.style.display = 'block';
        //                     passwordInput.style.borderColor = '#e74c3c';
        //                 }
        //                 // Handle password_confirmation specific error if Laravel sends it separately
        //                 if (error.errors.password_confirmation) {
        //                     passwordConfirmationError.textContent = error.errors.password_confirmation[0];
        //                     passwordConfirmationError.style.display = 'block';
        //                     passwordConfirmationInput.style.borderColor = '#e74c3c';
        //                 }
        //                 // General error message if no specific field error is caught
        //                 if (!error.errors.email && !error.errors.password && !error.errors.password_confirmation && error.message) {
        //                      passwordError.textContent = error.message; // Use passwordError for general error
        //                      passwordError.style.display = 'block';
        //                      emailInput.style.borderColor = '#e74c3c'; // Highlight all fields for general error
        //                      passwordInput.style.borderColor = '#e74c3c';
        //                      passwordConfirmationInput.style.borderColor = '#e74c3c';
        //                 }
        //             } else {
        //                 // Fallback for general errors not structured with 'errors' key
        //                 passwordError.textContent = error.message || 'An unexpected error occurred. Please try again.';
        //                 passwordError.style.display = 'block';
        //                 emailInput.style.borderColor = '#e74c3c';
        //                 passwordInput.style.borderColor = '#e74c3c';
        //                 passwordConfirmationInput.style.borderColor = '#e74c3c';
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