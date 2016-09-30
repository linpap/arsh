@extends('layouts.admin')
@section('title','My VideoPosts')

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-6">
            	<a href="{{ route('admin.videos.create')}}" class="btn btn-info"> Create New VideoPost</a>
            	{!!Form::open(['route'=>'admin.videos.index','method'=>'GET','class'=>'navbar-form pull-right'])!!}
            		<div class="input-group">
            			{!!Form::text('title',null,['class'=>'form-control','placeholder'=>'Search VideoPost','aria-describedby'=>'search'])!!}
            			<span class="input-group-addon" id="search">
            				<span class="glyphicon glyphicon-search" aria-hidden="true" ></span>
            			</span>
            		</div>
            	{!! Form::close() !!}
            	<hr>

				<table class="tablesorter table" id="myTable" data-count="{{count($videos)}}"> <!-- Get count to validate 3 post only and don't break the front end -->
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
						@foreach($videos as $video)
							<tr>
								<td>{{$video->id}}</td>
								<td>{{$video->title}}</td>
								<td>{{$video->category->name}}</td>
								<td>{{$video->user->name}}</td>
								<td>{{$video->status}}</td>
								<td>{{$video->views}}</td>
								<td>
									@if($video->status == 'approved' && Auth::user()->type=='admin' || Auth::user()->type == 'editor')
									<a href="#"  class="approve-disable btn btn-success" disabled="disabled">Approve</a>
									@elseif(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
									<a href="{{route('admin.videos.approve',$video->id)}}"  class="approve btn btn-success">Approve</a>
									@endif
									@if($video->status == 'suspended' && Auth::user()->type=='admin' || Auth::user()->type == 'editor')
									<a href="{{route('admin.videos.suspend',$video->id)}}"  disabled="disabled" class="suspend-disable btn btn-primary">Suspend</a>
									@elseif(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
									@if(Auth::user()->type != 'subscriptor')					
									<a href="{{route('admin.videos.suspend',$video->id)}}" class="suspend btn btn-primary">Suspend</a>
									@endif
									@endif
									<a href="{{route('admin.videos.edit',$video->id)}}" class="edit btn btn-warning">Edit</a>
									@if(Auth::user()->type == 'admin')
								    <a href="{{route('admin.videos.destroy',$video->id)}}"  class="delete btn btn-danger">Delete</a>
								    @endif 
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="text-center">
					{!! $videos->render() !!}
				</div>
				
            </div>
        </div>
        <!-- /.row -->
@endsection
@section('js')
@endsection