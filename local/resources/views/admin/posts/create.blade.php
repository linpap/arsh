@extends('layouts.admin')
@section('title')
    New Post
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
            	{!! Form::open(['route' => 'admin.posts.store','method' => 'POST','files'=>'true','id'=>'formID']) !!}

                    <div class="form-group">
                        {!! Form::label('title','Title') !!}
                        {!! Form::text('title', null,['class'=> 'form-control','placeholder'=>'Type a title','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('title','Subtitle') !!}
                        {!! Form::text('subtitle', null,['class'=> 'form-control','placeholder'=>'Type a subtitle']) !!}
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

                    <div class="form-group">
                        {!! Form::label('featured_text','Quote Text') !!}
                        {!! Form::textarea('featured_text', null,['class' => 'textarea-content form-control']) !!}
                    </div>
                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
                    <div class="form-group">
                        {{ Form::checkbox('featured', 'true') }}
                        {!! Form::label('featured','Mark as Featured(Slider)') !!}&nbsp;&nbsp;


                        {{ Form::checkbox('featured_b', 'true') }}
                        {!! Form::label('featured','Mark as Featured(Box)') !!}

                    </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('photo_credit','Photo Credit') !!}
                        {!! Form::text('photo_credit', null,['class'=> 'form-control','placeholder'=>'Type  photo credit']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('caption','Caption') !!}
                        {!! Form::text('caption', null,['class'=> 'form-control','placeholder'=>'Type a caption']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('tags','Tags') !!}
                        {!! Form::select('tags[]', $tags,null,['class'=> 'form-control select-tag','multiple']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('images','Images') !!}

                        {!! Form::file('images[]', array('multiple'=>true)) !!}
                        {{--<div class="alert alert-warning">--}}
                            {{--<p>* Images must be 450px tall.</p>--}}
                        {{--</div>--}}
                    </div>

            		<div class="form-group">
            			{!! Form::submit('Add Post',['class'=>'btn btn-primary']) !!}
            		</div>

            	{!! Form::close() !!}
            </div>
        </div>
        <!-- /.row -->


@endsection



@section('js')

    <script>

        $('.textarea-content').trumbowyg({
            
        });

        $(".select-tag").chosen({
            placeholder_text_multiple: "Select your tags",
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
