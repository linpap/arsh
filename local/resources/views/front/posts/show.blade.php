@extends('layouts.front')
@section('css')
<link rel="stylesheet" href="{{asset('dist/css/style.css')}}">
@endsection
@section('title')
All Posts | The Public Post
@endsection
@section('content')    <!-- Page Content -->
    <div class="container myid" data-post="{{$post->id}}">
<?php $id=$post->id; ?>
        <div class="row mytype" data-type="post">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8 col-sm-10 col-xs-12 col-lg-offset-0 col-mds-offset-0 col-sm-offset-1 col-xs-offset-0 post">
                <!-- Blog Post -->

                <!-- Banner_ad -->
                    @if($topHorizontalBanner != '')
                    <img class="img-responsive center-block banner-ad2" width="728" height="90" src="{{asset('img/advs/adv_'.$topHorizontalBanner)}}" alt="banner_ad" style="margin-top:20px">
                    @else
                    <div class="center-block banner-ad2"  style="margin-top:20px">
                        {{$topHorizontalBannerScript}}
                    </div>
                    @endif
                <!-- Title -->
                    <h1 class="titulo-blog">{{$post->title}}</h1>
                         @include('flash::message')
                    @if(isset($message))
                    <div class="col-xs-12 alert">
                        {{$message}}
                    </div>
                    @endif

                <!-- Date/Time -->
                <p class="tiempo"><span class="glyphicon glyphicon-time"></span> পোস্ট {{$post->created_at}}<br class="salto"><span class=" icon icon-eye"> {{$post->views()->count()}} </span>মতামত<br class="salto"><a href="#" class="astyl4"><span class="pull-right icon icon-printer"></span></a></p>
                <p class="tiempo">
                    <i class="fa fa-archive category" data-id="{{$post->category()->first()->id}}" aria-hidden="true"></i>  
                    বিভাগ: {{$post->category()->first()->name}}
                    @if(Auth::check())
                        @if(Auth::user()->type == 'subscriber')                            
                        <button type="button" class="btn btn-primary btn-xs subscribe">Subscribe</button>                            
                        <button type="button" class="btn btn-danger btn-xs unsubscribe">UnSubscribe</button>
                        @endif
                    @endif
                </p>
                <!-- User Profile -->
                <div class="user col-lg-2 col-md-2 col-sm-2 col-xs-12" data-userid="(if(Auth::check()) ? 'Auth::user()->id' : '')">
                @if($post->user()->first()->profile_image && $post->user()->first()->facebook_id == null && $post->user()->first()->twitter_id == null)
                    <img class="img-responsive center-block img-circle" src="{{asset('img/users/profile/profile_'.$post->user()->first()->profile_image)}}" alt="">
                @elseif($post->user()->first()->facebook_id != null || $post->user()->first()->twitter_id != null )
                 <img src="{{$post->user()->first()->profile_image}}" style="max-width:40px" alt="" class="img-circle" alt="The Post Page"> 
                @else
                <img src="{{asset('img/profile.png')}}" style="max-width:40px" alt="" class="img-circle" alt="The Post Page ">
                @endif
                    <p class="text-center user-name" data-user="{{$post->user()->first()->id}}">{{$post->user()->first()->name}}</p>
                    <p class="user-name">Points: <span class=" userpoints"></span></p>
                    <div class="redes col-lg-10 col-md-8 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-2 col-sm-offset-0 col-xs-offset-0 nopadding">
                          
                            <p><a href="http://facebook.com/{{$post->user()->first()->facebook_real}}"><span class="icon icon-facebook"></span></a>
                            <a href="http://twitter.com/{{$post->user()->first()->twitter_real}}"><span class="icon icon-twitter"></span></a>
                    </div>
                </div>
                <div class="contenido col-lg-10 col-md-10 col-sm-10 col-xs-12">
                <?php
                $text = $post->content;
                $length = strlen($text);
                $half = ($length / 2);
                $newtext = substr($text, 0, -$half);
                $text2 =substr($text,$half);
                echo "$newtext <br>";

                ?>
                <div class="col-md-3 col-sm-3 col-xs-3 divstyl1 astyl8">
               
                <span class="icon icon-quote-left astyl7"></span>
                {!!$post->featured_text!!}
                </div>  
                {!!$text2!!}
                <div class="clearfix"></div>
                @foreach($post->tags()->get() as $tag)

                <span class="icon icon-price-tag pull-left">{!!$tag->name!!}</span> 
                @endforeach
                <br>
                <!-- Social media plugin -->

                <div class="center-block addthis_inline_share_toolbox_wzi8" addthis:url="{{url()->current()}}"></div>
                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                <div class="addthis_inline_share_toolbox_bi9p" addthis:url="{{url()->current()}}" data-url="{{url()->current()}}"></div>
                <div class="ad-post">
                @if($bottomHorizontal != '')
                    <img src="{{asset('img/advs/adv_'.$bottomHorizontal)}}" alt="The Public Post News">
                @else
                    {{$bottomHorizontalScript}}
                @endif
                </div>
                <div class="col-xs-12" style="border:1px solid #eee;margin:20px 0px;"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 nopadding m-b40">
                    <div class="col-md-6 col-sm-6 col-xs-6 nopadding">
                    <strong>YOU MAY LIKE</strong>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 nopadding">
                    <p class="pull-right">Sponsored Link By</p>
                    </div>
                    @foreach($related_posts as $post)
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <a href="{{url('posts/'.$post->id)}}" class="td-n">
                        <img class="img-responsive" src="{{asset('img/posts/slider_'.$post->images()->first()->name)}}" alt="">

                        <h4><strong>{{$post->title}}</strong></h4>
                        <h6 class="c-999999"><strong>{{ strip_tags(str_limit($post->content, 200))}}</strong></h6></a>
                    </div>
                    @endforeach
                </div>
                <div class="col-xs-12" style="border:1px solid #eee;margin:20px 0px;"></div>
                <h2>ফেসবুক মন্তব্য</h2>
                <div class="fb-comments" data-href="{{url()->current()}}" data-numposts="5"></div>
                <div class="col-xs-12" style="border:1px solid #eee;margin:20px 0px;"></div>

                <h2>মন্তব্য</h2>
                <!-- Blog Comments -->
                @if($comments->count()>0)
                <ul class="comments">
                @foreach($comments as $key => $comment)
                    <li>
                    @if($comment->user_id == null)
                    <img src="{{asset('img/profile.png')}}" style="max-width:40px" alt="" class="img-circle" alt="The Post Page ">  
                        <span>{{$comment->name}}</span>
                        <p class="comment">মন্তব্য প্রদান করেছে {{$comment->created_at}}</p>
                        <p>{{$comment->comment}}</p>        
                    @else
                        @if($comment->user()->first()->profile_image && $comment->user()->first()->facebook_id == null && $comment->user()->first()->twitter_id == null)
                            <img style="max-width:40px" alt="" class="img-circle" src="{{asset('img/users/profile/profile_'.$comment->user()->first()->profile_image)}}" alt="The Public Post">
                            <span>{{$comment->user()->first()->name}}</span>
                        @elseif($comment->user()->first()->facebook_id != null || $comment->user()->first()->twitter_id != null)
                            <img style="max-width:40px" alt="" class="img-circle" src="{{$comment->user()->first()->profile_image}}" alt="The Public Post">
                            <span>{{$comment->user()->first()->name}}</span>


                        @else
                            <img src="{{asset('img/profile.png')}}" style="max-width:40px" alt="" class="img-circle" alt="The Post Page ">
                            <span>{{$comment->user()->first()->name}}</span>


                        @endif  
                            <p class="comment">মন্তব্য প্রদান করেছে {{$comment->created_at}}</p>
                            <p>{{$comment->comment}}</p>
                    @endif
                    </li>
                    <div class="col-xs-12" style="border:1px solid #eee;margin:20px 0px;"></div>
                @endforeach
                </ul>
                @endif
                <!-- Comments Form -->
              
                <div class="well comentarios nopadding" >
                @if(Auth::check())
                    <h4>মতামত দিন:</h4>
                     
                    <div class="col-lg-21 col-md-2 col-sm-2 col-xs-2 nopadding">
                    <a class="pull-left" href="#">
                   
                        @if(Auth::user()->profile_image && Auth::user()->first()->facebook_id == null && Auth::user()->first()->twitter_id == null)
                            <img style="max-width:80px" alt="fafa" class="img-circle" src="{{asset('img/users/profile/profile_'.Auth::user()->profile_image)}}" alt="The Public Post">
                        @elseif(Auth::user()->first()->facebook_id != null || Auth::user()->first()->twitter_id != null)
                            <img style="max-width:100px" alt="" class="img-circle" src="{{Auth::user()->profile_image}}" alt="The Public Post">
                        @else
                            <img src="{{asset('img/profile.png')}}" style="max-width:40px" alt="" class="img-circle" alt="The Post Page ">
                        @endif

                    </a>
                    </div>
                    <form role="form" action="{{url('comment/posts/'.$id.'/'.Auth::user()->id)}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group col-lg-10 col-md-10 col-sm-9 col-xs-9 nopadding">
                            <textarea class="form-control ta-styl" name="comment" rows="3"></textarea>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding m-0">
                            <button type="submit" class="btn btn-primary">পাঠান</button>
                        </div>
                    </form>
                @else                    
                    মন্তব্য করতে আপনাকে অবশ্যই লগইন করতে হবে.
                @endif
            
                <div class="col-xs-12" style="border:1px solid #eee;margin:20px 0px;"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 nopadding m-t20 m-0">
                @foreach($related_photos as $photo)
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <a href="{{url('/photos/'.$photo->id)}}" class="td-n">

                    <img class="img-responsive" src="{{asset('img/photos/slider_'.$photo->images()->first()->name)}}" alt="">

                    <h4><strong>{{$photo->title}}</strong></h4>
                    <h6 class="c-999999"><strong>{{ strip_tags(str_limit($photo->content, 300))}}</strong></h6></a>
                </div>
                @endforeach
                </div>
                        <div class="col-xs-12" style="border:1px solid #eee;margin:20px 0px;"></div>
                       
                        <form role="form" action="{{url('/comment/posts/'.$id)}}" method="POST">

                        <div class="mensaje m-t10">
                            
                            <textarea class="ta-styl2 form-control" name="comment"></textarea>
                        </div>
                            {{ csrf_field() }}
                            <div class="form col-md-5 nopadding m-t20">
                                <p>Name*<br>
                                <input type="text" name="name" class="form-control w100porcent" required>
                                </p>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="form col-md-5 nopadding m-t20">
                                <p>Web<br>
                                <input type="text" name="web" class="form-control w100porcent">
                                </p>
                            </div>
                            <div class="form col-md-5 nopadding m-t20">
                                <p>Email*<br>
                                <input type="email" name="email" class="form-control w100porcent" required>
                                </p>
                            </div>
                            <div class="form col-md-12 m-t20 nopadding">
                                <p>CAPTCHA Code* - Resolve this easy math account<br>
                                <?php 
                                $result=0;
                                $num1=rand(0,10);
                                $num2=rand(0,10);
                                $sum=$num1+$num2;
                                $result=$sum;
                                ?>
                                <label for="nums" class="nums" data-result="<?php echo $result; ?>"><?php echo $num1; ?> + <?php echo $num2; ?></label>
                                <input type="text" class="result form-control w15porcent" placeholder="এখানে ফল রাখুন" name="result" required>
                                </p>
                                <div id="resolve" class="btn btn-primary">সমাধান</div>
                                <p class="alert-danger captcha-error">ত্রুটি আবার চেষ্টা করুন.</p>
                                <p class="alert-success captcha-correct">নির্ভুল!</p>
                            </div>
                            <div class="form col-md-12 m-t20 nopadding">
                            <button type="submit" id="submit" class="btn btn-primary m-b20">পাঠান</button>
                            </div>
                            </form>
                </div>

                <hr>

            </div>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <!-- Blog Sidebar Widgets Column -->
            @include('layouts.partials.front.rightsidebar')

        </div>
        <!-- /.row -->

    </div>
