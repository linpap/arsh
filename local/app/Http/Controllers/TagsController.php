<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Laracasts\Flash\Flash;
use App\Tag;
use Auth;
class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->type == 'admin'){
            $tags = Tag::search($request->name)->orderBy('id','DESC')->paginate(4); //references function scopeSearch@TagModel

            return view('admin.tags.index')->with('tags',$tags);
        }else{
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
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag=new Tag();
        $data= $tag::where('name',$request->all()['name'])->first();

        if (count($data)>0){
            Flash::success("<strong>Tag Already Taken</strong>.");
            return redirect()->route('admin.tags.index');
        }
        $tag = new Tag($request->all());
        $tag->save();
        Flash::success("Tag <strong>".$tag->name."</strong> was created.");
        return redirect()->route('admin.tags.index');
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
        if(Auth::user()->type == 'admin'){
            $tag = Tag::find($id);
            return View('admin.tags.edit')->with('tag',$tag);
        }else{
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
        $tag=new Tag();
        $data= $tag::where('name',$request->all()['name'])->first();

        if (count($data)>0){
            Flash::success("<strong>Tag Already Taken</strong>.");
            return redirect()->route('admin.tags.index');
        }
        $tag = Tag::find($id);
        $tag->fill($request->all());
        $tag->save();
        Flash::success("Tag was updated.");
        return redirect()->route('admin.tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->type == 'admin'){
            $tag = Tag::find($id);
            $tag->delete();
            Flash::error("Tag <strong>".$tag->name."</strong> was deleted.");
            return redirect()->route('admin.tags.index');            
        }else{
            return redirect()->route('admin.home');
        }

    }
}
