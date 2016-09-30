@extends('layouts.admin')
@section('title')
    Edit Ebook
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
                {!! Form::open(['route' => ['admin.ebooks.update',$ebook->id],'method' => 'PUT','files'=>'true']) !!}

                    <div class="form-group">
                        {!! Form::label('title','Title') !!}
                        {!! Form::text('title', $ebook->title,['class'=> 'form-control','placeholder'=>'Type a title','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('category_id','Category') !!}
                        {!! Form::select('category_id', $categories,$ebook->category->id,['class'=> 'form-control select-category','required']) !!}
                    </div>
                    @if($ebook->ebook_link != '')
                    <div class="form-group">
                        {!! Form::label('ebook_link','Ebook Link') !!}
                        {!! Form::text('ebook_link', $ebook->ebook_link,['class'=> 'form-control','placeholder'=>'Type ebook download url','required']) !!}
                    </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('content','Content') !!}
                        {!! Form::textarea('content', $ebook->content,['class' => 'textarea-content','required']) !!}
                    </div>
                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
                    <div class="form-group">
                        {!! Form::label('featured','Mark as Featured') !!}
                        @if($ebook->featured == 'true')
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
                        {!! Form::submit('Edit Ebook',['class'=>'btn btn-primary']) !!}
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
