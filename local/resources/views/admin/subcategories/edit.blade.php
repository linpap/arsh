@extends('layouts.admin')
@section('title')
    Edit SubCategory
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-3 col-md-6">
            	{!! Form::open(['route' => ['admin.subcategories.update',$subcategory->id],'method' => 'PUT','files'=>'true']) !!}

            		<div class="form-group">
            			{!! Form::label('name','Name') !!}
            			{!! Form::text('name', $subcategory->name,['class'=> 'form-control','placeholder'=>'Type a name for the subcategory','required']) !!}
            		</div>
                    <div class="form-group">
                        {!! Form::label('category_id','Select Category') !!}
                        <select class="form-control" required="required" id="category_id" name="category_id">
                            @foreach($categories as $rowData)
                            <option <?php if($subcategory->category_id==$rowData->id){ echo "selected"; }?> value="{{$rowData->id}}">{{$rowData->type}}-{{$rowData->name}}</option>
                            @endforeach
                        </select>
                        {{--{!! Form::select('category_id',$categories,$subcategory->category_id,['class'=> 'form-control','required']) !!}--}}
                    </div>
            		<div class="form-group">
            			{!! Form::submit('Edit SubCategory',['class'=>'btn btn-primary']) !!}
            		</div>

            	{!! Form::close() !!}
            </div>
        </div>
        <!-- /.row -->


@endsection