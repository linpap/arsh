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
                        {!! Form::select('category_id', $categories,$photo->category->id,['class'=> 'form-control select-category categories','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('subcategory_id','Sub-Category') !!}
                        {!! Form::select('subcategory_id', $subcategory,null,['class'=> 'form-control subcategories']) !!}
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
                        {!! Form::text('tags',$myTags,['class'=> 'form-control select-tag']) !!}
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
