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
use App\Video;
use App\Ebook;
use App\Comment;
use App\Navbar;
use App\Footer;
use App\Sidebar;
use App\Views;
use Auth;
use Carbon;
use Config;

class PointsController extends Controller
{
 
    public function addComment(Request $request,$type,$id,$comments){
      
        if($type == 'photos'){
            $photo = Photo::find($id);
            if($photo->fbcomments >= $comments){ 
                $points = ($photo->likes*1) + ($photo->fbcomments*5) + ($photo->shares*3);
                $photo->fbcomments = $comments;
                $photo->points=$points;
                $photo->save();
                return response()->json(['msg'=>'sucess']);
            }else{
                $points = $photo->points + (5*$comments);
                $photo->fbcomments = $comments;
                $photo->points=$points;
                $photo->save();
                return response()->json(['msg'=>'sucess']);              
            }                     
        }
        if($type == 'posts'){
            $post = Post::find($id);
            if($post->fbcomments >= $comments){               
                $points = ($post->likes*1) + ($post->fbcomments*5) + ($post->shares*3);
                $post->fbcomments = $comments;
                $post->points=$points;
                $post->save();
                return response()->json(['msg'=>'sucess']);
            }else{
                $points = $post->points + (5*$comments);
                $post->fbcomments = $comments;
                $post->points=$points;
                $post->save();
                return response()->json(['msg'=>'sucess']);              
            }                     
        }
        if($type == 'videos'){
            $video = Video::find($id);
            if($video->fbcomments >= $comments){                
                $points = ($video->likes*1) + ($video->fbcomments*5) + ($video->shares*3);
                $video->fbcomments = $comments;
                $video->points=$points;
                $video->save();
                return response()->json(['msg'=>'sucess']);
            }else{
                $points = $video->points + (5*$comments);
                $video->fbcomments = $comments;
                $video->points=$points;
                $video->save();
                return response()->json(['msg'=>'sucess']);              
            }                     
        }
        if($type == 'ebooks'){
            $ebook = Ebook::find($id);
            if($ebook->fbcomments >= $comments){                
                $points = ($ebook->likes*1) + ($ebook->fbcomments*5) + ($ebook->shares*3);
                $ebook->fbcomments = $comments;
                $ebook->points=$points;
                $ebook->save();
                return response()->json(['msg'=>'sucess']);
            }else{
                $points = $ebook->points + (5*$comments);
                $ebook->fbcomments = $comments;
                $ebook->points=$points;
                $ebook->save();
                return response()->json(['msg'=>'sucess']);              
            }                     
        }  
    }

