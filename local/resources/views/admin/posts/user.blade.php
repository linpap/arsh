@extends('layouts.admin')
@section('title')
{{$user->name}} Posts
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-6">
          

				<table class="tablesorter table" id="myTable">
					<thead>
						<th>ID <span class="pull-right fa fa-sort"></span></th>
						<th>Title <span class="pull-right fa fa-sort"></span> </th>
						<th>Categories <span class="pull-right fa fa-sort"></span></th>
						<th>User <span class="pull-right fa fa-sort"></span></th>						
						<th>Status <span class="pull-right fa fa-sort"></span></th>
						<th>Views <span class="pull-right fa fa-sort"></span></th>
						<th>Action</th>
					</thead>

					<tbody>
						@foreach($posts as $post)
							<tr>
								<td>{{$post->id}}</td>
								<td>{{$post->title}}</td>
								<td>{{$post->category->name}}</td>
								<td>{{$post->user->name}}</td>
								<td>{{$post->status}}</td>
								<td>{{$post->views}}</td>
								<td>
									@if($post->status == 'approved' && Auth::user()->type=='admin')
									<a href="#" onclick="return confirm('This posts is already approved.');" class="btn btn-success" disabled="disabled">Approve</a>
									@elseif(Auth::user()->type == 'admin')
										<a href="{{route('admin.posts.approve',$post->id)}}" onclick="return confirm('Are you sure?');" class="btn btn-success">Approve</a>
									@endif
									@if($post->status == 'suspended' && Auth::user()->type=='admin')
									<a href="{{route('admin.posts.suspend',$post->id)}}" onclick="return confirm('This posts is already suspended.');" disabled="disabled" class="btn btn-primary">Suspend</a>
									@elseif(Auth::user()->type == 'admin')									
									<a href="{{route('admin.posts.suspend',$post->id)}}" onclick="return confirm('Are you sure?');" class="btn btn-primary">Suspend</a>
									@endif
									<a href="{{route('admin.posts.edit',$post->id)}}" class="btn btn-warning">Edit</a>
								   <a href="{{route('admin.posts.destroy',$post->id)}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">Delete</a> </td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="text-center">
					{!! $posts->render() !!}
				</div>
				
            </div>
        </div>
        <!-- /.row -->
@endsection
@section('js')
@endsection