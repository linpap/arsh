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

<div class="well comentarios nopadding">
    <h4>মতামত দিন:</h4>
    
    <div class="col-lg-21 col-md-2 col-sm-2 col-xs-2 nopadding">
    <a class="pull-left" href="#">    
        <img style="max-width: 77px;margin-top: 6px;" alt="" class="img-circle" src="http://pbs.twimg.com/profile_images/616283163606839296/IcCifzNP.jpg">
          
        </a>
        
        </div>
        <form role="form" action="http://localhost/thepublicpost/comment/photos/1/1" method="POST">
            <input type="hidden" name="_token" value="v3DVOLJK5UgZ9ZcYYEptyKX99IVV6YCsGVrWHFdu">
            <div class="form-group col-lg-10 col-md-10 col-sm-9 col-xs-9 nopadding">
                <textarea class="form-control ta-styl" name="comment" rows="3"></textarea>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding m-0">
                <button type="submit" class="btn btn-primary pull-right">পাঠান</button>
            </div>
        </form>
                <div class="col-md-12 col-sm-12 col-xs-12 nopadding m-t20 m-0">
</div>
<div class="col-xs-12" style="border:1px solid #eee;margin:20px 0px;"></div>
       
        <form role="form" action="http://localhost/thepublicpost/comment/photos/1" method="POST">

        <div class="mensaje m-t10">
            <h2>যোগাযোগ</h2>
            <textarea class="ta-styl2 form-control" name="comment"></textarea>
        </div>
            <input type="hidden" name="_token" value="v3DVOLJK5UgZ9ZcYYEptyKX99IVV6YCsGVrWHFdu">
            <div class="form col-md-5 nopadding m-t20">
                <p>Name*<br>
                <input type="text" name="name" class="form-control w100porcent" required="">
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
                <input type="email" name="email" class="form-control w100porcent" required="">
                </p>
            </div>
            <div class="form col-md-12 m-t20 nopadding">
                <p>CAPTCHA Code* - Resolve this easy math account<br>
                                                <label for="nums" class="nums" data-result="11">6 + 5</label>
                <input type="text" class="result form-control w15porcent" placeholder="এখানে ফল রাখুন" name="result" required="">
                </p>
                <div id="resolve" class="btn btn-primary">সমাধান</div>
                <p class="alert-danger captcha-error" style="display: none;">ত্রুটি আবার চেষ্টা করুন.</p>
                <p class="alert-success captcha-correct" style="display: none;">নির্ভুল!</p>
            </div>
            <div class="form col-md-12 m-t20 nopadding">
            <button type="submit" id="submit" class="btn btn-primary m-b20" disabled="">পাঠান</button>
            </div>
            </form>
     
</div>