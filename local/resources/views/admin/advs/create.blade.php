@extends('layouts.admin')
@section('title')
    New Advertisement
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
                {!! Form::open(['route' => 'admin.advs.store','method' => 'POST','files'=>'true']) !!}

                    
                        <div class="form-group">
                            {!! Form::label('section','Section') !!}
                            {!! Form::select('section',[''=>'Select section','post_single'=> 'Post Single','ebook_single'=> 'Ebook Single','photo_single'=> 'Photo Single','video_single' => 'Video Single','video' => 'Video Page','photo' => 'Photo Page','video' => 'Video Page','ebook' => 'Ebook Page','home' => 'Home Page','archive' => 'Archive Page','category' => 'Category Page','profile' => 'Profile Page'],null,['class'=> 'form-control section','required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('position','Position') !!}
                            {!! Form::select('position', array(''=> 'Select Position',0 => 'Horizontal Top (732px x 94px)',1 => 'Sidebar First (300px x 250px)',2 => 'Sidebar Second (300px x 250px) ',3 => 'Sidebar Vertical Four (300px x 600px)',4 => 'Bottom Square (426px x 350px) ',5 => 'Horizontal Bottom(732px x 94px)',6 => 'Horizontal Bottom Single(600px x 100px)',7 => 'Square Right Photo or Video or Post Page(150px x 300px)'),null,['class'=> 'form-control select-category position','required']) !!}
                        </div>

                    <div class="form-group">
                        {!! Form::label('title','Wich type of video you want to upload?') !!}
                        <br>
                        <div class="btn btn-danger script">Ad Script</div>
                        <div class="btn btn-success normal">Normal Ad</div>
                    </div>
                    <div class="normaladvertisement">
                        <div class="form-group">
                            {!! Form::label('image','Image') !!}

                            {!! Form::file('image') !!}
                        </div>
                    </div>
                    <div class="scriptadvertisement">
                        {!! Form::label('script','Copy and paste here your script') !!}
                        {!! Form::textarea('script', null,['class' => 'form-control','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Add Advertisment',['class'=>'btn btn-primary']) !!}
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.row -->


@endsection

@section('js')
    <script> 
        //hide all the possible position of advertisements.               
        $(".position option[value='0']").hide();
        $(".position option[value='1']").hide();                
        $(".position option[value='2']").hide();
        $(".position option[value='3']").hide();                
        $(".position option[value='4']").hide();
        $(".position option[value='5']").hide();
        $(".position option[value='6']").hide();
        $(".position option[value='7']").hide();

        //Check for section changes and change position values foreach type of section.
        $('.section').on('change',function(){

            if(this.value == 'photo_single' || this.value == 'video_single'|| this.value == 'post_single'){ 
               //if photo single selected show this type of advs.               
                $(".position option[value='0']").show();
                $(".position option[value='1']").show();                
                $(".position option[value='2']").show(); 
                $(".position option[value='5']").show();
            }
            if(this.value == 'photo' || this.value == 'video'){  
                //if video page or photo page show this type of advs.               
                $(".position option[value='0']").show();
                $(".position option[value='1']").show();                
                $(".position option[value='2']").show();                
                $(".position option[value='3']").show();
                $(".position option[value='7']").show();
            }
            if(this.value == 'ebook'){  //if ebook single page show this type of advs.               
                $(".position option[value='0']").show();
            }
            if(this.value == 'archive'){               
                $(".position option[value='0']").show();
                $(".position option[value='1']").show();                
                $(".position option[value='2']").show();                
                $(".position option[value='3']").show();                
            }
            if(this.value == 'home' || this.value == 'profile' || this.value == 'category'){  
                $(".position option[value='0']").show();
                $(".position option[value='1']").show();                
                $(".position option[value='2']").show();                
                $(".position option[value='3']").show();
                $(".position option[value='4']").show();
                $(".position option[value='5']").show();
            }
        });
        $('.normaladvertisement').hide();
        $('.scriptadvertisement').hide();

        $('.normal').on('click',function(e){
            $('.normaladvertisement').fadeIn();
            $('.scriptadvertisement').hide();
        });
        $('.script').on('click',function(e){
            $('.scriptadvertisement').fadeIn();
            $('.normaladvertisement').hide();
        });
    </script>
@endsection
