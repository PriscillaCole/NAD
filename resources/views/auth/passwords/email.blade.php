


<!doctype html>
<html lang="en">
   <head>
   <title>ReQTrack</title>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link rel="stylesheet" href="{{asset('login-template')}}/css/style.css">
      <link rel="stylesheet" href="{{asset('login-template')}}/css/bootstrap.min.css">
      <style>
        .custom-blue-btn {
            background-color:#87CEEB; /* Light blue */
            color: white;
            border: none;
        }

        .custom-blue-btn:hover {
            background-color:  #B0E0E6; /* Sky blue for hover effect */
        }

      </style>
   </head>
   <body>
   <div class="container-fluid ">
        <div class="container ">
            <div class="row ">
            @if(session('status'))
        
                <div id="errorBox" style="text-align:center;margin-top:20px;" class="alert alert-success col-md-12 alert-dismissible fade show" role="alert">
                    <strong style="color:white;">{{ session('status') }}</strong>
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
                <div class="col-sm-10 login-box">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 log-det">
                            <div class="d-flex align-items-center justify-content-center">
                               <img src="{{asset('login-template')}}/images/logo.webp" >
                            </div>
                            <h2 class="mb-3" style="font-family: 'PT Sans', sans-serif;">ReQTrack</h2>
                            <div class="text-box-cont mt-3">
                            <form action="{{ route('password.email') }}" method="POST" >
                              {{ csrf_field() }}
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="{{ trans('email') }}" name="email" value="{{ old('email') }}">
                                </div>
                                
                                
                                <div class="input-group center mb-3">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn  custom-blue-btn btn-round"> {{ __('Send Password Reset Link') }}</button>
                                </div>

                                @if (Route::has('login'))
                                <div class="input-group center mb-3">
                                    <a class="btn btn-link"  href="/">
                                        {{ __('Login') }}
                                    </a>
                                </div>
                                @endif
                                
                            </form>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 box-de">
                            <div class="ditk-inf">
                            <img src="{{asset('login-template')}}/images/inclusion.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <script src="{{asset('login-template')}}/js/jquery.min.js"></script>
      <script src="{{asset('login-template')}}/js/popper.js"></script>
      <script src="{{asset('login-template')}}/js/bootstrap.min.js"></script>
      <script src="{{asset('login-template')}}/js/main.js"></script>
   </body>
   </html>
