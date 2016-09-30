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
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
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
