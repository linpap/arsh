@extends('layouts.admin')
@section('title','All Ebooks')

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-6">
            	<a href="{{ route('admin.ebooks.create')}}" class="btn btn-info"> Create New Ebook</a>
            	{!!Form::open(['route'=>'admin.ebooks.index','method'=>'GET','class'=>'navbar-form pull-right'])!!}
            		<div class="input-group">
            			{!!Form::text('title',null,['class'=>'form-control','placeholder'=>'Search Ebook','aria-describedby'=>'search'])!!}
            			<span class="input-group-addon" id="search">
            				<span class="glyphicon glyphicon-search" aria-hidden="true" ></span>
            			</span>
            		</div>
            	{!! Form::close() !!}
            	<hr>

				<table class="tablesorter table" id="myTable" data-count="{{count($ebooks)}}"> <!-- Get count to validate 3 post only and don't break the front end -->
					<thead>
						<th>ID <span class="pull-right fa fa-sort"></span></th>
						<th>Title <span class="pull-right fa fa-sort"></span> </th>
						<th>Categories <span class="pull-right fa fa-sort"></span></th>
						<th>Ebook Link <span class="pull-right fa fa-sort"></span></th>		
						<th>User <span class="pull-right fa fa-sort"></span></th>						
						<th>Status <span class="pull-right fa fa-sort"></span></th>
						<th>Views <span class="pull-right fa fa-sort"></span></th>
						<th>Action</th>
					</thead>

					<tbody>
						@foreach($ebooks as $ebook)
							<tr>
								<td>{{$ebook->id}}</td>
								<td>{{$ebook->title}}</td>
								<td>{{$ebook->category->name}}</td>
								<td>{{$ebook->ebook_link}}</td>
								<td>{{$ebook->user->name}}</td>
								<td>{{$ebook->status}}</td>
								<td>{{$ebook->views}}</td>
								<td>
									@if($ebook->status == 'approved' && Auth::user()->type=='admin' || Auth::user()->type == 'editor')
									<a href="#"  class="approve-disable btn btn-success" disabled="disabled">Approve</a>
									@elseif(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
									<a href="{{route('admin.ebooks.approve',$ebook->id)}}"  class="approve btn btn-success">Approve</a>
									@endif
									@if($ebook->status == 'suspended' && Auth::user()->type=='admin' || Auth::user()->type == 'editor')
									<a href="{{route('admin.ebooks.suspend',$ebook->id)}}"  disabled="disabled" class="suspend-disable btn btn-primary">Suspend</a>
									@elseif(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
									@if(Auth::user()->type != 'subscriptor')					
									<a href="{{route('admin.ebooks.suspend',$ebook->id)}}" class="suspend btn btn-primary">Suspend</a>
									@endif
									@endif
									<a href="{{route('admin.ebooks.edit',$ebook->id)}}" class="edit btn btn-warning">Edit</a>
									@if(Auth::user()->type == 'admin')
								    <a href="{{route('admin.ebooks.destroy',$ebook->id)}}"  class="delete btn btn-danger">Delete</a>
								    @endif 
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="text-center">
					{!! $ebooks->render() !!}
				</div>
				
            </div>
        </div>
        <!-- /.row -->
@endsection
@section('js')
@endsection