@endsection
@section('front-js')

<script>
var uri = '{{url()->current()}}';
var userid=$('.user').data('userid');

//point system
var googleshares=0;
var facebookshares=0;
var likes=0; //this is for Facebook likes and Pinterest pins.
var facebookcomments=0;
var totalshares=0;
var sum=0;
var shares=0;
var dataId = $('.myid').data('post');
var type = $('.mytype').data('type');

//get google plus shares.
$.ajax({
  type: 'POST',
  url: 'https://clients6.google.com/rpc',
  processData: true,
  contentType: 'application/json',
  data: JSON.stringify({
    'method': 'pos.plusones.get',
    'id': uri,
    'params': {
      'nolog': true,
      'id': uri,
      'source': 'widget',
      'userId': '@viewer',
      'groupId': '@self'
    },
    'jsonrpc': '2.0',
    'key': 'p',
    'apiVersion': 'v1'
  }),
  success: function(response) {
    console.log('GOOGLE PLUS SHARES -> '+response.result.metadata.globalCounts.count);
    googleshares=response.result.metadata.globalCounts.count;
  }
});

//get facebook shares and comments
$.getJSON("http://graph.facebook.com/"+uri, function(data){
    facebookshares=data['share']['share_count'];

    console.log('Facebook Shares-->'+data['share']['share_count']);
    console.log('Facebook Comments-->'+data['share']['comment_count']);


    //add facebook comment point
    $.ajax({
        
        url: '{{ url('/points/addComment') }}' + '/'+'posts'+ '/' + dataId + '/' +data['share']['comment_count'], 
        type: 'POST',
        data:{_token:token,id:dataId},
        success: function(msg) {
            console.log(msg['msg']);
        }
    }); 
    
});
function getShares(){
    shares = facebookshares + googleshares;
        //shares watcher
    $.ajax({
        
        url: '{{ url('/points/addShare') }}' + '/'+'posts'+ '/' + dataId + '/' + shares,
        type: 'POST',
        data:{_token:token,id:dataId},
        success: function(msg) {
            console.log(msg['msg']);
        }
    });
    console.log('TOtal sharesss '+shares);
}
setTimeout(getShares,4000);
//total shares






//Function from Addthis plugin to get shares from Facebook and Pinterest.
addthis.sharecounters.getShareCounts(['facebook','pinterest'], function(obj) {
 
    //sum all counts from likes
    for(var key in obj) {
        if(obj[key]['count'] != '?'){
            sum= sum+obj[key]['count'];            
        }
    }
    //get the shares with jquery
    
    //
    likes = sum; //sum of Facebook Likes and Pintereset Pins.
    console.log('Facebook & Pinteresets Likes --> '+likes);

    //like watcher: check new likes or unlikes from Facebook or Pinterest and save on db to add points.
    $.ajax({
        
        url: '{{ url('/points/addLike') }}' + '/'+'posts'+ '/' + dataId + '/' + likes,
        type: 'POST',
        data:{_token:token,id:dataId},
        success: function(msg) {
            console.log(msg['msg']);
        }
    });  
});
//end point system




//Views System. Check ip and add view or not if the same ip.

$.ajax({
    
    url: '{{ url('/posts/addView') }}' + '/' + dataId,
    type: 'POST',
    data:{_token:token,id:dataId},
    success: function(msg) {
        
    }
});
//end Views System

//captcha
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
//endcaptcha
</script>
@endsection