@extends('layouts.admin')
@section('title')
    Edit Tag
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-3 col-md-6">
            	{!! Form::open(['route' => ['admin.tags.update',$tag->id],'method' => 'PUT']) !!}

            		<div class="form-group">
            			{!! Form::label('name','Name') !!}
            			{!! Form::text('name', $tag->name,['class'=> 'form-control','placeholder'=>'Type a name for the tag','required']) !!}
            		</div>
            		<div class="form-group">
            			{!! Form::submit('Edit Tag',['class'=>'btn btn-primary']) !!}
            		</div>

            	{!! Form::close() !!}
            </div>
        </div>
        <!-- /.row -->


@endsection