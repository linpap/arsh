<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Laracasts\Flash\Flash;
use App\Photo;
use App\Tag;
use App\Image;
use App\Views;
use App\Subcategory;
use App\User;
use App\Video;
use App\Ebook;
use App\Post;
use App\Navbar;
use App\Footer;
use App\Adv;
use App\Sidebar;
use App\Category;
use Auth;
use Config;

class SubcategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->type == 'admin'){
            $subcategories = Subcategory::orderBy('id','DESC')->paginate(4);
           
            return view('admin.subcategories.index')->with('subcategories',$subcategories);
        }else{
            return redirect()->route('admin.home');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('id','DESC')->lists('name','id');
        $categories = Category::orderBy('id','DESC')->get();
        if(Auth::user()->type == 'admin'){
            return view('admin.subcategories.create')->with('categories',$categories);
        }else{
            return redirect()->route('admin.home');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cateObj = new Subcategory();
        $data= $cateObj::where('name',$request->all()['name'])->where('category_id',$request->all()['category_id'])->first();

        if (count($data)>0){
            Flash::success("<strong>Sub-Category Name Already Taken</strong>.");
            return redirect()->route('admin.subcategories.index');
        }

        $subcategory = new Subcategory($request->all());
        $subcategory->save();

        $category = Category::find($request['category_id']);
        $subcategory->category()->associate($category);
        Flash::success("Subcategory <strong>".$subcategory->name."</strong> was created.");
        return redirect()->route('admin.subcategories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcategory = Subcategory::find($id);
        $navbars = Navbar::orderBy('position','ASC')->get();
        $footers = Footer::orderBy('position','ASC')->get();
        $slider_posts = Post::orderBy('id','DESC')->where('status','approved')->where('category_id',$id)->limit(5)->get();
        $lastest_posts = Post::orderBy('id','DESC')->where('status','approved')->where('category_id',$id)->limit(5)->get();
        $featured_posts = Post::orderBy('id','DESC')->where('status','approved')->where('category_id',$id)->where('featured','true')->paginate(3);
        $lastest_videos = Video::orderBy('id','DESC')->where('status','approved')->where('category_id',$id)->limit(3)->get();
        $lastest_photos = Photo::orderBy('id','DESC')->where('status','approved')->where('category_id',$id)->limit(4)->get();
        $lastest_ebooks = Ebook::orderBy('id','DESC')->where('status','approved')->where('category_id',$id)->limit(4)->get();
        $subcategories = Subcategory::all();
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

        $advs = Adv::orderBy('position','DESC')->where('section','category')->get();

        $topHorizontalBanner="";
        $firstSidebarRight="";
        $secondSidebarRight="";
        $thirdSidebarVertical="";
        $bottomHorizontal="";
        $topHorizontalBannerScript="";
        $firstSidebarRightScript="";
        $secondSidebarRightScript="";
        $thirdSidebarVerticalScript="";
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
            }elseif($adv->position == '5'){
                if($adv->image != ''){
                    $bottomHorizontal = $adv->image;                    
                }else{
                    $bottomHorizontalScript = $adv->script;
                }
            }
        }
        

        return view('front.subcategories.show')
        ->with('subcategory',$subcategory)    
        ->with('topHorizontalBanner',$topHorizontalBanner)
        ->with('firstSidebarRight',$firstSidebarRight)
        ->with('secondSidebarRight',$secondSidebarRight)
        ->with('thirdSidebarVertical',$thirdSidebarVertical)
        ->with('bottomHorizontal',$bottomHorizontal)        
        ->with('topHorizontalBannerScript',$topHorizontalBannerScript)
        ->with('firstSidebarRightScript',$firstSidebarRightScript)
        ->with('secondSidebarRightScript',$secondSidebarRightScript)
        ->with('thirdSidebarVerticalScript',$thirdSidebarVerticalScript)
        ->with('bottomHorizontalScript',$bottomHorizontalScript)
        ->with('category',$subcategory)
        ->with('slider_posts',$slider_posts)
        ->with('lastest_posts',$lastest_posts)
        ->with('featured_posts',$featured_posts)
        ->with('lastest_videos',$lastest_videos)
        ->with('lastest_photos',$lastest_photos)
        ->with('navbars',$navbars)
        ->with('footers',$footers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->type == 'admin'){
            $categories = Category::orderBy('id','DESC')->get();
            $subcategory = Subcategory::find($id);
            return View('admin.subcategories.edit')->with('categories',$categories)->with('subcategory',$subcategory);
        }else{
            return redirect()->route('admin.home');
        }
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
        $cateObj = new Subcategory();

        $data= $cateObj::where('name',$request->all()['name'])->where('category_id',$request->all()['category_id'])->first();

        if (count($data)>0){
            Flash::success("<strong>Sub-Category Name Already Taken</strong>.");
            return redirect()->route('admin.subcategories.index');
        }


        $subcategory = Subcategory::find($id);
        $subcategory->fill($request->all());
        $subcategory->save();
        Flash::success("Subcategory was updated.");
        return redirect()->route('admin.subcategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->type == 'admin'){
        $subcategory = Subcategory::find($id);
        $subcategory->delete();
        Flash::error("Subcategory <strong>".$subcategory->name."</strong> was deleted.");
        return redirect()->route('admin.subcategories.index');
        }else{
            return redirect()->route('admin.home');
        }
    }

}
