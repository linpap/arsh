@extends('layouts.admin')
@section('title')
    New Category
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-3 col-md-6">
            	{!! Form::open(['route' => 'admin.categories.store','method' => 'POST']) !!}

            		<div class="form-group">
            			{!! Form::label('name','Name') !!}
            			{!! Form::text('name', null,['class'=> 'form-control','placeholder'=>'Type a name for the category','required']) !!}
            		</div>
                    <div class="form-group">
                        {!! Form::label('type','Category Type') !!}
                        {!! Form::select('type',[''=>'Select type of category','ebook'=> 'Ebook','post' => 'Post','photo'=>'Photo','video' => 'Video'],null,['class'=> 'form-control','required']) !!}
                    </div>
            		<div class="form-group">
            			{!! Form::submit('Add Category',['class'=>'btn btn-primary']) !!}
            		</div>

            	{!! Form::close() !!}
            </div>
        </div>
        <!-- /.row -->


@endsection