<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SidebarRequest;
use App\Category;
use Laracasts\Flash\Flash;
use Auth;
use Config;
use App\Sidebar;
class SidebarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(Auth::user()->type != 'subscriber'){
            $sidebars= Sidebar::orderBy('position','ASC')->paginate(10);
            $sidebars->each(function($sidebars){
                $sidebars->category;
            });
            return view('admin.sidebars.index')
            ->with('sidebars',$sidebars);
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
        return view('admin.sidebars.create')->with('categories',$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SidebarRequest $request)
    {
        $sidebars = Sidebar::all();
        $count= count($sidebars);
        $position = Sidebar::where('position',$request->position)->get();
        $existposition = count($position);
        if($existposition == 0){
            if($count == 10){
                Flash::error('আপনি আরো আইটেম যোগ করতে পারবেন না . সর্বোচ্চ দশ আইটেম .');
                return redirect()->route('admin.sidebars.index');
            }else{            
                $sidebar = new Sidebar();
                $sidebar->category_id = $request->category_id;
                $sidebar->position = $request->position;
                $sidebar->save();
                Flash::success('সাফল্য');
                return redirect()->route('admin.sidebars.index');
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
        $sidebar = Sidebar::find($id); 
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){            
            $categories = Category::orderBy('id','DESC')->lists('name','id');
            return View('admin.sidebars.edit')->with('sidebar',$sidebar)->with('categories',$categories);            
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
        $sidebar =Sidebar::find($id);
        $sidebar->fill($request->all());
        $sidebar->save();
        Flash::success('সাফল্য');
        return redirect()->route('admin.sidebars.index');
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
            $sidebar = Sidebar::find($id);
            $sidebar->delete();
            Flash::error("Item was deleted.");
            return redirect()->route('admin.sidebars.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.sidebars.index');
        }            
      
    }
}
