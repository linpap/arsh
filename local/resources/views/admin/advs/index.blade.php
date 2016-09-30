@extends('layouts.admin')
@section('title','My Advertisements')

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-6">
            	<a href="{{ route('admin.advs.create')}}" class="btn btn-info"> Create New Adv</a>
            	{!!Form::open(['route'=>'admin.advs.index','method'=>'GET','class'=>'navbar-form pull-right'])!!}
            		<div class="input-group">
            			{!!Form::text('title',null,['class'=>'form-control','placeholder'=>'Search Photoadv','aria-describedby'=>'search'])!!}
            			<span class="input-group-addon" id="search">
            				<span class="glyphicon glyphicon-search" aria-hidden="true" ></span>
            			</span>
            		</div>
            	{!! Form::close() !!}
            	<hr>

				<table class="tablesorter table" id="myTable" data-count="{{count($advs)}}"> <!-- Get count to validate 3 post only and don't break the front end -->
					<thead>
						<th>ID <span class="pull-right fa fa-sort"></span></th>
						<th>Section <span class="pull-right fa fa-sort"></span>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($advs as $adv)
							<tr>
								<td>{{$adv->id}}</td>
								<td>{{$adv->section}}</td>
								<td>
									@if($adv->status == 'approved' && Auth::user()->type=='admin' || Auth::user()->type == 'editor')
									<a href="#" onclick="return confirm('This advs is already approved.');" class="approve-disable btn btn-success" disabled="disabled">Approve</a>
									@elseif(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
									<a href="{{route('admin.advs.approve',$adv->id)}}"  class="approve btn btn-success">Approve</a>
									@endif
									@if($adv->status == 'suspended' && Auth::user()->type=='admin' || Auth::user()->type == 'editor')
									<a href="{{route('admin.advs.suspend',$adv->id)}}"  disabled="disabled" class="suspend-disable btn btn-primary">Suspend</a>
									@elseif(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
									@if(Auth::user()->type != 'subscriptor')					
									<a href="{{route('admin.advs.suspend',$adv->id)}}" class="suspend btn btn-primary">Suspend</a>
									@endif
									@endif
									<a href="{{route('admin.advs.edit',$adv->id)}}" class="edit btn btn-warning">Edit</a>
									@if(Auth::user()->type == 'admin')
								    <a href="{{route('admin.advs.destroy',$adv->id)}}"  class="delete btn btn-danger">Delete</a>
								    @endif 
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="text-center">
					{!! $advs->render() !!}
				</div>
				
            </div>
        </div>
        <!-- /.row -->
@endsection
@section('js')
@endsection