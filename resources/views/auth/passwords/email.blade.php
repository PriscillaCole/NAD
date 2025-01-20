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
        .img-fluid {
            max-width: 100%;
            height: 100%;
        }

        body{
            background-image: image("http://127.0.0.1:8000/login-template/images/disability-pictures-data.png");
        }

      </style>
   </head>
   <body >
    {{-- <div class="container-fluid ">
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
    </div> --}}

    <div class="card" style="height: 100%" >
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
        <div class="row g-0" style="height: 100%">
          <div class="col-md-8 col-lg-6 d-none d-md-block">
            <img src="http://127.0.0.1:8000/login-template/images/disability-pictures-data.png"
              alt="login form" class="img-fluid" />
          </div>
          <div class="col-md-3 col-lg-6 d-flex align-items-center">
            <div class="card-body p-4 p-lg-5 text-black">

                <form action="{{ route('password.email') }}" method="POST" class="login-form">
                    {{ csrf_field() }}

                <div class="d-flex align-items-center mb-3 pb-1">
                    <img  src="{{asset('login-template')}}/images/inclusion.png">
                  <span class="h1 fw-bold mb-0">Norwegian Association for Disabled</span>
                </div>

                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Reset password</h5>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example17">Email address</label>
                    <input type="email" id="form2Example17"  name="email" class="form-control form-control-lg" />
                </div>

                <div class="pt-1 mb-4">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            
                  <button data-mdb-button-init data-mdb-ripple-init class="btn btn-round btn-lg btn-block custom-blue-btn" value="login" type="submit">Send Password Reset Link</button>
                </div>
{{-- 
                <a class="small text-muted" href="{{ route('password.request') }}">Forgot password?</a> --}}
                {{-- <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="#!"
                    style="color: #393f81;">Register here</a></p>
                <a href="#!" class="small text-muted">Terms of use.</a>
                <a href="#!" class="small text-muted">Privacy policy</a> --}}
              </form>

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
