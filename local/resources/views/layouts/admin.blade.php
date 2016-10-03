<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>The Public Post | @yield('title')</title>
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css')}}">
    <!-- iCheck -->
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('dist/css/daterangepicker.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/js/ui/trumbowyg.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/css/chosen.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/css/notie.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="app-layout hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  @include('layouts.partials.back.navbar')
  @include('layouts.partials.back.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('title')
        <small>Control panel</small>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
    <div class="row">
      <div class="col-xs-6">
          @include('flash::message')
      </div>
    </div>
      <div class="clearfix"></div>
      @yield('content')
    </section>
    <!-- /.content -->
  </div>    
</div>
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <!-- jQuery 2.2.3 -->
    <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script>
    $(function(){
    $('.treeview a').filter(function(){return this.href==location.href}).parent().addClass('active').siblings().removeClass('active');
      $('.treeview').click(function(){
        $(this).parent().addClass('active').siblings().removeClass('active')  
      })
    })

    </script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{{ asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{ asset('plugins/morris/morris.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <!-- jvectormap -->
    <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/knob/jquery.knob.js')}}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{ asset('plugins/fastclick/fastclick.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/app.min.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js')}}"></script>
    <script src="{{ asset('dist/js/trumbowyg.min.js')}}"></script>
    <script src="{{ asset('dist/js/chosen.jquery.min.js')}}"></script>

    <script src="{{ asset('dist/js/jquery.tablesorter.js')}}"></script>
    <script src="{{ asset('dist/js/moment.min.js')}}"></script>
    <script src="{{ asset('dist/js/daterangepicker.js')}}"></script>
    <script src="{{ asset('dist/js/notie.js')}}"></script>
    
    <script>    
        $('.textarea-content').trumbowyg({
            
        });
        $('#flash-overlay-modal').modal();
        $("#myTable").tablesorter();
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script>
    //user points
    var userid = $('.user-name').data('user');
    $.ajax({
        
        url: '{{ url('/points/getUserPoints') }}'+ '/' + userid,
        type: 'GET',
        success: function(data) {
            console.log('USER POINTS');
            $(".userpoints").text(data);
        }
    });
        if (window.location.hash == '#_=_'){
            history.replaceState 
                ? history.replaceState(null, null, window.location.href.split('#')[0])
                : window.location.hash = '';
        }
        //delete images ajax request
        $('.btn-delete').on('click', function(e) {
            var count = $('.count').data('count');
            if(count == 1){
                notie.alert('error', "আপনি একটি পোস্ট থেকে সব ইমেজ মুছে ফেলতে পারবেন না . তাদের অন্তত এক ত্যাগ.", 4.5)
            }else{
                var myThis = $(this).parent().parent();
                var imgid = $(this).data('imgid');
                var vidid = $(this).data('vidid');
                var type = $('.type').data('type');
                //if image delete
                if(imgid != ''){
                notie.confirm('আপনি যে কাজ করতে চান আপনি কি নিশ্চিত?', 'হাঁ', 'বাতিল', function() {
                    notie.alert(1, 'ঠিক আছে, দূর', 2)

                    $.ajax({
                        url: '{{ url('/admin/images/destroyImage') }}' + '/' + type + '/' + imgid,
                        type: 'DELETE',
                        data:{_token:token,id:imgid,type:type},
                        success: function(msg) {
                            console.log(msg['msg']);
                            
                            $(myThis).fadeOut(150);
                        }
                    });
                });
                }else{ 
                    //if video delete 
                    console.log('video delete');               
                    notie.confirm('আপনি যে কাজ করতে চান আপনি কি নিশ্চিত?', 'হাঁ', 'বাতিল', function() {
                        notie.alert(1, 'ঠিক আছে, দূর', 2)

                        $.ajax({
                            url: '{{ url('/admin/videos/destroyVideo') }}' + '/' + type + '/' + imgid,
                            type: 'DELETE',
                            data:{_token:token,id:imgid,type:type},
                            success: function(msg) {
                                console.log(msg['msg']);
                                
                                $(myThis).fadeOut(150);
                            }
                        });
                    });
                }

            }
        });

        $('.delete').on('click',function(e){
            var count = $('.count').data('count');
            if(count == 3){
                notie.alert('আপনি এই মুছতে পারবেন না কারণ আমরা তিন শ্রমিক প্রয়োজন. দয়া করে তাদের কিছু সম্পাদনা কিন্তু আপনি তিনটি ছেড়ে চলে যেতে হবে.');
            }else{
            e.preventDefault();
                notie.confirm('আপনি যে কাজ করতে চান আপনি কি নিশ্চিত?', 'হাঁ', 'বাতিল', function() {
                    window.location.href=$('.delete').attr('href');                    
                });                
            }
        });

        $('.deleteNormal').on('click',function(e){
                notie.confirm('আপনি যে কাজ করতে চান আপনি কি নিশ্চিত?', 'হাঁ', 'বাতিল', function() {
                                       
                });  
        });
    </script>
    
    @yield('js')
</body>
</html>
