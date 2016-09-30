@extends('layouts.admin')
@section('title')
    New User
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-3 col-md-6">
                            
                @if(count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>                               
                    @endforeach
                    </ul>
                </div>
                @endif
            	{!! Form::open(['url' => 'admin.users.store','method' => 'POST']) !!}

                    <div class="form-group">
                        {!! Form::label('name','Name') !!}
                        {!! Form::text('name', null,['class'=> 'form-control','placeholder'=>'Type a name','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('facebookid','Facebook') !!}
                        {!! Form::text('facebookid', null,['class'=> 'form-control','placeholder'=>'Type your Facebook ID','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('bkash','Bkash') !!}
                        {!! Form::text('bkash', null,['class'=> 'form-control','placeholder'=>'Type your bkash ID','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('tagline','Tagline') !!}
                        {!! Form::text('tagline', null,['class'=> 'form-control','placeholder'=>'Type your bkash ID','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('facebook_real','Facebook ID') !!}
                        {!! Form::text('facebook_real', null,['class'=> 'form-control','placeholder'=>'Type your Facebook ID']) !!}
                    </div>
            		<div class="form-group">
            			{!! Form::label('twitter_real','Twitter ID') !!}
            			{!! Form::text('twitter_real', null,['class'=> 'form-control','placeholder'=>'Type your Twitter ID']) !!}
            		</div>
                    @if(Auth::user()->type == 'admin')
                        <div class="form-group">
                            {!! Form::label('featured','Featured') !!}
                            {!! Form::checkbox('featured',null,false,['class' => 'form-control','required']) !!}
                        </div>
                    @endif
            		<div class="form-group">
            			{!! Form::label('email','E-mail') !!}
            			{!! Form::email('email', null,['class'=> 'form-control','placeholder'=>'youremail@gmail.com','required']) !!}
            		</div>
            		<div class="form-group">
            			{!! Form::label('password','Password') !!}
            			{!! Form::password('password',['class'=> 'form-control','required']) !!}
            		</div>                    
                    <div class="form-group col-xs-6">
                        {!! Form::label('profile_image','Profile Image') !!}
                        {!! Form::file('profile_image',null,['class'=> 'form-control','required']) !!}

                    </div>  
                    @if(Auth::user()->type == 'admin')
            		<div class="form-group">
            			{!! Form::label('type','User Type') !!}
            			{!! Form::select('type',[''=>'Select type of user','member'=> 'Member','admin' => 'Administrator'],null,['class'=> 'form-control','required']) !!}
            		</div>
                    @endif
            		<div class="form-group">
            			{!! Form::submit('Add User',['class'=>'btn btn-primary']) !!}
            		</div>

            	{!! Form::close() !!}
            </div>
        </div>
        <!-- /.row -->


@endsection