<!DOCTYPE html>
<html lang="en">
<head>
	<title>NAD</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	{{-- <link rel="icon" type="image/png" href="{{asset('login')}}/images/icons/favicon.ico"/> --}}
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor')}}/login/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('login')}}/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('login')}}/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor')}}/login/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{asset('vendor')}}/login/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor')}}/login/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor')}}/login/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{asset('vendor')}}/login/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('login')}}/css/util.css">
	<link rel="stylesheet" type="text/css" href="{{asset('login')}}/css/main.css">
    {{-- <link rel="stylesheet" href="{{asset('login-template')}}/css/style.css">
      <link rel="stylesheet" href="{{asset('login-template')}}/css/bootstrap.min.css"> --}}
      
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('{{asset('login-template')}}/images/disability-pictures-data.png');">
			<div class="wrap-login100">
                <div class="card-body p-4 p-lg-5 text-black">
                    @if(session('success'))
        
                        <div id="errorBox" style="text-align:center;margin-top:20px;" class="alert alert-success col-md-12 alert-dismissible fade show" role="alert">
                            <strong style="color:white;">{{ session('success') }}</strong>
                            <button type="button" style="color:white;" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true" style="color:white;" >&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                            @foreach ($errors->all() as $error)
                                    <div id="errorBox" style="text-align:center;margin-top:20px;" class="alert alert-danger col-md-12 alert-dismissible fade show" role="alert">
                                            <strong style="color:white;">{!!$error!!}</strong>
                                            <button type="button" style="color:white;" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true" style="color:white;" >&times;</span>
                                            </button>
                                    </div>

                                    <script>

                                        window.onload=function(){

                                            $("#errorBox").delay(3000).fadeOut("slow");

                                        }

                                    </script>

                            @endforeach
                    @endif
                </div>
				<form class="login100-form validate-form" action="{{ admin_url('auth/login') }}" method="POST">
                    {{ csrf_field() }}
        
					<span class="login100-form-logo">
                        <img style="width: 100%" src="{{asset('login-template')}}/images/logo-removebg-preview.png">
						{{-- <i class="zmdi zmdi-landscape"></i> --}}
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						REQTrack
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter email">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-60">
						<a class="txt1" href="{{ route('password.request') }}">
							Forgot Password?
						</a>
					</div>
					<div class="text-center p-t-30" style="font-size: x-small;
}">
						{{-- <a class="txt1" href="{{ route('password.request') }}"> --}}
							Powered by: Eight Tech Consults Limited
						{{-- </a> --}}
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="{{asset('vendor')}}/login/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor')}}/login/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor')}}/login/bootstrap/js/popper.js"></script>
	<script src="{{asset('vendor')}}/login/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor')}}/login/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor')}}/login/daterangepicker/moment.min.js"></script>
	<script src="{{asset('vendor')}}/login/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor')}}/login/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="{{asset('login')}}/js/main.js"></script>

</body>
</html>