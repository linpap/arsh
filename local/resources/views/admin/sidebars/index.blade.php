@extends('layouts.admin')
@section('title','Left Sidebar')

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-6">
            	<a href="{{ route('admin.sidebars.create')}}" class="btn btn-info"> Add new item</a>
            	{!!Form::open(['route'=>'admin.sidebars.index','method'=>'GET','class'=>'navbar-form pull-right'])!!}
            		<div class="input-group">
            			{!!Form::text('title',null,['class'=>'form-control','placeholder'=>'Search Photophoto','aria-describedby'=>'search'])!!}
            			<span class="input-group-addon" id="search">
            				<span class="glyphicon glyphicon-search" aria-hidden="true" ></span>
            			</span>
            		</div>
            	{!! Form::close() !!}
            	<hr>
				<table class="tablesorter table" id="myTable" data-count="{{count($sidebars)}}"> <!-- Get count to validate 3 post only and don't break the front end -->
					<thead>
						<th>ID <span class="pull-right fa fa-sort"></span></th>
						<th>Position <span class="pull-right fa fa-sort"></span> </th>
						<th>Category <span class="pull-right fa fa-sort"></span></th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($sidebars as $sidebar)
							<tr>
								<td>{{$sidebar->id}}</td>
								<td>{{$sidebar->position}}</td>
								<td>{{$sidebar->category->name}}</td>
								<td>
									@if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
									<a href="{{route('admin.sidebars.edit',$sidebar->id)}}" class="edit btn btn-warning">Edit</a>
									@endif
									
									@if(Auth::user()->type == 'admin')
								    <a href="{{route('admin.sidebars.destroy',$sidebar->id)}}"  class="delete btn btn-danger">Delete</a>
								    @endif 
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="text-center">
					{!! $sidebars->render() !!}
				</div>
				
            </div>
        </div>
        <!-- /.row -->
@endsection
@section('js')
@endsection