<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\NavbarRequest;
use App\Category;
use Laracasts\Flash\Flash;
use Auth;
use Config;
use App\Navbar;
class NavbarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(Auth::user()->type != 'subscriber'){
            $navbars= Navbar::orderBy('position','ASC')->paginate(10);
            $navbars->each(function($navbars){
                $navbars->category;
            });
            return view('admin.navbars.index')
            ->with('navbars',$navbars);
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
        return view('admin.navbars.create')->with('categories',$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NavbarRequest $request)
    {
        $navbars = Navbar::all();
        $count= count($navbars);
        $position = Navbar::where('position',$request->position)->get();
        $existposition = count($position);
        if($existposition == 0){
            if($count == 10){
                Flash::error('আপনি আরো আইটেম যোগ করতে পারবেন না . সর্বোচ্চ দশ আইটেম .');
                return redirect()->route('admin.navbars.index');
            }else{            
                $navbar = new Navbar();
                $navbar->category_id = $request->category_id;
                $navbar->position = $request->position;
                $navbar->save();
                Flash::success('সাফল্য');
                return redirect()->route('admin.navbars.index');
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
        $navbar = Navbar::find($id); 
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){            
            $categories = Category::orderBy('id','DESC')->lists('name','id');
            return View('admin.navbars.edit')->with('navbar',$navbar)->with('categories',$categories);            
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
        $navbar =Navbar::find($id);
        $navbar->fill($request->all());
        $navbar->save();
        Flash::success('সাফল্য');
        return redirect()->route('admin.navbars.index');
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
            $navbar = Navbar::find($id);
            $navbar->delete();
            Flash::error("Item was deleted.");
            return redirect()->route('admin.navbars.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.navbars.index');
        }            
      
    }
}