    public function addLike(Request $request,$type,$id,$likes){
        if($type == 'photos'){
            $photo = Photo::find($id);
            if($photo->likes >= $likes){                 
                $points = ($photo->likes*1) + ($photo->fbcomments*5) + ($photo->shares*3);
                $photo->likes = $likes;
                $photo->points=$points;
                $photo->save();
                return response()->json(['msg'=>'sucess']);
            }else{
                $points = $photo->points + (1*$likes);
                $photo->likes = $likes;
                $photo->points=$points;
                $photo->save();
                return response()->json(['msg'=>'sucess']);              
            }                     
        }
        if($type == 'posts'){
            $post = Post::find($id);
            if($post->likes >= $likes){                 
                $points = ($post->likes*1) + ($post->fbcomments*5) + ($post->shares*3);
                $post->likes = $likes;
                $post->points=$points;
                $post->save();
                return response()->json(['msg'=>'sucess']);
            }else{
                $points = $post->points + (1*$likes);
                $post->likes = $likes;
                $post->points=$points;
                $post->save();
                return response()->json(['msg'=>'sucess']);              
            }                     
        }
        if($type == 'videos'){
            $video = Video::find($id);
            if($video->likes >= $likes){                 
                $points = ($video->likes*1) + ($video->fbcomments*5) + ($video->shares*3);
                $video->likes = $likes;
                $video->points=$points;
                $video->save();
                return response()->json(['msg'=>'sucess']);
            }else{
                $points = $video->points + (1*$likes);
                $video->likes = $likes;
                $video->points=$points;
                $video->save();
                return response()->json(['msg'=>'sucess']);              
            }                     
        }
        if($type == 'ebooks'){
            $ebook = Ebook::find($id);
            if($ebook->likes >= $likes){                 
                $points = ($ebook->likes*1) + ($ebook->fbcomments*5) + ($ebook->shares*3);
                $ebook->likes = $likes;
                $ebook->points=$points;
                $ebook->save();
                return response()->json(['msg'=>'sucess']);
            }else{
                $points = $ebook->points + (1*$likes);
                $ebook->likes = $likes;
                $ebook->points=$points;
                $ebook->save();
                return response()->json(['msg'=>'sucess']);              
            }                     
        }

    }
    public function addShare(Request $request,$type,$id,$shares){
        if($type == 'photos'){
            $photo = Photo::find($id);
            if($photo->shares >= $shares){                 
                $points = ($photo->likes*1) + ($photo->fbcomments*5) + ($photo->shares*3);
                $photo->shares = $shares;
                $photo->points=$points;
                $photo->save();
                return response()->json(['msg'=>'sucess']);
            }else{
                $points = $photo->points + (3*$shares);
                $photo->shares = $shares;
                $photo->points=$points;
                $photo->save();
                return response()->json(['msg'=>'sucess']);              
            }                     
        }
        if($type == 'posts'){
            $post = Post::find($id);
            if($post->shares >= $shares){                 
                $points = ($post->likes*1) + ($post->fbcomments*5) + ($post->shares*3);
                $post->shares = $shares;
                $post->points=$points;
                $post->save();
                return response()->json(['msg'=>'sucess']);
            }else{
                $points = $post->points + ($shares * 3);
                $post->shares = $shares;
                $post->points=$points;
                $post->save();
                return response()->json(['msg'=>'sucess']);              
            }                     
        }
        if($type == 'videos'){
            $video = Video::find($id);
            if($video->shares >= $shares){                 
                $points = ($video->likes*1) + ($video->fbcomments*5) + ($video->shares*3);
                $video->shares = $shares;
                $video->points=$points;
                $video->save();
                return response()->json(['msg'=>'sucess']);
            }else{
                $points = $video->points + (3*$shares);
                $video->shares = $shares;
                $video->points=$points;
                $video->save();
                return response()->json(['msg'=>'sucess']);              
            }                     
        }
        if($type == 'ebooks'){
            $ebook = Ebook::find($id);
            if($ebook->shares >= $shares){                 
                $points = ($ebook->likes*1) + ($ebook->fbcomments*5) + ($ebook->shares*3);
                $ebook->shares = $shares;
                $ebook->points=$points;
                $ebook->save();
                return response()->json(['msg'=>'sucess']);
            }elseif($ebook->shares < $shares){
                $points = $ebook->points + (3*$shares);
                $ebook->shares = $shares;
                $ebook->points=$points;
                $ebook->save();
                return response()->json(['msg'=>'sucess']);              
            }                     
        }
    }


    public function getUserPoints(Request $request, $userid,$from=null,$to=null){
            $sum = 0;
            $points = 0;

            if($from == null && $to == null){
                $photos = Photo::orderBy('id','DESC')->where('user_id',$userid)->get();
                $videos = Video::orderBy('id','DESC')->where('user_id',$userid)->get();
                $posts = Post::orderBy('id','DESC')->where('user_id',$userid)->get();       
                $ebooks = Ebook::orderBy('id','DESC')->where('user_id',$userid)->get();
            }else{
                $from = Carbon::createFromFormat('m-d-Y', $from)->toDateTimeString();
                $to = Carbon::createFromFormat('m-d-Y', $to)->toDateTimeString();
                $photos = Photo::orderBy('id','DESC')->where('user_id',$userid)->where('created_at','>',$from)->where('created_at','<',$to)->get();
                $videos = Video::orderBy('id','DESC')->where('user_id',$userid)->where('created_at','>',$from)->where('created_at','<',$to)->get();
                $posts = Post::orderBy('id','DESC')->where('user_id',$userid)->where('created_at','>',$from)->where('created_at','<',$to)->get();       
                $ebooks = Ebook::orderBy('id','DESC')->where('user_id',$userid)->where('created_at','>',$from)->where('created_at','<',$to)->get();

            }         

            if($photos->count() > 0){          
                foreach($photos as $photo){
                    $points= $photo->points;
                    $sum = $sum+$points;
                }

            }       
      
            if($posts->count() > 0){          
                foreach($posts as $post){
                    $points= $post->points;
                    $sum = $sum+$points;
                }               
            }
        
            if($videos->count() > 0){         
                foreach($videos as $video){
                    $points= $video->points;
                    $sum = $sum+$points;
                }
            }

            if($ebooks->count() > 0){         
                foreach($ebooks as $ebook){
                    $points= $ebook->points;
                    $sum = $sum+$points;
                }
            }
            if($from == null && $to == null){
                return $sum;
            }else{
                return response()->json(['msg'=>$sum]);
            }                
     
    }
}
