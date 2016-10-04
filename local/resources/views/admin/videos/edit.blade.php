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
                        {!! Form::select('category_id', $categories,$video->category->id,['class'=> 'form-control select-category categories','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('subcategory_id','Sub-Category') !!}
                        {!! Form::select('subcategory_id', $subcategory,null,['class'=> 'form-control subcategories']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('content','Content') !!}
                        {!! Form::textarea('content', $video->content,['class' => 'textarea-content form-control','required']) !!}
                    </div>
                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
                    <div class="form-group">
                        {!! Form::label('featured','Mark as Featured') !!}
                        @if($video->featured == 'true')
                        {{ Form::checkbox('featured', 'true',true) }}
                        @else
                        {{ Form::checkbox('featured', 'true',false) }}
                        @endif                          
                    </div>
                    @endif
                    
                    <div class="form-group">
                        {!! Form::label('tags','Tags') !!}
                        {!! Form::text('tags',$myTags,['class'=> 'form-control select-tag']) !!}
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
        $(".select-category").chosen({
            placeholder_text_single: "Select a category"
        });    
            //initalize subcategories from category.
        $.ajax({
                
                url: '{{ url('admin/subcategories/getfromcategory') }}' + '/' + $('.categories').val(),
                type: 'GET',
                success: function(data)   {
                    $.each( data['data'], function( index, value ){                       
                    $('.subcategories').append('<option value="'+value['id']+'">'+value['name']+'</option>');
                    });
                }
        });

         $('.categories').on('change',function(){
            console.log('CATEGORY ID ' + this.value);
            $('.subcategories').html('');
            var catid = this.value;
            //search subcategories from category.
            $.ajax({
                
                url: '{{ url('admin/subcategories/getfromcategory') }}' + '/' + catid,
                type: 'GET',
                success: function(data)   {
                    $.each( data['data'], function( index, value ){
                        console.log(value['id']);
                    $('.subcategories').append('<option value="'+value['id']+'">'+value['name']+'</option>');
                    });
                }
            });
         });
    </script>
@endsection
