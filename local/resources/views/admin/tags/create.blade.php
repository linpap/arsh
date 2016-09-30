@extends('layouts.admin')
@section('title')
    New Tag
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-3 col-md-6">
            	{!! Form::open(['route' => 'admin.tags.store','method' => 'POST']) !!}

            		<div class="form-group">
            			{!! Form::label('name','Name') !!}
            			{!! Form::text('name', null,['class'=> 'form-control','placeholder'=>'Type a name for the tag','required']) !!}
            		</div>
            		<div class="form-group">
            			{!! Form::submit('Add Tag',['class'=>'btn btn-primary']) !!}
            		</div>

            	{!! Form::close() !!}
            </div>
        </div>
        <!-- /.row -->


@endsection