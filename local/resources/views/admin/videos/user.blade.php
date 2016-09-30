@extends('layouts.admin')
@section('title')
{{$user->name}} Videos
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
						@foreach($videos as $video)
							<tr>
								<td>{{$video->id}}</td>
								<td>{{$video->title}}</td>
								<td>{{$video->category->name}}</td>
								<td>{{$video->user->name}}</td>
								<td>{{$video->status}}</td>
								<td>{{$video->views}}</td>
								<td>
									@if($video->status == 'approved' && Auth::user()->type=='admin')
									<a href="#" onclick="return confirm('This videos is already approved.');" class="btn btn-success" disabled="disabled">Approve</a>
									@elseif(Auth::user()->type == 'admin')
										<a href="{{route('admin.videos.approve',$video->id)}}" onclick="return confirm('Are you sure?');" class="btn btn-success">Approve</a>
									@endif
									@if($video->status == 'suspended' && Auth::user()->type=='admin')
									<a href="{{route('admin.videos.suspend',$video->id)}}" onclick="return confirm('This videos is already suspended.');" disabled="disabled" class="btn btn-primary">Suspend</a>
									@elseif(Auth::user()->type == 'admin')									
									<a href="{{route('admin.videos.suspend',$video->id)}}" onclick="return confirm('Are you sure?');" class="btn btn-primary">Suspend</a>
									@endif
									<a href="{{route('admin.videos.edit',$video->id)}}" class="btn btn-warning">Edit</a>
								   <a href="{{route('admin.videos.destroy',$video->id)}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">Delete</a> </td>
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