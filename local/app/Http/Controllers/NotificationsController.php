<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
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
use App\Views;
use App\Adv;
use Auth;
use Config;

class NotificationsController extends Controller
{    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        if(Auth::user()->type != 'subscriber'){
            $notifications = Notification::all();
            return view('admin.notifications.index')
            ->with('notifications',$notifications);
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
            return view('admin.notifications.create');
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
                        //if pass all the validations we add the notification and the images                        
                            $notification = new Post($request->except('images','category_id','tags'));
                            $notification->user_id = \Auth::user()->id;
                           //associate category with notification
                            $category = Category::find($request['category_id']);
                            $notification->category()->associate($category);
                            $notification->sub_title=$request['subtitle'];
                            $notification->subcategory_id=$request['subcategory_id'];
                            $notification->featured_b=$request['featured_b'];
                            $notification->photo_credit=$request['photo_credit'];
                            $notification->caption=$request['caption'];
                            $notification->save();
                            //associate all tags for the notification
                            $notification->tags()->sync($request->tags);
                           
                            $destinationPath = 'img/notifications/';
                            $image->resize(null,450, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $image->save($destinationPath.'slider_'.$picture);
                            // Thumbnails
                            $image2=\Image::make($file->getRealPath()); //Call immage library installed.      
                            //make images thumbnails                        
                            $thumbPath ='img/notifications/thumbs/';
                            $image2->resize(100, 100);
                            $image2->save($thumbPath.'thumb_'.$picture);
                            //save image information on the db.
                            $imageDb = new Image();
                            $imageDb->name = $picture;
                            $imageDb->notification()->associate($notification);
                            $imageDb->save();       
                        }        
                }
            }
            Flash::success("Post <strong>".$notification->title."</strong> was created.");
            return redirect()->route('admin.notifications.index');
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
        $notification = Post::where('id',$id)->first();
        $notification->views();
        $notification->tags()->get();
        $comments = $notification->comments()->orderBy('id','DESC')->get();
   
        $comments->each(function($comments){

                $comments->user;
         
        });
        $categories = Category::orderBy('name','DESC')->paginate(15);
        $related_notifications = Post::orderBy('id','DESC')->paginate(3);
        $related_photos = Photo::orderBy('id','DESC')->paginate(3);

        $advs = Adv::orderBy('position','DESC')->where('section','notification_single')->get();

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

        return view('front.notifications.show')
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
        ->with('related_notifications',$related_notifications)
        ->with('categories',$categories)
        ->with('comments',$comments)
        ->with('notification',$notification)
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
        $notification = Post::find($id); 
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $notification->user()->first()->id == Auth::user()->id){            
            $categories = Category::orderBy('name','DESC')->where('type','notification')->lists('name','id');
            $tags = Tag::orderBy('name','DESC')->lists('name','id');
            $images = new Image();
            $notification->images->each(function($notification){
                $notification->images;
            });
            $myTags = $notification->tags->lists('id')->ToArray(); //give me a array with only the tags id.
            return View('admin.notifications.edit')->with('notification',$notification)->with('categories',$categories)->with('tags',$tags)->with('myTags',$myTags);            
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
            $notification =Post::find($id);
            if($request->featured){
                $notification->featured = 'true';
            }else{
                $notification->featured = 'false';
            }
            $notification->fill($request->all());
            $notification->user_id = \Auth::user()->id;
            
            $notification->save();
            $notification->tags()->sync($request->tags);
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
                            $destinationPath = 'img/notifications/';
                            $image->resize(null,450, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $image->save($destinationPath.'slider_'.$picture);
                            // Thumbnails
                            $image2=\Image::make($file->getRealPath()); //Call immage library installed.      
                            //make images thumbnails                        
                            $thumbPath ='img/notifications/thumbs/';
                            $image2->resize(100, 100);
                            $image2->save($thumbPath.'thumb_'.$picture);
                            //save image information on the db.
                            $imageDb = new Image();
                            $imageDb->name = $picture;
                            $imageDb->notification()->associate($notification);
                            $imageDb->save();       
                        }
                }
            }
            Flash::success('Post <strong>'.$notification->title.'</strong> was updated.');
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
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $notification->user()->first()->id == Auth::user()->id){
            $notification = Post::find($id);
            $notification->delete();
            Flash::error("Post <strong>".$notification->name."</strong> was deleted.");
            return redirect()->route('admin.notifications.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.notifications.index');
        }            
      
    }
    
    public function approve($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $notification = Post::find($id);
            $notification->status='approved';
            $notification->save();
            Flash::success("Post <strong>".$notification->title."</strong> was approved.");
            return redirect()->route('admin.notifications.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
    public function suspend($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $notification = Post::find($id);
            $notification->status='suspended';
            $notification->save();
            Flash::warning("Post <strong>".$notification->title."</strong> was suspended.");
            return redirect()->route('admin.notifications.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
}
