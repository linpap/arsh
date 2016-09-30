<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="description" content="">

    <meta name="author" content="">

    <title>The Public Post | @yield('title')</title>

    <!-- Bootstrap Core CSS -->

    <link href="{{asset('dist/css/bootstrap.min.css')}}" rel="stylesheet">

  <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    @yield('css')

    <link href="{{asset('dist/icons/style.css')}}" rel="stylesheet">

    <link href="{{asset('dist/css/ninja-slider.css')}}" rel="stylesheet">

    <link href="{{asset('dist/css/likely.css')}}" rel="stylesheet">

    <link href="{{asset('dist/css/jumboShare.min.css')}}" rel="stylesheet">

    <link href="{{asset('dist/css/mystyle.css')}}" rel="stylesheet">

    <script src="{{asset('dist/js/ninja-slider.js')}}"></script>

    <link href="{{asset('dist/css/thumbnail-slider.css')}}" rel="stylesheet" type="text/css" />

    <script src="{{asset('dist/js/thumbnail-slider.js')}}" type="text/javascript"></script>

    <style>

        .caption span {

            display: block;

            color: #ccc;

        }

        #thumbnail-slider li {

            display: flex !important;

            border: 0 !important;

            align-items: center;

            justify-content: center;

        }

        #thumbnail-slider li .title {

            font-size: 12px;

            margin: 0 10px;

            color: #000;

        }

        #thumbnail-slider .thumb {

            position: relative;

            transition: all 0.5s;

            border: 3px solid transparent;

        }

        #thumbnail-slider li:hover .thumb {

            border-color: rgba(255,255,255,0.5);

        }

    </style>





</head>



<body>

@if(Auth::check())

<div class="myuser" data-email="{{Auth::user()->email}}"></div>

@endif

<div id="fb-root"></div>

<script>(function(d, s, id) {

  var js, fjs = d.getElementsByTagName(s)[0];

  if (d.getElementById(id)) return;

  js = d.createElement(s); js.id = id;

  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.7&appId=167806036983988";

  fjs.parentNode.insertBefore(js, fjs);

}(document, 'script', 'facebook-jssdk'));</script>

@include('layouts.partials.front.navbar')

@yield('content')



@include('layouts.partials.front.footer')    



<!-- jQuery -->

<!-- jQuery 2.2.3 -->

<script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->

<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>

<script src="{{asset('dist/js/platform/platform.js')}}"></script>

<script src="{{asset('dist/js/likely.js')}}"></script>



<script src="{{asset('dist/js/jumboShare.min.js')}}"></script>

<script src="{{asset('dist/js/jquery.media.js')}}"></script>

<script src="{{asset('dist/js/jquery.metadata.js')}}"></script>



<script>

 

var token = $('meta[name="csrf-token"]').attr('content');       

$('.login').click(function(){

console.log('click');

$('.profile-menu').toggleClass('mostrar'),

$('.icono-toggle').toggleClass('glyphicon-triangle-top');

});

var userid = $('.user-name').data('user');



$.ajax({

    

    url: '{{ url('/points/getUserPoints') }}'+ '/' + 1,

    type: 'GET',

    success: function(data) {

        console.log('USER POINTS -->'+data);

        $(".userpoints").text(data);

    }

});



$('.subcategories').hide();

// ** MOUSE HOVER ON PROFILE IMAGE ** //

$('.login').mouseover(function(){

    $('.profile-menu').fadeIn("fast");

});

$('.login').mouseleave(function(){

    $('.profile-menu').fadeOut("slow");

});

$('.li-items').mouseover(function(){

    $(this).find('.subcategories').fadeIn('slow');

});

$('.li-items').mouseleave(function(){

    $(this).find('.subcategories').fadeOut("slow");

});

//hide when the website is loaded subscribe and unsubcribe buttons for categories.  

$('.subscribe').hide();                

$('.unsubscribe').show();

//subscribe and unsubscribe system



    var email= $('.myuser').data('email').toString();

    var categoryid= $('.category').data('id').toString();

    if(email != '' && categoryid != ''){  

    $.ajax({

        

        url: '{{ url('/newsletters/isSubscriber') }}'+ '/' + email + '/' + categoryid,

        type: 'GET',

        success: function(data) {

                if(data['msg'] == 'success'){

                $('.subscribe').hide();

                $('.unsubscribe').show();

                }else{

                $('.unsubscribe').hide();

                $('.subscribe').show();

                }

        }

    });

    $('.subscribe').on('click',function(e){

        $.ajax({

            

            url: '{{ url('/newsletters/subscribe') }}' + '/' + email + '/' + categoryid,

            type: 'POST',

            data:{_token:token,email:email,categoryid:categoryid},

            success: function(data) {

                if(data['msg'] == 'success'){

                $('.subscribe').hide();

                $('.unsubscribe').show();

                }else{

                $('.unsubscribe').hide();

                $('.subscribe').show();

                }

            }

        });



    });

    $('.unsubscribe').on('click',function(e){        

        $.ajax({

            

            url: '{{ url('/newsletters/unsubscribe') }}' + '/' + email + '/' + categoryid,

            type: 'POST',

            data:{_token:token,email:email,categoryid:categoryid},

            success: function(data) {

                console.log('dataa ',data['msg']);

                if(data['msg'] == 'success'){

                $('.unsubscribe').hide();

                $('.subscribe').show();

                }else{

                $('.subscribe').hide();

                $('.unsubscribe').show();

                }

            }

        });

    });



    }

//end subscribe & unsubscribe system

</script>





<!-- Go to www.addthis.com/dashboard to customize your tools -->

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57d8292603024e18"></script>



<!-- Go to www.addthis.com/dashboard to customize your tools -->



<!-- Go to www.addthis.com/dashboard to customize your tools -->





@yield('front-js')

</body>



</html>

