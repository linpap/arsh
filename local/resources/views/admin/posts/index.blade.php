@extends('layouts.admin')
@section('title','My Posts')

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-6">
            	<a href="{{ route('admin.posts.create')}}" class="btn btn-info"> Create New Post</a>
            	{!!Form::open(['route'=>'admin.posts.index','method'=>'GET','class'=>'navbar-form pull-right'])!!}
            		<div class="input-group">
            			{!!Form::text('title',null,['class'=>'form-control','placeholder'=>'Search Post','aria-describedby'=>'search'])!!}
            			<span class="input-group-addon" id="search">
            				<span class="glyphicon glyphicon-search" aria-hidden="true" ></span>
            			</span>
            		</div>
            	{!! Form::close() !!}
            	<hr>

				<table class="tablesorter table" id="myTable" data-count="{{count($posts)}}"> <!-- Get count to validate 3 post only and don't break the front end -->
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
								<td>{{$post->views()->count()}} </td>
								<td>
									@if($post->status == 'approved' && Auth::user()->type=='admin' || Auth::user()->type == 'editor')
									<a href="#"  class="approve-disable btn btn-success" disabled="disabled">Approve</a>
									@elseif(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
									<a href="{{route('admin.posts.approve',$post->id)}}"  class="approve btn btn-success">Approve</a>
									@endif
									@if($post->status == 'suspended' && Auth::user()->type=='admin' || Auth::user()->type == 'editor')
									<a href="{{route('admin.posts.suspend',$post->id)}}"  disabled="disabled" class="suspend-disable btn btn-primary">Suspend</a>
									@elseif(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
									@if(Auth::user()->type != 'subscriptor')					
									<a href="{{route('admin.posts.suspend',$post->id)}}" class="suspend btn btn-primary">Suspend</a>
									@endif
									@endif
									<a href="{{route('admin.posts.edit',$post->id)}}" class="edit btn btn-warning">Edit</a>
									@if(Auth::user()->type == 'admin')
								    <a href="{{route('admin.posts.destroy',$post->id)}}"  class="delete btn btn-danger">Delete</a>
								    @endif 
								</td>
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