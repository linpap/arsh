<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Ebook;
use App\Tag;
use App\Post;
use App\Video;
use App\User;
use App\Image;
use App\Category;
use App\Photo;
use Auth;
use Config;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        $post_count = count($posts);
        $videos = Video::all();
        $video_count = count($videos);
        $ebooks = Ebook::all();
        $ebook_count = count($ebooks);
        $photos = Photo::all();
        $photo_count = count($photos);
        return view('admin.home')
        ->with('post_count',$post_count)
        ->with('video_count',$video_count)
        ->with('photo_count',$photo_count)
        ->with('ebook_count',$ebook_count)
        ;
    }
    public function front()
    {
        $slider_posts = Post::orderBy('id','DESC')->paginate(5);
        $lastest_posts = Post::orderBy('id','DESC')->paginate(5);
        $featured_posts = Post::orderBy('id','DESC')->paginate(5);
      
        $lastest_videos = Video::orderBy('id','DESC')->paginate(3);
        $lastest_photos = Photo::orderBy('id','DESC')->paginate(4);
        return view('front.welcome')
        ->with('slider_posts',$slider_posts)
        ->with('lastest_posts',$lastest_posts)
        ->with('featured_posts',$featured_posts)
        ->with('lastest_videos',$lastest_videos)
        ->with('lastest_photos',$lastest_photos);
    }
}