@extends('layouts.admin')
@section('title','Header Navbar')

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-6">
            	<a href="{{ route('admin.navbars.create')}}" class="btn btn-info"> Add new item</a>
            	{!!Form::open(['route'=>'admin.navbars.index','method'=>'GET','class'=>'navbar-form pull-right'])!!}
            		<div class="input-group">
            			{!!Form::text('title',null,['class'=>'form-control','placeholder'=>'Search Photophoto','aria-describedby'=>'search'])!!}
            			<span class="input-group-addon" id="search">
            				<span class="glyphicon glyphicon-search" aria-hidden="true" ></span>
            			</span>
            		</div>
            	{!! Form::close() !!}
            	<hr>
				<table class="tablesorter table" id="myTable" data-count="{{count($navbars)}}"> <!-- Get count to validate 3 post only and don't break the front end -->
					<thead>
						<th>ID <span class="pull-right fa fa-sort"></span></th>
						<th>Position <span class="pull-right fa fa-sort"></span> </th>
						<th>Category <span class="pull-right fa fa-sort"></span></th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($navbars as $navbar)
							<tr>
								<td>{{$navbar->id}}</td>
								<td>{{$navbar->position}}</td>
								<td>{{$navbar->category->name}}</td>
								<td>
									@if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
									<a href="{{route('admin.navbars.edit',$navbar->id)}}" class="edit btn btn-warning">Edit</a>
									@endif
									
									@if(Auth::user()->type == 'admin')
								    <a href="{{route('admin.navbars.destroy',$navbar->id)}}"  class="delete btn btn-danger">Delete</a>
								    @endif 
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="text-center">
					{!! $navbars->render() !!}
				</div>
				
            </div>
        </div>
        <!-- /.row -->
@endsection
@section('js')
@endsection