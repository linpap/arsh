@extends('layouts.front')
@section('css')
<link rel="stylesheet" href="{{asset('dist/css/style.css')}}">
@endsection
@section('title')
All videos | The Public Post
@endsection
@section('content')
    <!-- Page Content -->
    <div class="container">
        <div class="row myid" data-video="{{$video->id}}">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 col-lg-offset-0 col-mds-offset-0 col-xs-offset-0 post">
                <!-- Blog Post -->

                <!-- Banner_ad -->
                @if($topHorizontalBanner != '' )
                <img class="img-responsive center-block banner-ad2 m-t20" width="728" height="90" src="{{asset('img/advs/adv_'.$topHorizontalBanner)}}"  style="margin-top:20px;" alt="banner_ad">
                @else
                <div class="banner-ad2 m-t20"  style="margin-top:20px;">                    
                    {{$topHorizontalBannerScript}}
                </div>
                @endif

                <div class="col-lg-12 nopadding m-b30">
                    <a href="#" class="astyl13">
                        <h3>ভিডিও পাতা</h3>
                    </a>

                </div>
                    <div class="col-lg-9 col-md-12 embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item"  src="https://www.youtube.com/embed/{{$video->video_link}}"></iframe>
                    </div>
                    <div class="ad-up col-lg-3 col-md-3">
                        @if($rightSingle != '')
                            <img class="center-block img-responsive m-tb50" src="{{asset('img/advs/adv_'.$rightSingle)}}">
                        @else
                            <div class="center-block m-tb50">
                                {{$rightSingleScript}}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 nopadding m-b20">
                        <a href="#" class="astyl4">
                            <h3>{{$video->title}}</h3>
                        </a>
                        <a href="#" class="pull-left m-r5">
                        @if($video->user()->first()->profile_image && $video->user()->first()->facebook_id == null && $video->user()->first()->twitter_id == null)
                        <img src="{{asset('img/users/profile/profile_'.$video->user()->first()->profile_image)}}" class="img-responsive" width="20px" height="20px" alt=""></a>
                        @elseif($video->user()->first()->facebook_id != null || $video->user()->first()->twitter_id != null)
                        <img src="{{$video->user()->first()->profile_image}}" class="img-responsive" width="20px" height="20px" alt=""></a>
                        @endif
                       	 {{$video->user()->first()->name}} 
                        <span class="glyphicon glyphicon-time m-lr10">{{$video->created_at}}</span><span class="icon icon-eye"> {{$video->views()->count()}} ভিএওস</span><br><br>
                        <a class="btn btn-primary" href="{{url('videos/'.$video->id)}}">আরো দেখুন<span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                    <div class="ad-bottom col-lg-12">
                        <img class="center-block img-responsive" src="https://placeholdit.imgix.net/~text?txtsize=19&txt=150%C3%97300&w=150&h=300" alt="">
                    </div>
                    <div class="col-lg-12 nopadding h60">
                        <hr class="divstyl3 nopadding">
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3 hidden-xs categorias nopadding">
                    <ul class="list-group">
                    @foreach($sidebars as $sidebar)
                        <li class="list-group-item"><a href="#" class="astyl4 fw-b">- {{$sidebar->category()->first()->name}}</a></li>
                    @endforeach
                    </ul>
                </div>
                <div class="col-xs-12 visible-xs categories nopadding m-b20">
                    <button class="btn btn-primary dropdown-toggle w100porcent bc-0061d8" type="button" id="dropdownenu1" data-toggle="dropdown" aria-extended="true">
                        Categories
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu divstyl4" role="menu" aria-labellebdy="dropdownmenu1">
                    @foreach($sidebars as $sidebar)
                        <li class="list-group-item"><a href="#" class="astyl4 fw-b">- {{$sidebar->category()->first()->name}}</a></li>
                    @endforeach
                    </ul>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 portafolio-content">
                    <!-- Projects Row -->
        <div class="row portafolios">
        @foreach($related_videos as $video)
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 portafolio-item">

                <a href="{{url('videos/'.$video->id)}}" class="td-n"><iframe width="150" height="117" src="https://www.youtube.com/embed/{{$video->video_link}}" frameborder="0" allowfullscreen></iframe>
                    <p class="astyl16">{{$video->title}}</p>
                </a>
            </div>
        @endforeach
        </div>
            <div class="row text-center">
            <div class="col-lg-12">
            {{$related_videos->render()}}
            </div>
        </div>
                </div>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            @include('layouts.partials.front.rightsidebar')
        </div>
        <!-- /.row -->
    <!-- /.container -->
@endsection
@section('front-js')
<script>
$(".captcha-error").hide();
$(".captcha-correct").hide();
$('#submit').prop('disabled', true);
    $("#resolve").click(function(e){
    e.preventDefault();     
        var resultInput = $('.result').val();
        var resultOriginal = $('.nums').data('result');
        //check if the result is okey
        if(resultInput == resultOriginal){
            $('#submit').prop('disabled', false);
            $(".captcha-correct").show();
            $(".captcha-error").hide();
            $('#submit').unbind('click');
        }else{
            $('#submit').prop('disabled', true);
            $(".captcha-error").show();
            $(".captcha-correct").hide();
        }
    });

</script>
@endsection