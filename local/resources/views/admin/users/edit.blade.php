@extends('layouts.admin')
@section('title')
 Edit User
    
@endsection
@section('content')
<h2 class="userid" data-userid="{{$user->id}}">{{$user->name}}
    <span class="label label-success">{{$user->type}}</span> 
    </h2>
    <h3>User Points: <span class="userpoints label label-warning">{{$sum}}</span></h3>
    <h3>Points Last Month:  <span class="userpoints label label-success">{{$sumMonth}}</span></h3>
    <h3>Points Last Year:  <span class="userpoints label label-danger">{{$sumYear}}</span></h3>
    <h3><div class="btn btn-warning"  data-toggle="modal" data-target="#pickupDates">Select dates</div></h3>


    <!-- Modal -->
    <div id="pickupDates" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Select two dates to see user points between them</h4>
          </div>
          <div class="modal-body">
                <div class="well">
                  <div id="datetimepicker1">
                  <label for="date1">From</label>
                  <input type="text" name="daterange" class="form-control from" value="" />               
                  </div>
                  <div id="datetimepicker1">
                  <label for="date1">To</label>
                  <input type="text" name="daterange2" class="form-control to" value="" />               
                  </div>
                </div>

                  <div class="btn btn-danger getpoints col-xs-12">Get Points!</div>
                  <div class="clearfix"></div>
                  <div class=" col-xs-12 panel panel-danger"><h2 class="text-center mypoints"></h2></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="actions col-xs-12">
                    <a class="btn btn-primary" href="{{url('admin/posts/'.$user->id.'/user')}}"><i class="fa fa-archive"></i> User Posts</a>
                    <a class="btn btn-primary" href="{{url('admin/photos/'.$user->id.'/user')}}"><i class="fa fa-photo"></i> User Photos</a>
                    <a class="btn btn-primary" href="{{url('admin/videos/'.$user->id.'/user')}}"><i class="fa fa-video-camera"></i> User Videos</a>
                    <a class="btn btn-primary" href="{{url('admin/ebooks/'.$user->id.'/user')}}"><i class="fa fa-book"></i> User Ebooks</a>
                </div>
                <hr>
                {!! Form::open(['route' => ['admin.users.update',$user->id],'method' => 'PUT','files' => true]) !!}
                    @if($user->profile_image)
                    <div class="col-xs-6">

                        @if($user->facebook_id == null &&  $user->twitter_id == null)                        
                        <img src="{{asset('img/users/profile').'/profile_'.$user->profile_image}}" style="max-width:100%;" class="img-circle col-xs-4" alt="The Post Page ">
                        @elseif(Auth::user()->facebook_id != null ||  Auth::user()->twitter_id != null)          
                          <img src="{{$user->profile_image}}" style="max-width:100%;" class="img-circle" alt="The Public Post ">
                        @else
                         <img src="asset('img/profile.png')" class="img-circle" alt="The Post Page ">
                        @endif                        
                     </div>
                    @else
                    <div class="col-xs-6">
                        <img src="{{asset('img/profile.png')}}" class="img-circle " alt="The Post Page ">   
                        <div class="panel panel-success">
                          <div class="panel-heading">* Please change your profile image.</div>
                        </div>
                    </div>
                    @endif

                    <div class="form-group col-xs-6">
                    <i class="fa fa-photo"></i>
                        {!! Form::label('profile_image','Profile Image') !!}
                        {!! Form::file('profile_image',null,['class'=> 'form-control','required']) !!}

                    </div>          
                    <div class="form-group col-xs-12">
                    <i class="fa fa-pencil user-name" data-user="{{$user->id}}"></i>
                        {!! Form::label('name','Name') !!}
                        {!! Form::text('name', $user->name,['class'=> 'form-control','placeholder'=>'Type a name','required']) !!}
                    </div>
                                
                    <div class="form-group col-xs-12">
                        <i class="fa fa-tag"></i>
                        {!! Form::label('tagline','Tagline') !!}
                        {!! Form::text('tagline', $user->tagline,['class'=> 'form-control','placeholder'=>'Type a tagline','required']) !!}
                    </div>
                    <div class="form-group col-xs-12">
                    <i class="fa fa-facebook-square"></i>
                        {!! Form::label('facebook_real','Facebook ID') !!}
                        {!! Form::text('facebook_real', $user->facebook_real,['class'=> 'form-control','placeholder'=>'Type your Facebook ID']) !!}
                    </div>
                    <div class="form-group col-xs-12">
                        <i class="fa fa-twitter-square"></i>
                        {!! Form::label('twitter_real','Twitter ID') !!}
                        {!! Form::text('twitter_real', $user->twitter_real,['class'=> 'form-control','placeholder'=>'Type your Twitter ID']) !!}
                    </div>
                   
                    <div class="form-group col-xs-12">
                        <i class="fa fa-envelope"></i>

                        {!! Form::label('email','E-mail') !!}
                        {!! Form::email('email', $user->email,['class'=> 'form-control','placeholder'=>'youremail@gmail.com','required']) !!}
                    </div>
                        
                    <div class="form-group col-xs-12">
                        <i class="fa fa-money"></i>
                        {!! Form::label('bkash','Bkash') !!}
                        {!! Form::text('bkash', $user->bkash,['class'=> 'form-control','placeholder'=>'Type your bkash ID','required']) !!}
                    </div>

                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
                    <div class="form-group col-xs-12">
                        <i class="fa fa-user-group"></i>
                        {!! Form::label('type','User Type') !!}
                        {!! Form::select('type',[''=>'Select type of user','subscriber'=> 'Subscriber','writer'=> 'Writer','editor'=> 'Editor','admin' => 'Administrator'],$user->type,['class'=> 'form-control','required']) !!}
                    </div>
                    @endif
                    <div class="form-group col-xs-12">
                        {!! Form::submit('Edit User',['class'=>'btn btn-primary']) !!}
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.row -->
@endsection
@section('js')
      <script>
      var from=0;
      var to = 0;
      var userid=$('.userid').data('userid');
      $('.results').hide();    
      $('input[name="daterange"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true
      });
      $('input[name="daterange2"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true

      });
    $('.getpoints').on('click',function(){
        from=$('.from').val().toString();
        to=$('.to').val().toString();
        var newchar = '-'
        from = from.split('/').join(newchar);
        to = to.split('/').join(newchar);
        console.log('from ->'+from);
        console.log('to ->'+to);
        $.ajax({
            
            url: '{{ url('/points/getUserPoints') }}'+ '/' + userid + '/' +from+'/'+to,
            type: 'GET',
            success: function(data) {
                console.log('USER POINTS', data['msg']);
                $(".mypoints").text(data['msg']);
            }
        });

    });
      </script>

@endsection