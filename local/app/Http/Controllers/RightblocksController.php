<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RightblockRequest;
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
use App\Rightblock;
use App\Views;
use App\Adv;
use App\Subcategory;
use Auth;
use Config;

class RightblocksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->type != 'subscriber'){
            $rightblocks = Rightblock::orderBy('id','DESC')->paginate(5);
            return view('admin.rightblocks.index')
            ->with('rightblocks',$rightblocks);
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
                return view('admin.rightblocks.create');
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
    public function store(RightblockRequest $request)
    {
        $rightblocks = Rightblock::orderBy('id','DESC')->get();
        $exists=0;
        foreach($rightblocks as $rightblock){
            if($rightblock->type == $request->type){
                $exists=1;
            }
        }
        if(Auth::user()->type != 'subscriber'){
            if($exists == 1){
                Flash::error('This block is already created. Please edit them.');
                return redirect()->route('admin.rightblocks.index');
            }
            $rightblock = new Rightblock($request->all());
            $rightblock->save();
            Flash::success("Rightblock <strong>".$rightblock->type."</strong> was created.");
            return redirect()->route('admin.rightblocks.index');
        }else{
                Flash::error("You don't have permissions");
                return redirect()->route('admin.home');
        }
    }
    public function edit($id)
    {        
        $rightblock = Rightblock::find($id); 
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $rightblock->user()->first()->id == Auth::user()->id){
            return View('admin.rightblocks.edit')->with('rightblock',$rightblock);            
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
    public function update(RightblockRequest $request, $id)
    {
        if(Auth::user()->type != 'subscriber'){
            $rightblock =Rightblock::find($id);
            $rightblock->fill($request->all());            
            $rightblock->save();
            Flash::success('Rightblock <strong>'.$rightblock->title.'</strong> was updated.');
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
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $rightblock->user()->first()->id == Auth::user()->id){
            $rightblock = Rightblock::find($id);
            $rightblock->delete();
            Flash::error("Rightblock <strong>".$rightblock->name."</strong> was deleted.");
            return redirect()->route('admin.rightblocks.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.rightblocks.index');
        }            
      
    }
    
    public function approve($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $rightblock = Rightblock::find($id);
            $rightblock->status='approved';
            $rightblock->save();
            Flash::success("Rightblock <strong>".$rightblock->title."</strong> was approved.");
            return redirect()->route('admin.rightblocks.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
    public function suspend($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $rightblock = Rightblock::find($id);
            $rightblock->status='suspended';
            $rightblock->save();
            Flash::warning("Rightblock <strong>".$rightblock->title."</strong> was suspended.");
            return redirect()->route('admin.rightblocks.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
}
