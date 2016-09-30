<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AdvRequest;
use App\Adv;
use App\Image;
use App\Category;
use Laracasts\Flash\Flash;
use Auth;
class AdvsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->type != 'subscriber'){
            $advs= Adv::orderBy('id','DESC')->paginate(5);      
            return view('admin.advs.index')
            ->with('advs',$advs);
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
                $advs = Adv::orderBy('id','DESC')->paginate(4);
                return view('admin.advs.create')
                ->with('advs',$advs);
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
    public function store(AdvRequest $request)
    {
        if(Auth::user()->type != 'subscriber'){

            if($request['script'] != '' && ($request['section'] != '' || $request['position'])){
                Flash::error('You have to select one type of advertisement');
                return redirect()->back()->withInput();
            }
            //Check if the images are null or not.
            $fileArray0 = array('image' => $request->file('image'));
            // Tell the validator that this file should be required
            $rules0 = array(
                'image' => 'required'//max 10000kb
            );
            // Now pass the input and rules into the validator
            $validator0 = \Validator::make($fileArray0, $rules0);       
            if($validator0->fails()){
               return redirect()->back()->withErrors($validator0)->withInput();
            }else{
            //Process Form Images
            if ($request->hasFile('image')) {
                $file = $request->file('image'); 
                //Slider
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $picture = date('His').'_'.$filename;
                //make images sliders
                $image=\Image::make($file->getRealPath()); //Call image library installed.
                // Build the input for validation
                $fileArray = array('image' => $file);
                // Tell the validator that this file should be an image

                /* TENGO QUE VALIDAD QUE TIPO DE ADV ES Y LISTO */
                if($request->position == '0'){

                    $rules = array(
                        'image' => 'dimensions:min_width=732,min_height=94'//max 10000kb
                    );
                    $image->resize(732,94);

                }
                if($request->position == '1' || $request->position == '2'){

                    $rules = array(
                        'image' => 'dimensions:min_width=300,min_height=250'//max 10000kb
                    );
                    $image->resize(300,250);
                }
                if($request->position == '3'){
                    if($request->section == 'category' && $request->section == 'home' && $request->section == 'profile'){
                       $rules = array(
                            'image' => 'dimensions:min_width=426,min_height=350'//max 10000kb
                        );                        
                        $image->resize(426,350);
                    }else{
                        Flash::error("This type of advertisement no exists on this section.");
                    }

                }
                if($request->position == '4'){

                    $rules = array(
                        'image' => 'dimensions:min_width=300,min_height=600'//max 10000kb
                    );
                    $image->resize(300,600);

                }
                if($request->position == '5'){

                    $rules = array(
                        'image' => 'dimensions:min_width=300,min_height=600'//max 10000kb
                    );

                    $image->resize(300,600);

                }
                if($request->position == '6'){

                    $rules = array(
                        'image' => 'dimensions:min_width=600,min_height=100'//max 10000kb
                    );
                    
                    $image->resize(600,100);

                }
                if($request->position == '7'){

                    $rules = array(
                        'image' => 'dimensions:min_width=150,min_height=300'//max 10000kb
                    );
                    
                    $image->resize(150,300);

                }
                }
                // Now pass the input and rules into the validator
                $validator = \Validator::make($fileArray, $rules);
                
                if($validator->fails()){
                    
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                //if pass all the validations we add the adv and the images                        
                    $adv = new Adv($request->all());
                    $adv->image = $picture;
                    $adv->save();                   
                    $destinationPath = 'img/advs/';                    
                    $image->save($destinationPath.'adv_'.$picture);  
                }
            }
            Flash::success("Adv <strong>".$adv->section."</strong> was created on position".$adv->position);
            return redirect()->route('admin.advs.index');
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
        $adv = Adv::where('id',$id)->first();
       
        $adv->tags()->get();
        $comments = $adv->comments()->orderBy('id','DESC')->get();     
        $comments->each(function($comments){

                $comments->user;
         
        });
        $categories = Category::orderBy('name','DESC')->paginate(15);
        $related_advs = Adv::orderBy('id','DESC')->paginate(3);

        return view('front.advs.show')
        ->with('related_advs',$related_advs)
        ->with('related_advs',$related_advs)
        ->with('categories',$categories)
        ->with('comments',$comments)
        ->with('adv',$adv)
        ->with('navbars',$navbars)
        ->with('footers',$footers);
    }
    public function showAll(Request $request)
    {
        $sidebars = Sidebar::orderBy('position','ASC')->get();
        $navbars = Navbar::orderBy('position','ASC')->get();
        $footers = Footer::orderBy('position','ASC')->get();
        $adv = Adv::orderBy('id','DESC')->first();
        $related_advs = Adv::orderBy('id','DESC')->paginate(1);
        return view('front.advs.index')
        ->with('related_advs',$related_advs)
        ->with('adv',$adv)
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
        $adv = Adv::find($id); 
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $adv->user()->first()->id == Auth::user()->id){            
            $categories = Category::orderBy('name','DESCw')->lists('name','id');
            return View('admin.advs.edit')->with('adv',$adv)->with('categories',$categories);            
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

            if($request['script'] != '' && ($request['section'] != '' || $request['position'])){
                Flash::error('You have to select one type of advertisement');
                return redirect()->back()->withInput();
            }                   
            $adv = new Adv($request->all());
            $adv->image = $picture;
            $adv->save();
            Flash::success("Adv <strong>".$adv->section."</strong> was created on position".$adv->position);
            return redirect()->route('admin.advs.index');
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
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $adv->user()->first()->id == Auth::user()->id){
            $adv = Adv::find($id);
            $adv->delete();
            Flash::error("Adv <strong>".$adv->name."</strong> was deleted.");
            return redirect()->route('admin.advs.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.advs.index');
        }            
      
    }
    
    public function approve($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $adv = Adv::find($id);
            $adv->status='approved';
            $adv->save();
            Flash::success("Adv <strong>".$adv->title."</strong> was approved.");
            return redirect()->route('admin.advs.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
    public function suspend($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $adv = Adv::find($id);
            $adv->status='suspended';
            $adv->save();
            Flash::warning("Adv <strong>".$adv->title."</strong> was suspended.");
            return redirect()->route('admin.advs.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
}
