<footer>
    <div class="footer">
        <br>
    <div class="col-lg-12 col-md-12 col-sm-12">
    @foreach($footers as $item)
    <a href="#" class="items" style="padding-left:10px; padding-right:20%; color:black;">{{$item->category()->first()->name}}</a>
    @endforeach
    <br>
    <a href="#" class="pull-left"><img src="{{asset('img/play_store.png')}}" width="auto" height="40px" alt="play store" style="margin-top:10px; margin-right:10px"></a>
    <a href="#" class="pull-left"><img src="{{asset('img/app_store.png')}}" width="auto" height="40px" alt="app store" style="margin-top:10px; "></a>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <hr style="margin-bottom:5px; margin-top:5px">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <p class="copy">Copyright &copy; The Public Post Ltd.</p>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <a href="#" class="pull-right"><img src="{{asset('img/Logo_footer.png')}}" width="auto" height="30px"></a>
        </div>
    </div>
    </div>
</footer>