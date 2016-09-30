@extends('layouts.admin')
@section('title','All PhotoPosts')

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-6">
            	<a href="{{ route('admin.photos.create')}}" class="btn btn-info"> Create New Photophoto</a>
            	{!!Form::open(['route'=>'admin.photos.index','method'=>'GET','class'=>'navbar-form pull-right'])!!}
            		<div class="input-group">
            			{!!Form::text('title',null,['class'=>'form-control','placeholder'=>'Search Photophoto','aria-describedby'=>'search'])!!}
            			<span class="input-group-addon" id="search">
            				<span class="glyphicon glyphicon-search" aria-hidden="true" ></span>
            			</span>
            		</div>
            	{!! Form::close() !!}
            	<hr>

				<table class="tablesorter table" id="myTable" data-count="{{count($photos)}}"> <!-- Get count to validate 3 post only and don't break the front end -->
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
						@foreach($photos as $photo)
							<tr>
								<td>{{$photo->id}}</td>
								<td>{{$photo->title}}</td>
								<td>{{$photo->category->name}}</td>
								<td>{{$photo->user->name}}</td>
								<td>{{$photo->status}}</td>
								<td>{{$photo->views}}</td>
								<td>
									@if($photo->status == 'approved' && Auth::user()->type=='admin' || Auth::user()->type == 'editor')
									<a href="#" onclick="return confirm('This photos is already approved.');" class="approve-disable btn btn-success" disabled="disabled">Approve</a>
									@elseif(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
									<a href="{{route('admin.photos.approve',$photo->id)}}"  class="approve btn btn-success">Approve</a>
									@endif
									@if($photo->status == 'suspended' && Auth::user()->type=='admin' || Auth::user()->type == 'editor')
									<a href="{{route('admin.photos.suspend',$photo->id)}}"  disabled="disabled" class="suspend-disable btn btn-primary">Suspend</a>
									@elseif(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
									@if(Auth::user()->type != 'subscriptor')					
									<a href="{{route('admin.photos.suspend',$photo->id)}}" class="suspend btn btn-primary">Suspend</a>
									@endif
									@endif
									<a href="{{route('admin.photos.edit',$photo->id)}}" class="edit btn btn-warning">Edit</a>
									@if(Auth::user()->type == 'admin')
								    <a href="{{route('admin.photos.destroy',$photo->id)}}"  class="delete btn btn-danger">Delete</a>
								    @endif 
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="text-center">
					{!! $photos->render() !!}
				</div>
				
            </div>
        </div>
        <!-- /.row -->
@endsection
@section('js')
@endsection