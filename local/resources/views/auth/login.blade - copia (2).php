    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>The Public Post | Login</title>
        <!-- Bootstrap Core CSS -->
        <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{asset('dist/css/login.css')}}" rel="stylesheet">
        <link href="{{asset('dist/icons/style.css')}}" rel="stylesheet">
    </head>

    <body>
            <div class="col-lg-12">
                <div class="centrar" style="position:absolute; height:600px;width:500px;top:50%;left:50%;margin-left: -250px;margin-top:25px">
                    <div class="logo center-block" style="background-color:#f0f0f0;border-top:3px solid #0054a6;height:125px; width:100%">
                        <img class="center-block img-response" src="{{asset('img/Logo_footer.png')}}" alt="" style="margin-top: 30px;">
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif
                    <div class="cuerpo" style="width:100%;padding:15px;background-color:#fff">
                        <p style="color:#979696">Sign in to The Public Post through your email address or continue with
                        Twitter or Facebook.</p>
                        <form  role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <input id="email" placeholder="Type your email" type="email" class="form-control" name="email" value="{{ old('email') }}" style="width: 100%; padding: 10px; border: 1px solid rgb(217, 217, 217); margin: 5px 0px;">

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" placeholder="Type Your Password" type="password" class="form-control" name="password" style="width:100%; padding: 10px; border: 1px solid rgb(217, 217, 217); margin: 5px 0px;">
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                            </div>      
                       
                            
                            <div class="col-lg-12 enlaces" style="margin:10px 0px;padding:0">
                            <button type="submit" id="login" class="active" style="border:0px;background-color:transparent;margin-right: 20px;color:#939393;text-decoration:none">
                                 Login
                            </button>
                        </form>
                        <a href="{{ url('/password/reset') }}" id="forget" style="margin-right: 20px;color:#939393;text-decoration:none">Forget Password?</a>
                        <a href="{{ url('/register') }}" id="new" style="margin-right: 20px;color:#939393;text-decoration:none">New here?</a>
                        </div>
                            <a href="{{ url('/auth/twitter') }}" class="button twitter" style="text-decoration:none;color:white!important">
                                <span class="icon icon-twitter"></span>Continue with Twitter
                                <p style="color:#c4daf4">We won't post without asking</p>
                            </a>                        
                            <a href="{{ url('/auth/facebook') }}" class="button facebook" style="text-decoration:none;color:white!important">
                                <span class="icon icon-facebook"></span>Continue with Facebook
                                <p style="color:#c4daf4">We won't post without asking</p>
                            </a>
                            <p style="color:#b2afaf;margin-top:10px;font-weight:bold">We will never post to Twitter or Facebook without your permission.
                            For more info, please see FAQ.</p>
                         </div>
                    </div>
                </div>
            </div>
        <!-- JavaScripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
        <script>
            $('#login').click(function(){
                $(this).addClass('active')
                if ($('#login').hasClass('active'))
                    $('#forget, #new').removeClass('active')
            });
            $('#forget').click(function(){
                $(this).addClass('active')
                if ($('#forget').hasClass('active'))
                    $('#login, #new').removeClass('active')
            });
            $('#new').click(function(){
                $(this).addClass('active')
                if ($('#new').hasClass('active'))
                    $('#login, #forget').removeClass('active')
            });
        </script>
    </body>

    </html>
