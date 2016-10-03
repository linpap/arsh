@extends('layouts.admin')
@section('title')
    Create Notification
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
                {!! Form::open(['route' => ['admin.rightblocks.store'],'method' => 'POST','files'=>'true']) !!}

                    <div class="form-group">
                        {!! Form::label('title','Title') !!}
                        {!! Form::text('title', null,['class'=> 'form-control','placeholder'=>'Type a description','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description','Description') !!}
                        {!! Form::text('description', null,['class'=> 'form-control','placeholder'=>'Type a description','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('type','Type') !!}
                        {!! Form::select('type',[''=>'Select section','post_single'=> 'Post Single','ebook_single'=> 'Ebook Single','photo_single'=> 'Photo Single','video_single' => 'Video Single','video' => 'Video Page','photo' => 'Photo Page','video' => 'Video Page','ebook' => 'Ebook Page','home' => 'Home Page','archive' => 'Archive Page','category' => 'Category Page','profile' => 'Profile Page'],null,['class'=> 'form-control section','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Create Block',['class'=>'btn btn-primary']) !!}
                    </div>

                {!! Form::close() !!}
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