    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container" style="padding:0">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="logo">
                <a href="{{url('/')}}" class="navbar-left"><img class="img-responsive" src="{{asset('img/Logo.png')}}" alt="logo"></a>
                </div>
                <!---<a class="navbar-brand" href="#">Start Bootstrap</a>-->
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse main-menu" id="bs-example-navbar-collapse-1">
                <div class="ul">
                <ul class="nav navbar-nav">
                @if(count($navbars)>0)
                    @foreach($navbars as $item)
                    <li class="li-items" style="height:100%">
                    <?php $url=''; ?>
                        @if($item->category()->first()->name == 'ভিডিও')
                            <?php $url='videos/allvideos'; ?>
                        @elseif($item->category()->first()->name == 'ফটো')
                            <?php $url="photos/allphotos";?>
                        @elseif($item->category()->first()->name == 'ইসলাম')
                            <?php $url="ebooks/allebooks"; ?>
                        @endif
                        @if(isset($url) && $url != '') <!-- This shows particular pages -->
                            <a href="{{url($url)}}" style="line-height:65px;padding:0px 10px;color:white; text-decoration:none">{{$item->category()->first()->name}}</a>
                        @else
                            <a href="{{url('categories/'.$item->category()->first()->id)}}" style="line-height:65px;padding:0px 10px;color:white; text-decoration:none">{{$item->category()->first()->name}}</a>

                            <?php 
                                $subcategories = DB::table('subcategories')
                                 ->where('category_id', '=',$item->category->id)                                
                                 ->get();
                                $count =  DB::table('subcategories')
                                 ->where('category_id', '=',$item->category->id)                                
                                 ->count();


                            ?>
                            @if($count != 0)
                            <ul class=" subcategories">
                            @foreach($subcategories as $subcategory)                            
                                <li style="height:100%">
                                    <a href="{{url('subcategories/'.$subcategory->id)}}" style="color:white; text-decoration:none;display:block;">{{$subcategory->name}}</a>
                                </li>
                            @endforeach
                            </ul>
                            @endif
                        @endif
                    </li>
                    @endforeach
                @endif
                    <li style="cursor:pointer;" class="login">
                    @if(Auth::check())
                        <span class="icono-toggle glyphicon glyphicon-triangle-bottom triangulo2" style="color: rgb(255, 255, 255); position: absolute; top: 24px; font-size: 15px; right: 15px;"></span>
                        <a href="#" class="user-login register pull-right">
                                
                                    @if(Auth::user()->profile_image && Auth::user()->facebook_id == null && Auth::user()->twitter_id == null)
                                    
                                      <img src="{{asset('img/users/profile/profile_'.Auth::user()->profile_image)}}" class="img-circle" alt="The Post Page " style="max-width:40px" alt="">
                                    @elseif(Auth::user()->facebook_id != null || Auth::user()->twitter_id != null )          
                                      <img src="{{Auth::user()->profile_image}}" style="max-width:40px" alt="" class="img-circle" alt="The Post Page ">
                                    @else
                                     <img src="{{asset('img/profile.png')}}" style="max-width:40px" alt="" class="img-circle" alt="The Post Page ">
                                    @endif                            
                        
                        <div class="profile-menu">
                            <span class="glyphicon glyphicon-triangle-top triangulo" style="right: 12px; color: rgb(255, 255, 255); top: -11px; position:absolute;"></span>
                            <ul class="profile-ul">
                                @if(Auth::user()->type != 'subscriber')
                                <li class="li-first"><a href="{{url('/admin')}}">Dashboard</a></li>
                                <li class="li-first"><a href="{{url('admin/posts/create')}}">Post your story</a></li>
                                <li><a href="{{url('admin/photos/create')}}">Post photo story</a></li>
                                <li><a href="{{url('admin/videos/create')}}">Post video story</a></li>
                                <li><a href="{{url('admin/ebooks/create')}}">Post ebook </a></li>
                                <li><a href="{{url('admin/users/'.Auth::user()->id.'/edit/')}}">Profile</a></li>
                                <li class="li-last"><a href="{{url('/logout')}}">Log out</a></li>
                                @else
                                <li><a href="{{url('admin/users/'.Auth::user()->id.'/edit/')}}">Profile</a></li>
                                <li class="li-last"><a href="{{url('/logout')}}">Log out</a></li>
                                @endif
                            </ul>
                        </div>
                        </a>
                        @else
                        <div class="pull-right" style="color:white;"> 
                                <a href="{{url('/login')}}" style="line-height:65px;padding:0px 10px;color:white" class="register">sign in </a> / <a href="{{url('/register')}}" style="line-height:65px;padding:0px 10px;color:white">sign up</a>
                        </div>
                    
                    @endif
                    
                    </li>

                </ul>
                </div>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
