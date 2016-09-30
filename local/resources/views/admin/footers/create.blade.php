@extends('layouts.admin')
@section('title')
    Create Navbar Item
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-3 col-md-6">
            	{!! Form::open(['route' => 'admin.footers.store','method' => 'POST']) !!}
            	
                    <div class="form-group">
                        {!! Form::label('category_id','Category') !!}
                        {!! Form::select('category_id', $categories,null,['class'=> 'form-control select-category','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('position','Position') !!}
                        {!! Form::select('position', array(0,1,2,3,4,5,6,7,8,9),null,['class'=> 'form-control select-category','required']) !!}
                    </div>
            		<div class="form-group">
            			{!! Form::submit('Add Item',['class'=>'btn btn-primary']) !!}
            		</div>

            	{!! Form::close() !!}
            </div>
        </div>
        <!-- /.row -->


@endsection