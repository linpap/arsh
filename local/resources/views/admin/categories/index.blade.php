@extends('layouts.admin')
@section('title','All Categories')

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-6">
            	<a href="{{ route('admin.categories.create')}}" class="btn btn-info"> Create New Category</a>
				<table class="table">
					<thead>
						<th>ID</th>
						<th>Name</th>
						<th>Type</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($categories as $category)
							<tr>
								<td>{{$category->id}}</td>
								<td>{{$category->name}}</td>
								<td>{{$category->type}}</td>
								<td><a href="{{route('admin.categories.edit',$category->id)}}" class="btn btn-warning">Edit</a> <a href="{{route('admin.categories.destroy',$category->id)}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">Delete</a> </td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{!! $categories->render() !!}
            </div>
        </div>
        <!-- /.row -->
@endsection