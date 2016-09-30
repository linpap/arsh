            <!-- Blog Sidebar Widgets Column -->

            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 sidebar">

            <div class="sidebar_ad col-center">

            @if($firstSidebarRight != '')

            <img class="img-responsive center-block" src="{{asset('img/advs/adv_'.$firstSidebarRight)}}" style="padding-bottom:20px" alt="">

            @else

                <div class="center-block">

                    {{$firstSidebarRight}}

                </div>

            @endif

            </div>

                <!-- Side Widget Well -->

                <div class="col-lg-12 col-md-8 col-sm-8 col-xs-10 col-lg-offset-0 col-md-offset-2 col-sm-offset-2 col-xs-offset-1 first">

                    <h4 align="center"><a href="#" style="margin-right:10px; font-weight: bold; font-size: 1.3em; text-decoration:none">Link#1</a><a href="#" style="margin-right:10px;font-weight: bold; font-size: 1.3em; text-decoration:none">Link #2</a><a href="#" style="font-weight: bold; font-size: 1.3em; text-decoration:none">Link #3</a></h4>

                    <a href="#"><img class="img-responsive center-block" src="{{asset('img/girl.jpg')}}" alt="" style="margin-bottom:20px"></a>

                </div>



                <!-- Blog Search Well -->

                <div class="well col-lg-12 col-md-8 col-sm-8 col-xs-10 col-lg-offset-0 col-md-offset-2 col-sm-offset-2 col-xs-offset-1 first">

                    <div class="input-group">

                        <span class="input-group-btn">

                        <button class="btn btn-default" type="button">

                                <span class="glyphicon glyphicon-search"></span>

                        </button>

                        </span>

                        <input type="text" class="form-control" placeholder="Search...">

                    </div>

                    <!-- /.input-group -->

                </div>



                <!-- Blog Categories Well -->

                <div class="well categories col-lg-12 col-md-8 col-sm-8 col-xs-10 col-lg-offset-0 col-md-offset-2 col-sm-offset-2 col-xs-offset-1">

                    <h4 style="text-align:center">Lorem Itsum</h4>

                    <div class="row">

                        <div class="col-lg-12">

                            <h5>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,

                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo

                            consequat.</h5><br>

                            <h6>Lorem ipsum dolor sit amet</h6>

                            <hr />

                            <h4 style="color:blue;">Lorem ipsum dolor sit amet</h4>

                            <div class="col-lg-12 social col-md-10 col-sm-10 col-xs-12 col-lg-offset-0 col-md-offset-1 col-sm-offset-1 col-xs-offset-0" style="padding:0">

                                <div class="facebook col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding:0px;margin-right:10px">

                                <a href="#"><img src="{{asset('img/social_fb.png')}}" class="img-responsive center-block" alt="social" style="width:100%"></a>

                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding:0px;margin-right:10px">

                                <a href="#"><img src="{{asset('img/social_tw.png')}}" class="img-responsive center-block" alt="social" style="width:100%"></a>

                                </div>                                

                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding:0px;margin-right:10px">

                                <a href="#"><img src="{{asset('img/social_gl.png')}}" class="img-responsive center-block" alt="social" style="width:100%"></a>

                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding:0px;margin-right:10px">

                                <a href="#"><img src="{{asset('img/social_in.png')}}" class="img-responsive center-block" alt="social" style="width:100%"></a>

                                </div>                                

                                <div class="youtube col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding:0px;margin-right:10px">

                                <a href="#"><img src="{{asset('img/social_yt.png')}}" class="img-responsive center-block" alt="social" style="width:100%"></a>

                                </div>

                                </div>

                        </div>

                    </div>

                    <!-- /.row -->

                </div>

                

            @if($secondSidebarRight != '')            

            <img src="{{asset('img/advs/adv_'.$secondSidebarRight)}}" style="padding-bottom:50px" class="img-responsive center-block">

            @else

                {{$secondSidebarRightScript}}

            @endif   



            @if($thirdSidebarVertical != '')

                <img src="{{asset('img/advs/adv_'.$thirdSidebarVertical)}}" style="padding-bottom:50px" class="img-responsive center-block">

            @elseif($thirdSidebarVertical)

                <div class="center-block">

                    {{$thirdSidebarVertical}}

                </div>

            @endif

            </div>