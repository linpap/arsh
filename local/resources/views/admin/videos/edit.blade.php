@extends('layouts.admin')
@section('title')
    Edit Video
@endsection

@section('content')
        <div class="row">            
            <div class="col-lg-6 col-md-6">
  
                @if(count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>                               
                    @endforeach
                    </ul>
                </div>
                @endif
                    {!! Form::open(['route' => ['admin.videos.update',$video->id],'method' => 'PUT','files'=>'true']) !!}


                    <div class="form-group">
                        {!! Form::label('title','Title') !!}
                        {!! Form::text('title', $video->title,['class'=> 'form-control','placeholder'=>'Type a title','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('category_id','Category') !!}
                        {!! Form::select('category_id', $categories,$video->category->id,['class'=> 'form-control select-category','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('content','Content') !!}
                        {!! Form::textarea('content', $video->content,['class' => 'textarea-content form-control','required']) !!}
                    </div>
                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
                    <div class="form-group">
                        {!! Form::label('featured','Mark as Featured') !!}                        
                        {{ Form::checkbox('featured', 'true') }}                         
                    </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('tags','Tags') !!}
                        {!! Form::select('tags[]', $tags,$myTags,['class'=> 'form-control select-tag chosen-select','multiple']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Edit Video',['class'=>'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
                <div class="col-md-6">
                <div align="center" class="embed-responsive embed-responsive-16by9">
                @if($video->filename != '' && $video->video_link == '')
                    <video  class="embed-responsive-item" controls>
                        <source src="{{asset('videos/vid_'.$video->filename)}}" type="video/mp4">
                    </video>
                @else
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$video->video_link}}"></iframe>
                @endif
                </div>
            </div>
        <!-- /.row -->
        </div>
        <!-- /.row -->


@endsection

@section('js')
    <script>
        $(".select-tag").chosen({
            placeholder_text_multiple: "Select your tags"
        });
        $(".select-category").chosen({
            placeholder_text_single: "Select a category"
        });
    </script>
@endsection
