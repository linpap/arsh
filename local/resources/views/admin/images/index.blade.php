@extends('admin.layout.main')

@section('title','All images')

@section('content')
	<div class="row">
		@foreach($images as $image)
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<img src="../images/posts/{{$image->name}}" alt="" class="img-responsive">
					</div>
				</div>
				<div class="panel-footer">{{$image->post->title}}</div>
			</div>
		@endforeach
	</div>

@endsection