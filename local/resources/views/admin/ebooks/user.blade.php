@extends('layouts.admin')
@section('title')
{{$user->name}} Ebook
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
						@foreach($ebooks as $ebook)
							<tr>
								<td>{{$ebook->id}}</td>
								<td>{{$ebook->title}}</td>
								<td>{{$ebook->category->name}}</td>
								<td>{{$ebook->user->name}}</td>
								<td>{{$ebook->status}}</td>
								<td>{{$ebook->views}}</td>
								<td>
									@if($ebook->status == 'approved' && Auth::user()->type=='admin')
									<a href="#" onclick="return confirm('This ebooks is already approved.');" class="btn btn-success" disabled="disabled">Approve</a>
									@elseif(Auth::user()->type == 'admin')
										<a href="{{route('admin.ebooks.approve',$ebook->id)}}" onclick="return confirm('Are you sure?');" class="btn btn-success">Approve</a>
									@endif
									@if($ebook->status == 'suspended' && Auth::user()->type=='admin')
									<a href="{{route('admin.ebooks.suspend',$ebook->id)}}" onclick="return confirm('This ebooks is already suspended.');" disabled="disabled" class="btn btn-primary">Suspend</a>
									@elseif(Auth::user()->type == 'admin')									
									<a href="{{route('admin.ebooks.suspend',$ebook->id)}}" onclick="return confirm('Are you sure?');" class="btn btn-primary">Suspend</a>
									@endif
									<a href="{{route('admin.ebooks.edit',$ebook->id)}}" class="btn btn-warning">Edit</a>
								   <a href="{{route('admin.ebooks.destroy',$ebook->id)}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">Delete</a> </td>
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