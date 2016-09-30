<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\FooterRequest;
use App\Category;
use Laracasts\Flash\Flash;
use Auth;
use Config;
use App\Footer;
class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(Auth::user()->type != 'subscriber'){
            $footers= Footer::orderBy('position','ASC')->paginate(6);
            $footers->each(function($footers){
                $footers->category;
            });
            return view('admin.footers.index')
            ->with('footers',$footers);
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
        $categories = Category::orderBy('id','DESC')->lists('name','id');
        return view('admin.footers.create')->with('categories',$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FooterRequest $request)
    {
        $footers = Footer::all();
        $count= count($footers);
        $position = Footer::where('position',$request->position)->get();
        $existposition = count($position);
        if($existposition == 0){
            if($count == 6){
                Flash::error('আপনি আরো আইটেম যোগ করতে পারবেন না . সর্বোচ্চ দশ আইটেম .');
                return redirect()->route('admin.footers.index');
            }else{            
                $footer = new Footer();
                $footer->category_id = $request->category_id;
                $footer->position = $request->position;
                $footer->save();
                Flash::success('সাফল্য');
                return redirect()->route('admin.footers.index');
            }
        }else{
            //if the position is already set
            Flash::error('এই অবস্থান তার ইতিমধ্যেই নেওয়া');
            return redirect()->back();
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
        $footer = Footer::find($id); 
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){            
            $categories = Category::orderBy('id','DESC')->lists('name','id');
            return View('admin.footers.edit')->with('footer',$footer)->with('categories',$categories);            
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
        $footer =Footer::find($id);
        $footer->fill($request->all());
        $footer->save();
        Flash::success('সাফল্য');
        return redirect()->route('admin.footers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $footer = Footer::find($id);
            $footer->delete();
            Flash::error("Item was deleted.");
            return redirect()->route('admin.footers.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.footers.index');
        }            
      
    }
}
