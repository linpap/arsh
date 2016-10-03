@extends('layouts.admin')
@section('title','All Text Blocks')

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-6">
            	<a href="{{ route('admin.rightblocks.create')}}" class="btn btn-info"> Create New Block</a>
				<table class="table">
					<thead>
						<th>ID</th>
						<th>Description</th>
						<th>Type</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($rightblocks as $rightblock)
							<tr>
								<td>{{$rightblock->id}}</td>
								<td>{{$rightblock->description}}</td>
								<td>{{$rightblock->type}}</td>
								<td>
									@if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
									<a href="{{route('admin.rightblocks.edit',$rightblock->id)}}" class="edit btn btn-warning">Edit</a>

									@endif
									@if(Auth::user()->type == 'admin')
								    <a href="{{route('admin.rightblocks.destroy',$rightblock->id)}}"  class="delete btn btn-danger">Delete</a>
								    @endif 
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{!! $rightblocks->render() !!}
            </div>
        </div>
        <!-- /.row -->
@endsection