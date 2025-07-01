<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REQTrack - Login</title>
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

        .login-container {
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

        .nad-text {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-left: 10px;
            display: inline-block;
            vertical-align: top;
            margin-top: 15px;
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

        .forgot-password {
            color: #4a6cf7;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #3854d6;
        }

        .login-btn {
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

        .login-btn:hover {
            background: #3854d6;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(74, 108, 247, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .powered-by {
            color: #666;
            font-size: 14px;
        }


		.validation-message {
            color: #e74c3c;
            font-size: 14px;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #f7e0dd;
            background-color: #f7e0dd2e; /* Light success background */
            border-radius: 8px;
            display: none; /* Hidden by default, shown by JS/Laravel status */
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
		@if (session('status'))
			<div class="success-message" id="generalMessage">
				{{ session('status') }}
			</div>
		@endif

		@if ($errors->any())
			<div class="validation-message" style="display: block; margin-bottom: -15px;">
				<ul>
					@foreach ($errors->all() as $error)
						{{ $error }}
					@endforeach
				</ul>
			</div>
		@endif
		

        <div class="logo">
            <div style="display: flex; align-items: center; justify-content: center;">
                <div class="logo-icon">
                    <img style="width: 220%; margin-left: -37px;" src="{{asset('login-template')}}/images/logo-removebg-preview.png">
						
                </div>
            </div>
        </div>

        <h1 class="app-title">REQTrack</h1>
        <p class="app-subtitle">Track Requests with Ease</p>

        <div class="success-message" id="successMessage">
            Login successful! Redirecting...
        </div>
		

        <form id="loginForm" action="{{ url('auth/login') }}" method="POST">
			{{ csrf_field() }}
            <div class="form-group">
                <div class="input-container">
                    <span class="input-icon"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="email" class="form-input" id="email" placeholder="Email address" required>
                </div>
                <div class="validation-message" id="emailError">Please enter a valid email address</div>
            </div>

            <div class="form-group">
                <div class="input-container">
                    <span class="input-icon" style="font-size: 21px;"><i class="fa fa-lock"></i></span>
                    <input type="password"  name="password" class="form-input password-input" id="password" placeholder="Password" required>
					<span  class="password-toggle" id="passwordToggle"><i class="fa fa-eye"></i></span>
                </div>
                <div class="validation-message" id="passwordError">Password must be at least 6 characters</div>
				
            </div>

            <div class="remember-forgot">
                <div class="remember-me">
                    <div class="toggle-switch" id="rememberToggle"></div>
                    <span class="remember-text">Remember me</span>
                </div>
                <a href="#" class="forgot-password" id="forgotPassword">Forgot password?</a>
            </div>

            <button type="submit" class="login-btn" id="loginButton">Login</button>
        </form>

        <p class="powered-by">Powered by Eight Tech Consults Ltd</p>
    </div>

    <script>
        // Toggle switch functionality
        const toggleSwitch = document.getElementById('rememberToggle');
        let isRememberEnabled = true;

        toggleSwitch.addEventListener('click', function() {
            isRememberEnabled = !isRememberEnabled;
            if (isRememberEnabled) {
                this.classList.remove('off');
            } else {
                this.classList.add('off');
            }
        });

        // Form validation and submission
        const loginForm = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        const successMessage = document.getElementById('successMessage');
        const loginButton = document.getElementById('loginButton');

        // Password visibility toggle
        const passwordToggle = document.getElementById('passwordToggle');
        let isPasswordVisible = false;

        passwordToggle.addEventListener('click', function() {
            isPasswordVisible = !isPasswordVisible;
            
            if (isPasswordVisible) {
				passwordInput.type = 'text';
				this.innerHTML = '<i class="fa fa-eye-slash"></i>';
				this.title = 'Hide password';
			} else {
				passwordInput.type = 'password';
				this.innerHTML = '<i class="fa fa-eye"></i>';
				this.title = 'Show password';
			}
        });

        // Email validation
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Real-time validation
        emailInput.addEventListener('blur', function() {
            if (this.value && !validateEmail(this.value)) {
                emailError.style.display = 'block';
                this.style.borderColor = '#e74c3c';
            } else {
                emailError.style.display = 'none';
                this.style.borderColor = '#e0e0e0';
            }
        });

        passwordInput.addEventListener('blur', function() {
            if (this.value && this.value.length < 6) {
                passwordError.style.display = 'block';
                this.style.borderColor = '#e74c3c';
            } else {
                passwordError.style.display = 'none';
                this.style.borderColor = '#e0e0e0';
            }
        });

        // // Form submission
		// loginForm.addEventListener('submit', function(e) {
		// 	e.preventDefault();

		// 	const email = emailInput.value.trim();
		// 	const password = passwordInput.value;
		// 	let isValid = true;

		// 	// Validate inputs
		// 	if (!email || !validateEmail(email)) {
		// 		emailError.textContent = 'Please enter a valid email address';
		// 		emailError.style.display = 'block';
		// 		emailInput.style.borderColor = '#e74c3c';
		// 		isValid = false;
		// 	} else {
		// 		emailError.style.display = 'none';
		// 		emailInput.style.borderColor = '#27ae60';
		// 	}

		// 	if (!password || password.length < 6) {
		// 		passwordError.textContent = 'Password must be at least 6 characters';
		// 		passwordError.style.display = 'block';
		// 		passwordInput.style.borderColor = '#e74c3c';
		// 		isValid = false;
		// 	} else {
		// 		passwordError.style.display = 'none';
		// 		passwordInput.style.borderColor = '#27ae60';
		// 	}

		// 	if (isValid) {
		// 		loginButton.textContent = 'Logging in...';
		// 		loginButton.disabled = true;

		// 		const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

		// 		fetch("{{ admin_url('auth/login') }}", {
		// 			method: 'POST',
		// 			headers: {
		// 				'Content-Type': 'application/json',
		// 				'X-CSRF-TOKEN': csrfToken,
		// 				'Accept': 'application/json'
		// 			},
		// 			body: JSON.stringify({
		// 				email: email,
		// 				password: password
		// 			})
		// 		})
		// 		.then(response => {
		// 			if (response.redirected) {
		// 				console.log('response: ', response)
		// 				// Login successful, redirect
		// 				setTimeout(() => {
		// 					window.location.href = response.url;
		// 				}, 1000);
		// 				// window.location.href = response.url;
		// 			}else if (response.ok) { // Check if the response status is in the 200-299 range
		// 				// This case might occur if the server sends a 200 OK with an error message
		// 				// for example, in a SPA where it doesn't redirect on failed login.
						
		// 				return response.json();
		// 			} else {
		// 				// Handle non-successful HTTP status codes (e.g., 401 Unauthorized, 422 Unprocessable Entity)
		// 				console.log('response///////: ', response);
		// 				return response.json().then(errorData => {
		// 					// Re-throw the error with the parsed data
		// 					console.log('response......: ', errorData);
		// 					throw new Error(errorData.message || 'Login failed.');
		// 				});
		// 			}
		// 		})
		// 		.then(data => {
		// 			// This block will only be executed if response.ok was true and not redirected
		// 			// or if the server explicitly sends a success message but no redirect.
		// 			// For a typical login, if it's successful, it would have redirected.
		// 			// So, this block is more for cases where the server returns JSON
		// 			// even for a successful login without immediate redirect, which is less common
		// 			// for traditional form logins.
		// 			console.log('Login successful (but no redirect triggered by fetch):', data);
		// 			// You might still want to handle a successful login here if the server
		// 			// sends a success JSON response instead of a redirect.
		// 		})

				
		// 		.catch(error => {
		// 			console.error('Login error:', error);
		// 			passwordError.textContent = 'An error occurred. Try again.'.error;
		// 			passwordError.style.display = 'block';
		// 			loginButton.disabled = false;
		// 			loginButton.textContent = 'Login';
		// 		});
		// 	}
		// });


        // Forgot password functionality
        document.getElementById('forgotPassword').addEventListener('click', function(e) {
			e.preventDefault();
            // Redirect to forgot password page or show modal
            window.location.href = '{{ route('password.request') }}';
		});

        // Add some interactive effects
        const formInputs = document.querySelectorAll('.form-input');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Add loading animation to login button
        loginButton.addEventListener('mouseenter', function() {
            if (!this.disabled) {
                this.style.transform = 'translateY(-2px)';
            }
        });

        loginButton.addEventListener('mouseleave', function() {
            if (!this.disabled) {
                this.style.transform = 'translateY(0)';
            }
        });
    </script>
</body>
</html>