@extends('layouts.admin')
@section('title')
    Edit Photo
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
                {!! Form::open(['route' => ['admin.photos.update',$photo->id],'method' => 'PUT','files'=>'true']) !!}

                    <div class="form-group">
                        {!! Form::label('title','Title') !!}
                        {!! Form::text('title', $photo->title,['class'=> 'form-control','placeholder'=>'Type a title','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('category_id','Category') !!}
                        {!! Form::select('category_id', $categories,$photo->category->id,['class'=> 'form-control select-category','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('photo_link','Photo Link') !!}
                        {!! Form::text('photo_link', $photo->photo_link,['class'=> 'form-control','placeholder'=>'Type photo download url','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('content','Content') !!}
                        {!! Form::textarea('content', $photo->content,['class' => 'textarea-content','required']) !!}
                    </div>
                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
                    <div class="form-group">
                        {!! Form::label('featured','Mark as Featured') !!}
                        @if($photo->featured == 'true')
                        {{ Form::checkbox('featured', 'true',true) }}
                        @else
                        {{ Form::checkbox('featured', 'true',false) }}
                        @endif      
                    </div>
                    @endif
                    <div class="form-group">
                        {!! Form::label('tags','Tags') !!}
                        {!! Form::select('tags[]', $tags,$myTags,['class'=> 'form-control select-tag','multiple','required']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('images','Images') !!}
                        {!! Form::file('images[]', array('multiple'=>true)) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Edit Photo',['class'=>'btn btn-primary']) !!}
                    </div>

                {!! Form::close() !!}
            </div>
            
            <!-- Photo Images -->
            <div class="col-md-6 type" data-type="photos">
                <h1>Images</h1>
                <hr class="count" data-count="{{count($photo->images)}}">
                @if(count($photo->images) > 0)  
                    <?php
                        $i=0;
                    ?>
                    @foreach($photo->images as $image)
                    <div class="col-xs-12">
                        <img src="{{asset('img/photos/thumbs').'/thumb_'.$image->name, '$photo->title'}}" alt="The Public Photo {{$photo->title}}">
                        <p class="col-xs-12" style="padding-left:0px; margin-top:10px;">
                            <a href="#" class="btn-delete btn btn-danger"  data-imgid="{{$image->id}}"><i class="fa fa-trash fa-2x"></i></a>
                        </p>
                    </div>
                    <hr>
                    @endforeach
                @else
                    <p>Not images found. Please add a new image.</p>  
                @endif
            </div>
        </div>
        <!-- /.row -->
        </div>
        <!-- /.row -->


@endsection

@section('js')

    <script>
        $('.textarea-content').trumbowyg({
            
        });
        $(".select-tag").chosen({
            placeholder_text_multiple: "Select your tags"
        });
        $(".select-category").chosen({
            placeholder_text_single: "Select a category"
        });
    </script>
@endsection
