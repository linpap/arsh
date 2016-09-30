<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Laracasts\Flash\Flash;
use App\Comment;
use App\Post;
use App\Video;
use App\Photo;
use App\Ebook;
class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$type,$post, $user=null,$isfb)
    {
        $comment = new Comment($request->all());
        $comment->comment = $request['comment'];
        if($type == 'photos'){
            $comment->photo_id = $post;
            $photo = Photo::find($post);
            $points = $photo->points+5;
            $photo->points=$points;
            $photo->save();                       
        }
        if($type == 'posts'){
            $comment->post_id = $post;
            $post = Post::find($post);
            $points = $post->points+5;
            $post->points=$points;
            $post->save();                 
        }
        if($type == 'videos'){
            $comment->video_id = $post;
            $video = Video::find($post);
            $points = $video->points+5;
            $video->points=$points;
            $video->save();               
        }
        if($type == 'ebooks'){
            $comment->ebook_id = $post;
            $ebook = Ebook::find($post);
            $points = $ebook->points+5;
            $ebook->points=$points;
            $ebook->save();                 
        }
        if(isset($user)){
            $comment->user_id = $user;            
        }else{            
            $comment->user_id = null;        
        }
        $comment->save();
        $message ='মন্তব্য সাফল্যের সাথে সম্পন্ন';
        Flash::success("মন্তব্য সাফল্যের সাথে সম্পন্ন");
        return redirect()->back();

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
