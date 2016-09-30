<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Ebook;
use App\Tag;
use App\Post;
use App\Video;
use App\User;
use App\Image;
use App\Category;
use App\Navbar;
use App\Footer;
use App\Adv;

use App\Photo;
class FrontPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navbars = Navbar::orderBy('position','ASC')->get();
        $footers = Footer::orderBy('position','ASC')->get();
        $slider_posts = Post::orderBy('id','DESC')->where('status','approved')->paginate(5);
        $lastest_posts = Post::orderBy('id','DESC')->where('status','approved')->with('post_category')->paginate(5);
        $pagination= Post::orderBy('id','DESC')->where('status','approved')->paginate(10, ['*'], 'p');
        $featured_posts = Post::orderBy('id','DESC')->where('status','approved')->where('featured','true')->paginate(3);
        $lastest_videos = Video::orderBy('id','DESC')->where('status','approved')->paginate(3);
        $lastest_photos = Photo::orderBy('id','DESC')->where('status','approved')->paginate(4);
        $lastest_ebooks = Ebook::orderBy('id','DESC')->where('status','approved')->paginate(4);
        $categories = Category::all();
        $images = new Image();
        $featured_posts->each(function($post){
                $post->images->each(function($postimg){
                    $postimg->images;
                });
        });
        $slider_posts->each(function($post){
                $post->images->each(function($postimg){
                    $postimg->images;
                });
        });
        $lastest_photos->each(function($post){
                $post->images->each(function($postimg){
                    $postimg->images;
                });
                $post->user->each(function($post){
                    $post->user;
                });
        });
        $lastest_ebooks->each(function($post){
                $post->images->each(function($postimg){
                    $postimg->images;
                });
        });
        //dd($lastest_posts->items()[0]['user']);

        $advs = Adv::orderBy('position','DESC')->where('section','home')->get();

        $topHorizontalBanner="";
        $firstSidebarRight="";
        $secondSidebarRight="";
        $thirdSidebarVertical="";
        $bottomSquare="";
        $bottomHorizontal="";
        $topHorizontalBannerScript="";
        $firstSidebarRightScript="";
        $secondSidebarRightScript="";
        $thirdSidebarVerticalScript="";
        $bottomSquareScript="";
        $bottomHorizontalScript="";

         foreach($advs as $adv){
            if($adv->position == '0'){
                if($adv->image != ''){
                    $topHorizontalBanner = $adv->image;                    
                }else{
                    $topHorizontalBannerScript = $adv->script;
                }
            }elseif($adv->position == '1'){
                if($adv->image != ''){
                    $firstSidebarRight = $adv->image;                    
                }else{
                    $firstSidebarRightScript = $adv->script;
                }
            }elseif($adv->position == '2'){
                if($adv->image != ''){
                    $secondSidebarRight = $adv->image;                    
                }else{
                    $secondSidebarRightScript = $adv->script;
                }
            }elseif($adv->position == '3'){
                if($adv->image != ''){
                    $thirdSidebarVertical = $adv->image;                    
                }else{
                    $thirdSidebarVerticalScript = $adv->script;
                }
            }elseif($adv->position == '4'){
                if($adv->image != ''){
                    $bottomSquare = $adv->image;                    
                }else{
                    $bottomSquareScript = $adv->script;
                }
            }elseif($adv->position == '5'){
                if($adv->image != ''){
                    $bottomHorizontal = $adv->image;                    
                }else{
                    $bottomHorizontalScript = $adv->script;
                }
            }
        }
        
    
       
        return view('front.welcome')
        ->with('advs',$advs)
        ->with('topHorizontalBanner',$topHorizontalBanner)
        ->with('firstSidebarRight',$firstSidebarRight)
        ->with('secondSidebarRight',$secondSidebarRight)
        ->with('bottomSquare',$bottomSquare)
        ->with('thirdSidebarVertical',$thirdSidebarVertical)
        ->with('bottomHorizontal',$bottomHorizontal)
        ->with('topHorizontalBannerScript',$topHorizontalBannerScript)
        ->with('firstSidebarRightScript',$firstSidebarRightScript)
        ->with('secondSidebarRightScript',$secondSidebarRightScript)
        ->with('bottomSquareScript',$bottomSquareScript)
        ->with('thirdSidebarVerticalScript',$thirdSidebarVerticalScript)
        ->with('bottomHorizontalScript',$bottomHorizontalScript)
        ->with('slider_posts',$slider_posts)
        ->with('lastest_posts',$lastest_posts->items())
        ->with('featured_posts',$featured_posts->items())
        ->with('lastest_videos',$lastest_videos)
        ->with('lastest_photos',$lastest_photos)
        ->with('pagination',$pagination)
        ->with('navbars',$navbars)
        ->with('footers',$footers);
    }
    public function posts()
    {
        // Current page number (defaults to 1)
        $page = Input::get('page', 1);

        // Get 10 post according to page number, after the first 3
        $posts = Post::skip(3 + ($page - 1) * 10)->take(10)->get();

        // Create pagination
        $pagination = Paginator::make($posts->toArray(), Post::count(), 10);

        return View::make('posts', compact('posts', 'pagination'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
