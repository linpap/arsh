<?php

namespace App\Http\Controllers;

use App\Subcategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\EbookRequest;
use Laracasts\Flash\Flash;
use App\Ebook;
use App\Tag;
use App\Image;
use App\Category;
use App\User;
use App\Navbar;
use App\Footer;
use App\Sidebar;
use App\Adv;
use Auth;
use Config;
class EbooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserPosts($id){
        $ebooks =  Ebook::orderBy('id','DESC')->where('user_id',$id)->paginate(5);
        $ebooks->each(function($ebooks){
            $ebooks->category;
            $ebooks->images;
            $ebooks->tags;
            $ebooks->user;
        });
        $user = User::find($id);
        return view('admin.ebooks.user')
        ->with('ebooks',$ebooks)->with('user',$user);
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
        return response()->json(['msg'=>'success']);  
        $isViewed= Views::where('ip',$ipAddress)->where('ebook_id',$id)->count();
        if($isViewed == 0){  
            $view = new Views();
            $view->ebook_id = $id;
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
            $ebooks= Ebook::Search($request->title)->orderBy('id','DESC')->where('user_id',Auth::user()->id)->paginate(5);
            $ebooks->each(function($ebooks){
                $ebooks->category;
                $ebooks->images;
                $ebooks->tags;
                $ebooks->user;
            });
            return view('admin.ebooks.index')
            ->with('ebooks',$ebooks);
        }else{
            Flash::error("You don't have permissions");
            return redirect()->route('admin.home');
        }
    }
    public function all(Request $request)
    {
        if(Auth::user()->type != 'subscriber'){
            $ebooks= Ebook::Search($request->title)->orderBy('id','DESC')->paginate(5);
            $ebooks->each(function($ebooks){
                $ebooks->category;
                $ebooks->images;
                $ebooks->tags;
                $ebooks->user;
            });
            return view('admin.ebooks.all')
            ->with('ebooks',$ebooks);
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
                $categories = Category::orderBy('name','ASC')->where('type','ebook')->lists('name','id');
                $sub_categories = Subcategory::orderBy('name','ASC')->get();
                $tags =Tag::orderBy('name','ASC')->lists('name','id');
                $ebooks = Ebook::orderBy('id','DESC')->paginate(4);
                return view('admin.ebooks.create')
                ->with('ebooks',$ebooks)
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
    public function store(EbookRequest $request)
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
                            'images' => 'dimensions:min_width=*,min_height=450'//max 10000kb
                        );
                        // Now pass the input and rules into the validator
                        $validator = \Validator::make($fileArray, $rules);
                        
                        if($validator->fails()){
                            
                            return redirect()->back()->withErrors($validator)->withInput();
                        }else{
                        //if pass all the validations we add the ebook and the images                        
                            $ebook = new Ebook($request->except('images','category_id','tags','subcategory_id'));
                            $ebook->user_id = \Auth::user()->id;
                           //associate category with ebook
                            $category = Category::find($request['category_id']);
                            $ebook->category()->associate($category);
                            $ebook->subcategory_id=$request['subcategory_id'];
                            $ebook->save();  
                            //associate all tags for the ebook
                            $ebook->tags()->sync($request->tags);
                           
                            $destinationPath = 'img/ebooks/';
                            $image->resize(null,280, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $image->save($destinationPath.'slider_'.$picture);
                            // Thumbnails
                            $image2=\Image::make($file->getRealPath()); //Call immage library installed.      
                            //make images thumbnails                        
                            $thumbPath ='img/ebooks/thumbs/';
                            $image2->resize(100, 100);
                            $image2->save($thumbPath.'thumb_'.$picture);
                            //save image information on the db.
                            $imageDb = new Image();
                            $imageDb->name = $picture;
                            $imageDb->ebook()->associate($ebook);
                            $imageDb->save();       
                        }        
                }
            }
            Flash::success("Ebook <strong>".$ebook->title."</strong> was created.");
            return redirect()->route('admin.ebooks.index');
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
        $ebook = Ebook::where('id',$id)->first();
       
        $ebook->tags()->get();
        $comments = $ebook->comments()->orderBy('id','DESC')->get();     
        $comments->each(function($comments){

                $comments->user;
         
        });
        $categories = Category::orderBy('name','DESC')->paginate(15);
        $related_ebooks = Ebook::orderBy('id','DESC')->paginate(3);

        $advs = Adv::orderBy('position','DESC')->where('section','ebook_single')->get();

        $topHorizontalBanner="";
        $topHorizontalBannerScript="";
    
        foreach($advs as $adv){
            if($adv->position == '0'){
                if($adv->image != ''){
                    $topHorizontalBanner = $adv->image;                    
                }else{
                    $topHorizontalBannerScript = $adv->script;
                }
            }
        }


        return view('front.ebooks.show')
        ->with('related_ebooks',$related_ebooks)
        ->with('topHorizontalBanner',$topHorizontalBanner)
        ->with('topHorizontalBannerScript',$topHorizontalBannerScript)
        ->with('related_ebooks',$related_ebooks)
        ->with('categories',$categories)
        ->with('comments',$comments)
        ->with('ebook',$ebook)
        ->with('navbars',$navbars)
        ->with('footers',$footers);
    }
    public function showAll(Request $request)
    {
        $sidebars = Sidebar::orderBy('position','ASC')->get();
        $navbars = Navbar::orderBy('position','ASC')->get();
        $footers = Footer::orderBy('position','ASC')->get();
        $ebook = Ebook::orderBy('id','DESC')->first();
        $related_ebooks = Ebook::orderBy('id','DESC')->paginate(1);

        $advs = Adv::orderBy('position','DESC')->where('section','ebook_single')->get();

        $topHorizontalBanner="";
        $topHorizontalBannerScript="";
    
        foreach($advs as $adv){
            if($adv->position == '0'){
                if($adv->image != ''){
                    $topHorizontalBanner = $adv->image;                    
                }else{
                    $topHorizontalBannerScript = $adv->script;
                }
            }
        }
        return view('front.ebooks.index')
        ->with('topHorizontalBanner',$topHorizontalBanner)
        ->with('topHorizontalBannerScript',$topHorizontalBannerScript)
        ->with('related_ebooks',$related_ebooks)
        ->with('ebook',$ebook)
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
        $ebook = Ebook::find($id); 
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $ebook->user()->first()->id == Auth::user()->id){            
            $categories = Category::orderBy('name','DESC')->where('type','ebook')->lists('name','id');
            $tags = Tag::orderBy('name','DESC')->lists('name','id');
            $images = new Image();
            $ebook->images->each(function($ebook){
                $ebook->images;
            });
            $myTags = $ebook->tags->lists('id')->ToArray(); //give me a array with only the tags id.
            return View('admin.ebooks.edit')->with('ebook',$ebook)->with('categories',$categories)->with('tags',$tags)->with('myTags',$myTags);            
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
    public function update(EbookRequest $request, $id)
    {
        if(Auth::user()->type != 'subscriber'){
            $ebook =Ebook::find($id);
            if($request->featured){
                $ebook->featured = 'true';
            }else{
                $ebook->featured = 'false';
            }
            $ebook->fill($request->all());
            $ebook->user_id = \Auth::user()->id;
            
            $ebook->save();
            $ebook->tags()->sync($request->tags);
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
                            $destinationPath = 'img/ebooks/';
                            $image->resize(null,280, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $image->save($destinationPath.'slider_'.$picture);
                            // Thumbnails
                            $image2=\Image::make($file->getRealPath()); //Call immage library installed.      
                            //make images thumbnails                        
                            $thumbPath ='img/ebooks/thumbs/';
                            $image2->resize(100, 100);
                            $image2->save($thumbPath.'thumb_'.$picture);
                            //save image information on the db.
                            $imageDb = new Image();
                            $imageDb->name = $picture;
                            $imageDb->ebook()->associate($ebook);
                            $imageDb->save();       
                        }
                }
            }
            Flash::success('Ebook <strong>'.$ebook->title.'</strong> was updated.');
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
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $ebook->user()->first()->id == Auth::user()->id){
            $ebook = Ebook::find($id);
            $ebook->delete();
            Flash::error("Ebook <strong>".$ebook->name."</strong> was deleted.");
            return redirect()->route('admin.ebooks.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.ebooks.index');
        }            
      
    }
    
    public function approve($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $ebook = Ebook::find($id);
            $ebook->status='approved';
            $ebook->save();
            Flash::success("Ebook <strong>".$ebook->title."</strong> was approved.");
            return redirect()->route('admin.ebooks.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
    public function suspend($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $ebook = Ebook::find($id);
            $ebook->status='suspended';
            $ebook->save();
            Flash::warning("Ebook <strong>".$ebook->title."</strong> was suspended.");
            return redirect()->route('admin.ebooks.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
}
