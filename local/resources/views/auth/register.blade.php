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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

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
                <div class="cuerpo" style="width:100%;padding:15px;background-color:#fff">
                    <p style="color:#979696">Sign in to The Public Post through your email address or continue with
                    Twitter or Facebook.</p>
                    <form  role="form" method="POST" action="{{ url('/register') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <i class="fa fa-pencil"></i>
                        <label for="name">Your Name</label>
                        <input id="name" type="text" class="form-control" placeholder="Type your name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('bkash') ? ' has-error' : '' }}">
                        <i class="fa fa-money"></i>
                        <label for="bkash">Your Bkash Id</label>
                        <input id="bkash" type="text" class="form-control" placeholder="Type your bkash" name="bkash" value="{{ old('bkash') }}">
                            @if ($errors->has('bkash'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bkash') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('tagline') ? ' has-error' : '' }}">
                        <i class="fa fa-tag"></i>
                        <label for="tagline">Your Tagline</label>
                        <input id="tagline" type="text" class="form-control" placeholder="Type your tagline" name="tagline" value="{{ old('tagline') }}" required>
                            @if ($errors->has('tagline'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tagline') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('tagline') ? ' has-error' : '' }}">

                        <label for="facebook_real"> <i class="fa fa-facebook-square"></i> Your Facebook ID</label>
                        <input id="facebook_real" type="text" class="form-control" placeholder="Type your Facebook ID" name="facebook_real" value="{{ old('facebook_real') }}">
                            @if ($errors->has('facebook_real'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('facebook_real') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('twitter_real') ? ' has-error' : '' }}">

                        <label for="twitter_real"><i class="fa fa-twitter-square"></i> Your Twitter ID</label>
                        <input id="twitter_real" type="text" class="form-control" placeholder="Type your Twitter ID" name="twitter_real" value="{{ old('twitter_real') }}">
                            @if ($errors->has('twitter_real'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('twitter_real') }}</strong>
                                </span>
                            @endif
                        </div>
                       <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <i class="fa fa-envelope"></i>
                        <label for="email">Your E-mail</label>
                        <input id="email" type="email" class="form-control" placeholder="Type your email" name="email" value="{{ old('email') }}" style="width: 100%; padding: 10px; border: 1px solid rgb(217, 217, 217); margin: 5px 0px;">
                        
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group{{ $errors->has('images') ? ' has-error' : '' }}">
                    
                            <div class="form-group">
                                <i class="fa fa-photo"></i>  {!! Form::label('profile_image','Profile Image') !!}
                                {!! Form::file('profile_image',null,['class'=> 'form-control','required']) !!}

                            </div>  

                            @if ($errors->has('profile_image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('profile_image') }}</strong>
                                </span>
                            @endif
                        </div>
                       <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                       <i class="fa fa-lock"></i>
                        <label for="password">Your Password</label>
                            <input id="password" type="password" placeholder="Type your password" class="form-control" name="password" style="width:100%; padding: 10px; border: 1px solid rgb(217, 217, 217); margin: 5px 0px;">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                        </div>


                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <i class="fa fa-lock"></i>
                         <label for="passwrod-confimr">Your Password Again</label>

                            <input id="password-confirm" placeholder="Type Again your password" type="password" class="form-control" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>     
                   
                        
                        <div class="col-lg-12 enlaces" style="margin:10px 0px;padding:0">
                        <button type="submit" id="login" class="active" style="border:0px;background-color:transparent;margin-right: 20px;color:#939393;text-decoration:none">
                             Register
                        </button>
                    </form>
                    <a href="{{ url('/login') }}" id="new" style="margin-right: 20px;color:#939393;text-decoration:none">You have account? Login please.</a>
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