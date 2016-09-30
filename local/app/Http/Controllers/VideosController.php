<?php

namespace App\Http\Controllers;

use App\Subcategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VideoRequest;
use Laracasts\Flash\Flash;
use App\Video;
use App\Tag;
use App\Image;
use App\Category;
use App\User;
use App\Navbar;
use App\Footer;
use App\Sidebar;
use App\Views;
use App\Adv;
use Auth;
use Config;
class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserPosts($id){
        $videos =  Video::orderBy('id','DESC')->where('user_id',$id)->paginate(5);
        $videos->each(function($videos){
            $videos->category;
            $videos->images;
            $videos->tags;
            $videos->user;
        });
        $user = User::find($id);
        return view('admin.videos.user')
        ->with('videos',$videos)->with('user',$user);
    }
    public function addView(Request $request,$id){        
        $ipAddress = '';


        // Check for X-Forwarded-For headers and use those if found
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ('' !== trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
            $ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            if (isset($_SERVER['REMOTE_ADDR']) && ('' !== trim($_SERVER['REMOTE_ADDR']))) {
                $ipAddress = trim($_SERVER['REMOTE_ADDR']);
            }
        }
        $isViewed= Views::where('ip',$ipAddress)->where('video_id',$id)->count();
        if($isViewed == 0){  
            $view = new Views();
            $view->video_id = $id;
            $view->ip=$ipAddress;
            $view->save();
            return response()->json(['msg'=>'success']);    
        }else{
            return response()->json(['msg'=>'error']); 
        }
     
        
    }
    public function index(Request $request)
    {
        if(Auth::user()->type != 'subscriber'){
            $videos= Video::Search($request->title)->orderBy('id','DESC')->where('user_id',Auth::user()->id)->paginate(5);
            $videos->each(function($videos){
                $videos->category;
                $videos->images;
                $videos->tags;
                $videos->user;
            });
            return view('admin.videos.index')
            ->with('videos',$videos);
        }else{
            Flash::error("You don't have permissions");
            return redirect()->route('admin.home');
        }
    }
    public function all(Request $request)
    {
        if(Auth::user()->type != 'subscriber'){
            $videos= Video::Search($request->title)->orderBy('id','DESC')->paginate(5);
            $videos->each(function($videos){
                $videos->category;
                $videos->images;
                $videos->tags;
                $videos->user;
            });
            return view('admin.videos.all')
            ->with('videos',$videos);
        }else{
            Flash::error("You don't have permissions");
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
        if(Auth::user()->type != 'subscriber'){
                $categories = Category::orderBy('name','ASC')->where('type','video')->lists('name','id');
                $sub_categories = Subcategory::orderBy('name','ASC')->get();
                $tags =Tag::orderBy('name','ASC')->lists('name','id');
                $videos = Video::orderBy('id','DESC')->paginate(4);
                return view('admin.videos.create')
                ->with('videos',$videos)
                ->with('categories',$categories)
                ->with('subcategories',$sub_categories)
                ->with('tags',$tags);
        }else{
            Flash::error("You don't have permissions");
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
        if(Auth::user()->type != 'subscriber'){
            if($request['video_link'] != '' && $request['videos'][0] != null){
                Flash::error('You have to select one type of video');
                return redirect()->back()->withInput();
            }
            if($request['video_link']){
                //if pass all the validations we add the video and the images                        
                $video = new Video($request->except('category_id','tags','subcategory_id'));
                $video->user_id = \Auth::user()->id;
               //associate category with video
                $category = Category::find($request['category_id']);
                $video->category()->associate($category);
                $video->subcategory_id=$request['subcategory_id'];
                $video->save();  
                //associate all tags for the video
                $video->tags()->sync($request->tags);                                
                Flash::success("Video <strong>".$video->title."</strong> was created.");
                return redirect()->route('admin.videos.index');

            }      
            if($request->hasFile('videos')){
                //Check if the images are null or not.
                $fileArray0 = array('videos' => $request->file('videos')[0]);
                // Tell the validator that this file should be required
                $rules0 = array(
                    'videos' => 'required'//max 10000kb
                );
                // Now pass the input and rules into the validator
                $validator0 = \Validator::make($fileArray0, $rules0);       
                if($validator0->fails()){
                   return redirect()->back()->withErrors($validator0)->withInput();
                }else{
                    //Process Form Images
                    if ($request->hasFile('videos')) {
                        $files = $request->file('videos');
                        foreach($files as $file){             

                                //Slider
                                $filename = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $vidname = date('His').'_'.$filename;
                                // Build the input for validation
                                $fileArray = array('videos' => $file);
                                // Tell the validator that this file should be an image
                                $rules = array(
                                    'videos' => 'max:700000'//max 10000kb
                                );
                                // Now pass the input and rules into the validator
                                $validator = \Validator::make($fileArray, $rules);
                                
                                if($validator->fails()){
                                    
                                    return redirect()->back()->withErrors($validator)->withInput();
                                }else{
                                    //if pass all the validations we add the video and the images                        
                                    $video = new Video($request->except('category_id','tags','subcategory_id'));
                                    $video->user_id = \Auth::user()->id;
                                   //associate category with video
                                    $category = Category::find($request['category_id']);
                                    $video->category()->associate($category);
                                    $video->subcategory_id=$request['subcategory_id'];
                                    $video->filename = $vidname;
                                    $video->save();  
                                    //associate all tags for the video
                                    $video->tags()->sync($request->tags);
                                   
                                    $destinationPath = 'videos/';
                                    $file->move($destinationPath,'vid_'.$vidname);   
                                }        
                        }//endforeach                                
                        Flash::success("Video <strong>".$video->title."</strong> was created.");
                        return redirect()->route('admin.videos.index');
                    }
                }

            }
        }else{
                Flash::error("You don't have permissions");
                return redirect()->route('admin.home');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $navbars = Navbar::orderBy('position','ASC')->get();
        $footers = Footer::orderBy('position','ASC')->get();
        $video = Video::where('id',$id)->first();
   
        $video->tags()->get();
        $comments = $video->comments()->orderBy('id','DESC')->get();     
        $comments->each(function($comments){

                $comments->user;
         
        });
        $categories = Category::orderBy('name','DESC')->paginate(15);
        $related_videos = Video::orderBy('id','DESC')->paginate(3);

        $advs = Adv::orderBy('position','DESC')->where('section','video_single')->get();

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
        $thirdSidebarVertical ="";
        $thirdSidebarVerticalScript="";
    
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
            }elseif($adv->position == '5'){
                if($adv->image != ''){
                    $bottomHorizontal = $adv->image;                    
                }else{
                    $bottomHorizontalScript = $adv->script;
                }
            }
        }

        return view('front.videos.show')
        ->with('topHorizontalBanner',$topHorizontalBanner)
        ->with('thirdSidebarVerticalScript',$thirdSidebarVerticalScript)
        ->with('thirdSidebarVertical',$thirdSidebarVertical)
        ->with('firstSidebarRight',$firstSidebarRight)
        ->with('secondSidebarRight',$secondSidebarRight)
        ->with('bottomHorizontal',$bottomHorizontal)
        ->with('topHorizontalBannerScript',$topHorizontalBannerScript)
        ->with('firstSidebarRightScript',$firstSidebarRightScript)
        ->with('secondSidebarRightScript',$secondSidebarRightScript)
        ->with('bottomHorizontalScript',$bottomHorizontalScript)
        ->with('related_videos',$related_videos)
        ->with('categories',$categories)
        ->with('comments',$comments)
        ->with('video',$video)
        ->with('navbars',$navbars)
        ->with('footers',$footers);
    }
    public function showAll(Request $request)
    {
        $sidebars = Sidebar::orderBy('position','ASC')->get();
        $navbars = Navbar::orderBy('position','ASC')->get();
        $footers = Footer::orderBy('position','ASC')->get();
        $video = Video::orderBy('id','DESC')->first();

        $advs = Adv::orderBy('position','DESC')->where('section','video')->get();

        $topHorizontalBanner="";
        $firstSidebarRight="";
        $secondSidebarRight="";
        $rightSingle="";
        $topHorizontalBannerScript="";
        $firstSidebarRightScript="";
        $secondSidebarRightScript="";
        $rightSingleScript="";
        $thirdSidebarVertical ="";
        $thirdSidebarVerticalScript ="";
    
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
            }elseif($adv->position == '7'){
                if($adv->image != ''){
                    $rightSingle = $adv->image;                    
                }else{
                    $rightSingleScript = $adv->script;
                }
            }
        }
     
        $related_videos = Video::orderBy('id','DESC')->paginate(3);
        return view('front.videos.index')
        ->with('related_videos',$related_videos)
        ->with('topHorizontalBanner',$topHorizontalBanner)
        ->with('firstSidebarRight',$firstSidebarRight)
        ->with('secondSidebarRight',$secondSidebarRight)
        ->with('rightSingle',$rightSingle)
        ->with('thirdSidebarVertical',$thirdSidebarVertical)
        ->with('thirdSidebarVerticalScript ',$thirdSidebarVerticalScript)
        ->with('topHorizontalBannerScript',$topHorizontalBannerScript)
        ->with('firstSidebarRightScript',$firstSidebarRightScript)
        ->with('secondSidebarRightScript',$secondSidebarRightScript)
        ->with('rightSingleScript',$rightSingleScript)
        ->with('video',$video)
        ->with('navbars',$navbars)
        ->with('sidebars',$sidebars)
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
        $video = Video::find($id); 
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $video->user()->first()->id == Auth::user()->id){            
            $categories = Category::orderBy('name','DESC')->where('type','video')->lists('name','id');
            $tags = Tag::orderBy('name','DESC')->lists('name','id');
            $images = new Image();
            $myTags = $video->tags->lists('id')->ToArray(); //give me a array with only the tags id.
            return View('admin.videos.edit')->with('video',$video)->with('categories',$categories)->with('tags',$tags)->with('myTags',$myTags);            
        }else{
            Flash:error("You don't have permissions to do that.");
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
        if(Auth::user()->type != 'subscriber'){
            $video =Video::find($id);
            if($request->featured){
                $video->featured = 'true';
            }else{
                $video->featured = 'false';
            }
            $video->fill($request->all());
            $video->user_id = \Auth::user()->id;
            
            $video->save();
            $video->tags()->sync($request->tags);
            Flash::success('Video <strong>'.$video->title.'</strong> was updated.');
            return redirect()->back();
        }else{
                Flash::error("You don't have permissions");
                return redirect()->route('admin.home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $video->user()->first()->id == Auth::user()->id){
            $video = Video::find($id);

            $myvideo = "videos/vid_".$video->filename;
        \File::delete($myvideo);
            $video->delete();
            Flash::error("Video <strong>".$video->name."</strong> was deleted.");
            return redirect()->route('admin.videos.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.videos.index');
        }            
      
    }
    
    public function approve($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $video = Video::find($id);
            $video->status='approved';
            $video->save();
            Flash::success("Video <strong>".$video->title."</strong> was approved.");
            return redirect()->route('admin.videos.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
    public function suspend($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $video = Video::find($id);
            $video->status='suspended';
            $video->save();
            Flash::warning("Video <strong>".$video->title."</strong> was suspended.");
            return redirect()->route('admin.videos.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
    public function destroyVideo(Request $request,$id)
    {
        $image = Image::find($id);

        $myimage = "img/".$type."/slider_".$image->name;
        $myimageThumb = "img/".$type."/thumbs/thumb_".$image->name;
        
        \File::delete([
            $myimage,
            $myimageThumb
        ]);
        $image->delete();
        return response()->json(['msg'=>'success']);
    }
}
