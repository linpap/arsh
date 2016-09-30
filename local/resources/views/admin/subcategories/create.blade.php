@extends('layouts.admin')
@section('title')
    New Subcategory
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-3 col-md-6">
            	{!! Form::open(['route' => 'admin.subcategories.store','method' => 'POST']) !!}

            		<div class="form-group">
            			{!! Form::label('name','Name') !!}
            			{!! Form::text('name', null,['class'=> 'form-control','placeholder'=>'Type a name for the subcategory','required']) !!}
            		</div>
                    <div class="form-group">
                        {!! Form::label('category_id','Select Category') !!}
                        <select class="form-control" required="required" id="category_id" name="category_id">
                            @foreach($categories as $rowData):
                              <option value="{{$rowData->id}}">{{$rowData->type}}-{{$rowData->name}}</option>
                             @endforeach
                        </select>
                        {{--{!! Form::select('category_id',$categories,null,['class'=> 'form-control','required']) !!}--}}
                    </div>
            		<div class="form-group">
            			{!! Form::submit('Add SubCategory',['class'=>'btn btn-primary']) !!}
            		</div>

            	{!! Form::close() !!}
            </div>
        </div>
        <!-- /.row -->


@endsection