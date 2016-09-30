@extends('layouts.admin')
@section('title')
    All Users
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-6">
            	<a href="{{ route('admin.users.create')}}" class="btn btn-info"> User List</a>
				<table class="table">
					<thead>
						<th>ID</th>
						<th>Name</th>
						<th>E-mail</th>
						<th>Type</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr>
								<td>{{$user->id}}</td>
								<td>{{$user->name}}</td>
								<td>{{$user->email}}</td>
								<td>
									@if($user->type == "admin")
									<span class="label label-danger">Administrator</span>
									@elseif($user->type == "editor")
										<span class="label label-primary">Editor</span>		
									@elseif($user->type == "writer")
										<span class="label label-primary">Writer</span>	
									@elseif($user->type == "subscriber")
										<span class="label label-primary">Subscriber</span>								
									@endif
								</td>
								<td><a href="{{route('admin.users.edit',$user->id)}}" class="btn btn-warning">Edit</a> <a href="{{route('admin.users.destroy',$user->id)}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">Delete</a> </td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{!! $users->render() !!}
            </div>
        </div>
        <!-- /.row -->
@endsection