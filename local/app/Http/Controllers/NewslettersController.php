<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Laracasts\Flash\Flash;
use App\Newsletter;
use Auth;
use Carbon;
use Config;


class NewslettersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request,$email,$categoryid)
    {

        $count = Newsletter::where('email',$email)->where('category_id',$categoryid)->count();
       
        if($count > 0){ //if is subscriber...
        return response()->json(['msg' => 'error']);

        }else{
        $newsletter = new Newsletter();
        $newsletter->email=$email;
        $newsletter->category_id=$categoryid;

        $newsletter->save();
        return response()->json(['msg' => 'success']);
        }
    }
    public function unsubscribe(Request $request,$email,$categoryid)
    {
        $newsletter = Newsletter::where('email',$email)->where('category_id',$categoryid)->first();
        $count = Newsletter::where('email',$email)->where('category_id',$categoryid)->count();
       
        if($count > 0){ //if is subscriber...UNSUBSCRIBE IT!            
        $newsletter->delete();
        return response()->json(['msg' => 'success']);
        }
    }
    public function isSubscriber(Request $request,$email=null,$categoryid=null){

        if($email != null && $categoryid != null){
            $count = Newsletter::where('email',$email)->where('category_id',$categoryid)->count();
            if($count > 0){
                return response()->json(['msg' => 'success']);
            }else{
                return response()->json(['msg' => 'error']);
            }

        }else{
            return response()->json(['msg' => 'error']);
        }
    }

}
