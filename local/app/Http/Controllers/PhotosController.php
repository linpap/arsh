<?php

namespace App\Http\Controllers;

use App\Post;
use App\Subcategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PhotoRequest;
use Laracasts\Flash\Flash;
use App\Photo;
use App\Tag;
use App\Image;
use App\Category;
use App\Views;
use App\User;
use App\Navbar;
use App\Footer;
use App\Sidebar;
use App\Adv;
use Auth;
use Config;
class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserPosts($id){
        $photos =  Photo::orderBy('id','DESC')->where('user_id',$id)->paginate(5);
        $photos->each(function($photos){
            $photos->category;
            $photos->images;
            $photos->tags;
            $photos->user;
        });
        $user = User::find($id);
        return view('admin.photos.user')
        ->with('photos',$photos)->with('user',$user);
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


        $isViewed= Views::where('ip',$ipAddress)->where('photo_id',$id)->count();
        if($isViewed == 0){
            $view = new Views();
            $view->photo_id = $id;
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
            $photos= Photo::Search($request->title)->orderBy('id','DESC')->where('user_id',Auth::user()->id)->paginate(5);
            $photos->each(function($photos){
                $photos->category;
                $photos->images;
                $photos->tags;
                $photos->user;
            });
            return view('admin.photos.index')
            ->with('photos',$photos);
        }else{
            Flash::error("You don't have permissions");
            return redirect()->route('admin.home');
        }
    }
    public function all(Request $request)
    {

        if(Auth::user()->type != 'subscriber'){
            $photos= Photo::Search($request->title)->orderBy('id','DESC')->paginate(5);
            $photos->each(function($photos){
                $photos->category;
                $photos->images;
                $photos->tags;
                $photos->user;
            });
            return view('admin.photos.all')
            ->with('photos',$photos);
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
                $categories = Category::orderBy('name','ASC')->where('type','photo')->lists('name','id');
                $sub_categories = Subcategory::orderBy('name','ASC')->get();
                $tags =Tag::orderBy('name','ASC')->lists('name','id');
                $photos = Photo::orderBy('id','DESC')->paginate(4);
                return view('admin.photos.create')
                ->with('photos',$photos)
                ->with('subcategories',$sub_categories)
                ->with('categories',$categories)
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
    public function store(PhotoRequest $request)
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
                            'images' => 'dimensions:min_width=600,min_height=400'//max 10000kb
                        );
                        // Now pass the input and rules into the validator
                        $validator = \Validator::make($fileArray, $rules);

                        if($validator->fails()){

                            return redirect()->back()->withErrors($validator)->withInput();
                        }else{
                        //if pass all the validations we add the photo and the images
                            $photo = new Photo($request->except('images','category_id','tags','subcategory_id'));
                            $photo->user_id = \Auth::user()->id;
                           //associate category with photo
                            $category = Category::find($request['category_id']);
                            $photo->category()->associate($category);
                            $photo->subcategory_id=$request['subcategory_id'];
                            $photo->save();
                            //associate all tags for the photo
                            $photo->tags()->sync($request->tags);

                            $destinationPath = 'img/photos/';
                            $image->resize(null,600, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $image->save($destinationPath.'slider_'.$picture);
                            // Thumbnails
                            $image2=\Image::make($file->getRealPath()); //Call immage library installed.
                            //make images thumbnails
                            $thumbPath ='img/photos/thumbs/';
                            $image2->resize(150, 100);
                            $image2->save($thumbPath.'thumb_'.$picture);
                            //save image information on the db.
                            $imageDb = new Image();
                            $imageDb->name = $picture;
                            $imageDb->photo()->associate($photo);
                            $imageDb->save();
                        }
                }
            }
            Flash::success("Photo <strong>".$photo->title."</strong> was created.");
            return redirect()->route('admin.photos.index');
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
        $photo = Photo::where('id',$id)->first();

        $photo->tags()->get();
        $comments = $photo->comments()->orderBy('id','DESC')->get();
        $comments->each(function($comments){

                $comments->user;

        });
        $categories = Category::orderBy('name','DESC')->paginate(15);
        $related_photos = Photo::orderBy('id','DESC')->paginate(3);

        $advs = Adv::orderBy('position','DESC')->where('section','photo_single')->get();

        $post = Post::where('id',$id)->first();
        $post->views();
        $post->tags()->get();

        $topHorizontalBanner="";
        $firstSidebarRight="";
        $secondSidebarRight="";
        $bottomHorizontal="";
        $topHorizontalBannerScript="";
        $firstSidebarRightScript="";
        $secondSidebarRightScript="";
        $thirdSidebarVerticalScript="";
        $bottomHorizontalScript="";
        $thirdSidebarRightScript="";
        $thirdSidebarVertical="";
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

        return view('front.photos.show')
        ->with('topHorizontalBanner',$topHorizontalBanner)
        ->with('thirdSidebarVertical',$thirdSidebarVertical)
        ->with('thirdSidebarVerticalScript',$thirdSidebarVerticalScript)
        ->with('firstSidebarRight',$firstSidebarRight)
        ->with('secondSidebarRight',$secondSidebarRight)
        ->with('bottomHorizontal',$bottomHorizontal)
        ->with('topHorizontalBannerScript',$topHorizontalBannerScript)
        ->with('firstSidebarRightScript',$firstSidebarRightScript)
        ->with('secondSidebarRightScript',$secondSidebarRightScript)
        ->with('bottomHorizontalScript',$bottomHorizontalScript)
        ->with('related_photos',$related_photos)
        ->with('related_photos',$related_photos)
        ->with('categories',$categories)
        ->with('comments',$comments)
        ->with('photo',$photo)
        ->with('post',$post)
        ->with('navbars',$navbars)
        ->with('footers',$footers);
    }
    public function showAll(Request $request)
    {
        $sidebars = Sidebar::orderBy('position','ASC')->get();
        $navbars = Navbar::orderBy('position','ASC')->get();
        $footers = Footer::orderBy('position','ASC')->get();
        $photo = Photo::orderBy('id','DESC')->first();
        $related_photos = Photo::orderBy('id','DESC')->paginate(1);

        $advs = Adv::orderBy('position','DESC')->where('section','photo')->get();

        $topHorizontalBanner="";
        $firstSidebarRight="";
        $secondSidebarRight="";
        $thirdSidebarVertical="";
        $rightSingle="";
        $topHorizontalBannerScript="";
        $firstSidebarRightScript="";
        $secondSidebarRightScript="";
        $thirdSidebarVerticalScript="";
        $rightSingleScript="";


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
            }elseif($adv->position == '7'){
                if($adv->image != ''){
                    $rightSingle = $adv->image;
                }else{
                    $rightSingleScript = $adv->script;
                }
            }
        }
        return view('front.photos.index')
        ->with('topHorizontalBanner',$topHorizontalBanner)
        ->with('firstSidebarRight',$firstSidebarRight)
        ->with('secondSidebarRight',$secondSidebarRight)
        ->with('thirdSidebarVertical',$thirdSidebarVertical)
        ->with('rightSingle',$rightSingle)
        ->with('topHorizontalBannerScript',$topHorizontalBannerScript)
        ->with('firstSidebarRightScript',$firstSidebarRightScript)
        ->with('secondSidebarRightScript',$secondSidebarRightScript)
        ->with('thirdSidebarVerticalScript',$thirdSidebarVerticalScript)
        ->with('rightSingleScript',$rightSingleScript)
        ->with('related_photos',$related_photos)
        ->with('photo',$photo)
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
        $photo = Photo::find($id);
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $photo->user()->first()->id == Auth::user()->id){
            $categories = Category::orderBy('name','DESC')->where('type','photo')->lists('name','id');
            $tags = Tag::orderBy('name','DESC')->lists('name','id');
            $images = new Image();
            $photo->images->each(function($photo){
                $photo->images;
            });
            $myTags = $photo->tags->lists('id')->ToArray(); //give me a array with only the tags id.
            return View('admin.photos.edit')->with('photo',$photo)->with('categories',$categories)->with('tags',$tags)->with('myTags',$myTags);
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
    public function update(PhotoRequest $request, $id)
    {
        if(Auth::user()->type != 'subscriber'){
            $photo =Photo::find($id);
            if($request->featured){
                $photo->featured = 'true';
            }else{
                $photo->featured = 'false';
            }
            $photo->fill($request->all());
            $photo->user_id = \Auth::user()->id;

            $photo->save();
            $photo->tags()->sync($request->tags);
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
                            $destinationPath = 'img/photos/';
                            $image->resize(null,450, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $image->save($destinationPath.'slider_'.$picture);
                            // Thumbnails
                            $image2=\Image::make($file->getRealPath()); //Call immage library installed.
                            //make images thumbnails
                            $thumbPath ='img/photos/thumbs/';
                            $image2->resize(100, 100);
                            $image2->save($thumbPath.'thumb_'.$picture);
                            //save image information on the db.
                            $imageDb = new Image();
                            $imageDb->name = $picture;
                            $imageDb->photo()->associate($photo);
                            $imageDb->save();
                        }
                }
            }
            Flash::success('Photo <strong>'.$photo->title.'</strong> was updated.');
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
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $photo->user()->first()->id == Auth::user()->id){
            $photo = Photo::find($id);
            $photo->delete();
            Flash::error("Photo <strong>".$photo->name."</strong> was deleted.");
            return redirect()->route('admin.photos.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.photos.index');
        }

    }

    public function approve($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $photo = Photo::find($id);
            $photo->status='approved';
            $photo->save();
            Flash::success("Photo <strong>".$photo->title."</strong> was approved.");
            return redirect()->route('admin.photos.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
    public function suspend($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $photo = Photo::find($id);
            $photo->status='suspended';
            $photo->save();
            Flash::warning("Photo <strong>".$photo->title."</strong> was suspended.");
            return redirect()->route('admin.photos.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
}
