<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PostRequest;
use Laracasts\Flash\Flash;
use App\Post;
use App\Tag;
use App\Image;
use App\Category;
use App\User;
use App\Photo;
use App\Comment;
use App\Navbar;
use App\Footer;
use App\Sidebar;
use App\Rightblock;
use App\Views;
use App\Adv;
use App\Subcategory;
use Auth;
use Config;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addShare(Request $request,$id,$shares){
        $post = Post::find($id);
        $real_shares= $post->shares;
        if($real_shares == $shares && $shares == 0){
            return response()->json(['msg'=>'error']);   
        }else{
            $post->shares = $shares;
            $post->save();
            return response()->json(['msg'=>'success']);
        }
    }
    public function getUserPosts($id){
        $posts =  Post::orderBy('id','DESC')->where('user_id',$id)->paginate(20);
        $posts->each(function($posts){
            $posts->category;
            $posts->images;
            $posts->tags;
            $posts->user;
        });
        $user = User::find($id);
        return view('admin.posts.user')
        ->with('posts',$posts)->with('user',$user);
    }
    public function addView(Request $request,$id){        
        $ipAddress = '';

        $post = Post::find($id);
        $points=$post->points;


        // Check for X-Forwarded-For headers and use those if found
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ('' !== trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
            $ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            if (isset($_SERVER['REMOTE_ADDR']) && ('' !== trim($_SERVER['REMOTE_ADDR']))) {
                $ipAddress = trim($_SERVER['REMOTE_ADDR']);
            }
        }
        $isViewed= Views::where('ip',$ipAddress)->where('post_id',$id)->count();
        if($isViewed == 0){  
            $view = new Views();
            $view->post_id = $id;
            $points = $points + 1;
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
            $posts= Post::Search($request->title)->orderBy('id','DESC')->where('user_id',Auth::user()->id)->paginate(20);
            $posts->each(function($posts){
                $posts->category;
                $posts->images;
                $posts->tags;
                $posts->user;
            });
            return view('admin.posts.index')
            ->with('posts',$posts);
        }else{
            Flash::error("You don't have permissions");
            return redirect()->route('admin.home');
        }
    }
    public function all(Request $request)
    {
        if(Auth::user()->type != 'subscriber'){
            $posts= Post::Search($request->title)->orderBy('id','DESC')->paginate(20);
            $posts->each(function($posts){
                $posts->category;
                $posts->images;
                $posts->tags;
                $posts->user;
            });
            return view('admin.posts.all')
            ->with('posts',$posts);
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
                $categories = Category::orderBy('name','ASC')->where('type','post')->lists('name','id');
                $subcategories = Subcategory::orderBy('name','ASC')->lists('name','id');
                $posts = Post::orderBy('id','DESC')->paginate(4);
                return view('admin.posts.create')
                ->with('posts',$posts)
                ->with('subcategories',$subcategories)
                ->with('categories',$categories);
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
    public function store(PostRequest $request)
    {
        if(Auth::user()->type != 'subscriber'){
            //Check if the images are null or not.
            $fileArray0 = array('images' => $request->file('images')[0]);
            // Tell the validator that this file should be required
            $rules0 = array(
                'images' => 'required'//max 10000kb
            );
            // Now pass the input and rules into the validator
            $validator0 = \Validator::make($fileArray0, $rules0);       
            if($validator0->fails()){
               return redirect()->back()->withErrors($validator0)->withInput();
            }else{
            //Process Form Images
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach($files as $file){             

                        //Slider
                        $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $picture = date('His').'_'.$filename;
                        //make images sliders
                        $image=\Image::make($file->getRealPath()); //Call image library installed.
                        // Build the input for validation
                        $fileArray = array('images' => $file);
                        // Tell the validator that this file should be an image
                        $rules = array(
                            'images' => 'dimensions:min_width=*,min_height=*'//max 10000kb
                        );
                        // Now pass the input and rules into the validator
                        $validator = \Validator::make($fileArray, $rules);
                        
                        if($validator->fails()){
                            
                            return redirect()->back()->withErrors($validator)->withInput();
                        }else{
                        //if pass all the validations we add the post and the images 
                            
                            $tags = explode(',', $request->tags);
                            if(count($tags) > 5){
                                Flash::error('Maximun 5 tags per post. Please delete some tag.');
                            return redirect()->back()->withInput();

                            }
                            $post = new Post($request->except('images','category_id','tags'));
                            $post->user_id = \Auth::user()->id;
                           //associate category with post
                            $category = Category::find($request['category_id']);
                            $post->category()->associate($category);
                            $post->sub_title=$request['subtitle'];
                            $post->subcategory_id=$request['subcategory_id'];
                            if($request->featured){
                                $post->featured = 'true';
                            }else{
                                $post->featured = 'false';
                            }
                            if($request->featured_b){
                                $post->featured_b= 'true';
                            }else{
                                $post->featured_b = 'false';
                            }
             
                            $post->photo_credit=$request['photo_credit'];
                            $post->caption=$request['caption'];
                            $post->save();
                            //associate all tags for the post
                            foreach($tags as $tag){
                                //create new tags exploding the commas.
                                $newtag =\DB::table('post_tag')->insert([
                                    ['post_id' =>$post->id,'tag_text' => $tag]
                                ]);                                
                            }

                            $destinationPath = 'img/posts/';
                            $image->resize(null,450, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $image->save($destinationPath.'slider_'.$picture);
                            // Thumbnails
                            $image2=\Image::make($file->getRealPath()); //Call immage library installed.      
                            //make images thumbnails                        
                            $thumbPath ='img/posts/thumbs/';
                            $image2->resize(100, 100);
                            $image2->save($thumbPath.'thumb_'.$picture);
                            //save image information on the db.
                            $imageDb = new Image();
                            $imageDb->name = $picture;
                            $imageDb->post()->associate($post);
                            $imageDb->save();       
                        }        
                }
            }
            Flash::success("Post <strong>".$post->title."</strong> was created.");
            return redirect()->route('admin.posts.index');
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
    public function show($id)
    {
        $navbars = Navbar::orderBy('position','ASC')->get();
        $sidebars = Sidebar::orderBy('position','ASC')->get();
        $footers = Footer::orderBy('position','ASC')->get();
        $post = Post::where('id',$id)->first();
        $comments = $post->comments()->orderBy('id','DESC')->get();
        $myTags = \DB::table('post_tag')->where('post_id',$id)->lists('tag_text');
   
        $comments->each(function($comments){

                $comments->user;
         
        });
        $categories = Category::orderBy('name','DESC')->paginate(15);
        $related_posts = Post::orderBy('id','DESC')->paginate(3);
        $related_photos = Photo::orderBy('id','DESC')->paginate(3);

        $advs = Adv::orderBy('position','DESC')->where('section','post_single')->get();

        $topHorizontalBanner="";
        $firstSidebarRight="";
        $secondSidebarRight="";
        $thirdSidebarRight="";
        $bottomHorizontal="";
        $thirdSidebarVerticalScript="";
        $topHorizontalBannerScript="";
        $firstSidebarRightScript="";
        $secondSidebarRightScript="";
        $bottomHorizontalScript="";
        $thirdSidebarVertical=""; 
    
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
        
        $rightblock = Rightblock::where('type','post_single')->first();
        return view('front.posts.show')
        ->with('rightblock',$rightblock)
        ->with('myTags',$myTags)
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
        ->with('related_photos',$related_photos)
        ->with('related_posts',$related_posts)
        ->with('categories',$categories)
        ->with('comments',$comments)
        ->with('post',$post)
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
        $post = Post::find($id); 
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $post->user()->first()->id == Auth::user()->id){            
            $categories = Category::orderBy('name','DESC')->where('type','post')->lists('name','id');
            $tags = Tag::orderBy('name','DESC')->lists('name','id');
            $images = new Image();
            $post->images->each(function($post){
                $post->images;
            });
            $category = Category::where('id',$post->category_id)->lists('name','id');
            $subcategory = Subcategory::where('category_id',$post->category_id)->lists('name','id');
            $myTags = \DB::table('post_tag')->where('post_id',$id)->lists('tag_text');
            $myTags = implode(',',$myTags);
            return View('admin.posts.edit')->with('post',$post)->with('categories',$categories)->with('myTags',$myTags)->with('subcategory',$subcategory)->with('category',$category);            
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
    public function update(PostRequest $request, $id)
    {
        if(Auth::user()->type != 'subscriber'){           
            $tags = explode(',', $request->tags);
            if(count($tags) > 5){
                Flash::error('Maximun 5 tags per post. Please delete some tag.');
            return redirect()->back()->withInput();
                
            }
            $post =Post::find($id);
            $category = Category::where('id',$post->category_id)->lists('name','id');
            $post->category()->associate($category);
            $post->sub_title=$request['subtitle'];
            $post->subcategory_id=$request['subcategory_id'];
            $post->photo_credit=$request['photo_credit'];
            $post->caption=$request['caption'];
            if($request->featured){
                $post->featured = 'true';
            }else{
                $post->featured = 'false';
            }
            if($request->featured_b){
                $post->featured_b= 'true';
            }else{
                $post->featured_b = 'false';
            }
            $post->fill($request->all());
            $post->user_id = \Auth::user()->id;
            
            $post->save();
            //avoid tag duplication....
            $delete = \DB::table('post_tag')->where('post_id',$id)->delete();        
            //associate all tags for the post
            foreach($tags as $tag){
            //add new tags if exists...too.
            $newtag =\DB::table('post_tag')->insert([
                ['post_id' =>$post->id,'tag_text' => $tag]
            ]);                                
            }

            $picture = '';

            //Process Form Images
            if ($request->hasFile('images')) {
                $files = $request->file('images');

                foreach($files as $file){            

                        //Slider
                        $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $picture = date('His').'_'.$filename;
                        //make images sliders
                        $image=\Image::make($file->getRealPath()); //Call image library installed.
                        // Build the input for validation
                        $fileArray = array('img' => $file);
                        // Tell the validator that this file should be an image
                        $rules = array(
                            'img' => 'dimensions:min_width=*,min_height=450'//max 10000kb
                        );
                        // Now pass the input and rules into the validator
                        $validator = \Validator::make($fileArray, $rules);
                       
                        if($validator->fails()){     
                             Flash('* Images must be 450px tall.','danger');         
                             return redirect()->back();
                        }else{
                            $destinationPath = 'img/posts/';
                            $image->resize(null,450, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $image->save($destinationPath.'slider_'.$picture);
                            // Thumbnails
                            $image2=\Image::make($file->getRealPath()); //Call immage library installed.      
                            //make images thumbnails                        
                            $thumbPath ='img/posts/thumbs/';
                            $image2->resize(100, 100);
                            $image2->save($thumbPath.'thumb_'.$picture);
                            //save image information on the db.
                            $imageDb = new Image();
                            $imageDb->name = $picture;
                            $imageDb->post()->associate($post);
                            $imageDb->save();       
                        }
                }
            }
            Flash::success('Post <strong>'.$post->title.'</strong> was updated.');
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
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $post->user()->first()->id == Auth::user()->id){
            $post = Post::find($id);
            $post->delete();
            Flash::error("Post <strong>".$post->name."</strong> was deleted.");
            return redirect()->route('admin.posts.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.posts.index');
        }            
      
    }
    
    public function approve($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $post = Post::find($id);
            $post->status='approved';
            $post->save();
            Flash::success("Post <strong>".$post->title."</strong> was approved.");
            return redirect()->route('admin.posts.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
    public function suspend($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $post = Post::find($id);
            $post->status='suspended';
            $post->save();
            Flash::warning("Post <strong>".$post->title."</strong> was suspended.");
            return redirect()->route('admin.posts.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
}
