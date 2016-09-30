<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Requests;
use App\Image;
use Laracasts\Flash\Flash;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Post;
use App\Tag;
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
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index()
    {
        $users = User::orderBy('id','ASC')->paginate(4);

        return view('admin.users.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        Flash::success('User: '.$user->name.' was created!');
        return redirect()->route('admin.users.index');

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
       if(Auth::user()->id == $id || Auth::user()->type == 'admin')
        {

           $user = User::find($id);
            $sum = 0;
            $points = 0;
            $photos = Photo::orderBy('id','DESC')->where('user_id',$id)->get();

            if($photos->count() > 0){          
                foreach($photos as $photo){
                    $points= $photo->points;
                    $sum = $sum+$points;
                }

            }       
      
            $posts = Post::orderBy('id','DESC')->where('user_id',$id)->get();
            if($posts->count() > 0){          
                foreach($posts as $post){
                    $points= $post->points;
                    $sum = $sum+$points;
                }               
            }
        
            $videos = Video::orderBy('id','DESC')->where('user_id',$id)->get(); 
            if($videos->count() > 0){         
                foreach($videos as $video){
                    $points= $video->points;
                    $sum = $sum+$points;
                }
            }
       
            $ebooks = Ebook::orderBy('id','DESC')->where('user_id',$id)->get();
            if($ebooks->count() > 0){         
                foreach($ebooks as $ebook){
                    $points= $ebook->points;
                    $sum = $sum+$points;
                }
            }

            $date = Carbon::now();
            $now = Carbon::now()->toDateString();
            $lastYear = $date->subYear()->toDateTimeString();
            $lastMonth= $date->subMonth()->toDateTimeString();
            $pointsMonth = 0;
            $pointsYear = 0;
            $sumMonth = 0;   
            $sumYear = 0;    

            //between last month
            $photos = Photo::orderBy('id','DESC')->where('created_at','<',$now)->where('created_at','>',$lastMonth)->get();

            if($photos->count() > 0){          
                foreach($photos as $photo){
                    $pointsMonth= $photo->points;
                    $sumMonth= $sumMonth+$pointsMonth;
                }

            }       
      
            $posts = Post::orderBy('id','DESC')->where('created_at','<',$now)->where('created_at','>',$lastMonth)->get();
            if($posts->count() > 0){         
                foreach($posts as $post){
                    $pointsMonth= $post->points;
                    $sumMonth= $sumMonth+$pointsMonth;
                }               
            }
        
            $videos = Video::orderBy('id','DESC')->where('created_at','<',$now)->where('created_at','>',$lastMonth)->get();
            if($videos->count() > 0){         
                foreach($videos as $video){
                    $pointsMonth= $video->points;
                    $sumMonth= $sumMonth+$pointsMonth;
                }
            }
       
            $ebooks = Ebook::orderBy('id','DESC')->where('created_at','<',$now)->where('created_at','>',$lastMonth)->get();
            if($ebooks->count() > 0){         
                foreach($ebooks as $ebook){
                    $pointsMonth= $ebook->points;
                    $sumMonth= $sumMonth+$pointsMonth;
                }
            }

            //year.

            $photos = Photo::orderBy('id','DESC')->where('created_at','<',$now)->where('created_at','>',$lastYear)->where('created_at','>',$lastYear)->get();

            if($photos->count() > 0){          
                foreach($photos as $photo){
                    $pointsYear= $photo->points;
                    $sumYear = $sumYear+$pointsYear;
                }

            }       
      
            $posts = Post::orderBy('id','DESC')->where('created_at','<',$now)->where('created_at','>',$lastYear)->where('created_at','>',$lastYear)->get();
            if($posts->count() > 0){          
                foreach($posts as $post){
                    $pointsYear= $post->points;
                    $sumYear = $sumYear+$pointsYear;
                }               
            }
        
            $videos = Video::orderBy('id','DESC')->where('created_at','<',$now)->where('created_at','>',$lastYear)->where('created_at','>',$lastYear)->get();
            if($videos->count() > 0){         
                foreach($videos as $video){
                    $pointsYear= $video->points;
                    $sumYear = $sumYear+$pointsYear;
                }
            }
       
            $ebooks = Ebook::orderBy('id','DESC')->where('created_at','<',$now)->where('created_at','>',$lastYear)->where('created_at','>',$lastYear)->get();
            if($ebooks->count() > 0){         
                foreach($ebooks as $ebook){
                    $pointsYear= $ebook->points;
                    $sumYear = $sumYear+$pointsYear;
                }
            }
            $sum =$sum;
           return view('admin.users.edit')->with('user',$user)->with('sum',$sum)->with('sumYear',$sumYear)->with('sumMonth',$sumMonth);
       }
       else{

            return redirect('/');
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
        $user = User::find($id);

       $user->fill($request->all());
        $picture_profile = '';
        $picture_real_id = '';

        if ($request->hasFile('profile_image') && $request->file('profile_image') != NULL) {     
            $file_profile = $request->file('profile_image');           
            //image data
            $filename_profile = $file_profile->getClientOriginalName();
            $extension_profile = $file_profile->getClientOriginalExtension();
            $picture_profile = date('His').'_'.$filename_profile;
            //optimize images and store image
            $image_profile=\Image::make($file_profile->getRealPath()); //Call image library installed.
            $destinationPath_profile ='img/users/profile/';
            $image_profile->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
            });
            $image_profile->save($destinationPath_profile.'profile_'.$picture_profile);
            //save image information on the db.
            $user->profile_image = $picture_profile;        
        }

        if ($request->hasFile('real_id') && $request->file('real_id') != NULL) {
            $file_real_id = $request->file('real_id');            
            //image data
            $filename_real_id = $file_real_id->getClientOriginalName();
            $extension_real_id = $file_real_id->getClientOriginalExtension();
            $picture_real_id = date('His').'_'.$filename_real_id;
            //optimize images and store image
            $image_real_id=\Image::make($file_real_id->getRealPath()); //Call image library installed.
            $destinationPath_real_id = 'img/users/real_id/';
            $image_real_id->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
            });
            $image_real_id->save($destinationPath_real_id.'real_id_'.$picture_real_id);
            //save image information on the db.
            $user->real_id = $picture_real_id;
        }

        $user->save();
        Flash::success('The user was updated.');
        return back()->withInput();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        Flash::error('The user: "<strong>'.$user->name.'"</strong> was deleted.');
        return redirect()->route('admin.users.index');
    }
}
