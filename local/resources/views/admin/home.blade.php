@extends('layouts.admin')
@section('title','Dashboard')
@section('content')
<div class="container">
<div class="row">
        <div class="col-xs-12">
                    @if (session('status'))
              <div class="alert alert-success">
                  {{ session('status') }}
              </div>
          @endif
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">


          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-compose"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Number of Posts</span>
              <span class="info-box-number">{{$post_count}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class=" ion-ios-photos"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Number of Photos</span>
              <span class="info-box-number">{{$photo_count}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-videocam"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Number of Videos</span>
              <span class="info-box-number">{{$video_count}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-book"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">New of Ebooks</span>
              <span class="info-box-number">{{$ebook_count}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
</div>
@endsection
