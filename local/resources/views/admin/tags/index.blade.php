@extends('layouts.admin')
@section('title','All Tags')

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-6">
            	<a href="{{ route('admin.tags.create')}}" class="btn btn-info"> Create New Tag</a>
            	
            	{!!Form::open(['route'=>'admin.tags.index','method'=>'GET','class'=>'navbar-form pull-right'])!!}
            		<div class="input-group">
            			{!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Search Tag','aria-describedby'=>'search'])!!}
            			<span class="input-group-addon" id="search">
            				<span class="glyphicon glyphicon-search" aria-hidden="true" ></span>
            			</span>
            		</div>
            	{!! Form::close() !!}
				<table class="table">
					<thead>
						<th>ID</th>
						<th>Name</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($tags as $tag)
							<tr>
								<td>{{$tag->id}}</td>
								<td>{{$tag->name}}</td>
								<td><a href="{{route('admin.tags.edit',$tag->id)}}" class="btn btn-warning">Edit</a> <a href="{{route('admin.tags.destroy',$tag->id)}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">Delete</a> </td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{!! $tags->render() !!}
            </div>
        </div>
        <!-- /.row -->
@endsection