@extends('layouts.admin')
@section('title')
    New Video
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
            	{!! Form::open(['route' => 'admin.videos.store','method' => 'POST','files'=>'true','id'=>'photoPost']) !!}

                    <div class="form-group">
                        {!! Form::label('title','Title') !!}
                        {!! Form::text('title', null,['class'=> 'form-control','placeholder'=>'Type a title','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('title','Wich type of video you want to upload?') !!}
                        <br>
                        <div class="btn btn-danger youtube">Youtube Video</div>
                        <div class="btn btn-success normal">Normal Video</div>
                    </div>
                    <div class="form-group videolink">
                        {!! Form::label('video_link','Copy and Paste YouTube video ID') !!}

                        
                        {!! Form::text('video_link', null,['class'=> 'form-control','placeholder'=>'Type a Video ID']) !!}
                       <h4>Copy and Paste from YouTube ID : </h4>
                        <img src="{{asset('img/youtube.jpg')}}" alt="">
                    </div>
                    <div class="form-group videonormal">
                        {!! Form::label('videos','Upload your video') !!}

                        {!! Form::file('videos[]', array('multiple'=>true)) !!}
                        <br>
                        <div class="alert alert-warning">
                            <p>* Videos must be 10mb or less.</p>
                        </div>
                    </div>


                    <div class="form-group">
                        {!! Form::label('category_id','Category') !!}
                        {!! Form::select('category_id', $categories,null,['class'=> 'form-control select-category','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('subcategory_id','Sub-Category') !!}
                        {!! Form::select('subcategory_id', array(),null,['class'=> 'form-control','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('content','Content') !!}
                        {!! Form::textarea('content', null,['class' => 'textarea-content form-control','required']) !!}
                    </div>
                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
                    <div class="form-group">
                        {!! Form::label('featured','Mark as Featured') !!}                        
                        {{ Form::checkbox('featured', 'true') }}                         
                    </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('tags','Tags') !!}
                        {!! Form::select('tags[]', $tags,null,['class'=> 'form-control select-tag chosen-select','multiple']) !!}
                    </div>

            		<div class="form-group">
            			{!! Form::submit('Add Video',['class'=>'btn btn-primary']) !!}
            		</div>

            	{!! Form::close() !!}
            </div>
        </div>
        <!-- /.row -->


@endsection

@section('js')
    <script>

        $('#photoPost').submit(function(){
            var content=$('#content').val();
            if(parseInt(content.length) < 151){
                alert("The content must be max 150 characters");
                return false;
            }
        });


        $('.videonormal').hide();
        $('.videolink').hide();

        $('.youtube').on('click',function(e){
            $('.videolink').fadeIn();
            $('.videonormal').hide();
        });
        $('.normal').on('click',function(e){
            $('.videonormal').fadeIn();
            $('.videolink').hide();
        });
        $(".select-tag").chosen({
            placeholder_text_multiple: "Select your tags"
        });
        $(".select-category").chosen({
            placeholder_text_single: "Select a category"
        });

        $('#category_id').change(function () {
            sunCategory($(this).val());
        });

        var category_array=JSON.parse('<?php echo $subcategories; ?>');

        sunCategory("");

        function sunCategory(category_id) {

            if(category_id==""){
                var category_id=$('.select-category  option:first').val();
            }

            var cateArr=[];
            var html='';
            $('#subcategory_id').html("");
            for(var i=0;i<category_array.length;i++){
                if(category_array[i].category_id==category_id){
                    $('#subcategory_id').append('<option value="'+category_array[i].id+'">'+category_array[i].name+'</option>');
                }
            }
        }

    </script>
@endsection
