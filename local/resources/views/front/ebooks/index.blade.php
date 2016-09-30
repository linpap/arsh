@extends('layouts.front')
@section('css')
<link rel="stylesheet" href="{{asset('dist/css/style.css')}}">
@endsection
@section('title')
{{$ebook->title}} | The Public Post
@endsection
@section('content')
    <!-- Page Content -->
    <div class="container">

        <div class="row">
            @if($topHorizontalBanner != '')
            <img class="img-responsive center-block banner-ad2" width="728" height="90" src="{{asset('img/advs/adv_'.$topHorizontalBanner)}}" alt="banner_ad" style="margin-top:20px">
            @else
            <div class="center-block banner-ad2"  style="margin-top:20px">
                {{$topHorizontalBannerScript}}                        
            </div>
            @endif

            <div class="col-lg-12">
                <div class="col-lg-12 m-0 m-b20">
                    <a href="#" class="astyl17">সকল বই</a>
                </div>
                <div class="col-lg-8 col-lg-offset-2 m-b20 nopadding">
             
                        @if($ebook->filename != '')
                        <div>
                        <object data="{{asset('ebooks/ebook_'.$ebook->filename)}}" type="application/pdf" width="100%" height="400">
                        alt : <a href="{{asset('ebooks/ebook_'.$ebook->filename)}}">{{$ebook->title}}</a>
                        </object>
                        </div>
                        @elseif($ebook->ebook_link != '')
                            <a class="media" href="{{asset('img/ebooks/slider_'.$ebook->ebook_link)}}"></a>
                        @endif
                </div>
                <div class="titulo-ebook col-lg-6 col-md-8 col-sm-10 col-lg-offset-3 col-md-offset-2 col-sm-offset-1">
                        <a href="#" class="astyl4">
                            <h3>{{$ebook->title}}</h3>
                        </a>
                        <a href="#" class="pull-left m-r5">
                        @if($ebook->user()->first()->profile_image && $ebook->user()->first()->facebook_id == null && $ebook->user()->first()->twitter_id == null)
                        <img src="{{asset('img/users/profile/profile_'.$ebook->user()->first()->profile_image)}}" class="img-responsive" width="20px" height="20px" alt=""></a>
                        @elseif($ebook->user()->first()->facebook_id != null || $ebook->user()->first()->twitter_id != null)
                        <img src="{{$ebook->user()->first()->profile_image}}" class="img-responsive" width="20px" height="20px" alt=""></a>
                        @endif
                       {{$ebook->user()->first()->name}}<span class="glyphicon glyphicon-time m-lr5">{{$ebook->created_at}}</span><span class="icon icon-eye"> {{$ebook->views()->count()}} ভিএওস</span><br><br>
                        <a class="btn btn-primary" href="{{asset('ebooks/'.$ebook->id)}}">আরো দেখুন <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <div id="share" class="col-xs-12"></div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 h50">
                <hr class="nopadding divstyl3">
            </div>
            <div class="col-lg-12">
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

  @foreach($related_ebooks as $ebook)
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 portafolio-item">
          <a href="#" class="td-n">
              @if($ebook->filename != '')
              <div>
              <object data="{{asset('ebooks/ebook_'.$ebook->filename)}}" type="application/pdf" width="100%" height="200">
              alt : <a href="{{asset('ebooks/ebook_'.$ebook->filename)}}">{{$ebook->title}}</a>
              </object>
              </div>
              @elseif($ebook->ebook_link != '')
                  <a class="media" href="{{asset('img/ebooks/slider_'.$ebook->ebook_link)}}"></a>
              @endif
              <p class="astyl16">{{$ebook->title}}</p>
          </a>
      </div>
  @endforeach
  </div>
  <div class="row text-center">
     {!! $related_ebooks->render()!!}
  </div>
          </div>
      </div>


        </div>
        <!-- /.row -->


    </div>
    <!-- /.container -->
@endsection
@section('front-js')
<script>
$(".captcha-error").hide();
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