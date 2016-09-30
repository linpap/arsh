@extends('layouts.admin')
@section('title','All Subcategories')

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-6">
            	<a href="{{ route('admin.subcategories.create')}}" class="btn btn-info"> Create New Category</a>
				<table class="table">
					<thead>
						<th>ID</th>
						<th>Name</th>
						<th>Category</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($subcategories as $subcategory)
							<tr>
								<td>{{$subcategory->id}}</td>
								<td>{{$subcategory->name}}</td>
								<td>{{$subcategory->category->name}}</td>
								<td><a href="{{route('admin.subcategories.edit',$subcategory->id)}}" class="btn btn-warning">Edit</a> <a href="{{route('admin.subcategories.destroy',$subcategory->id)}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">Delete</a> </td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{!! $subcategories->render() !!}
            </div>
        </div>
        <!-- /.row -->
@endsection