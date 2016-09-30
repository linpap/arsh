<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Socialite;
use App\User;
class SocialAuth2Controller extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function redirectToProvider2()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function twitterCallback()
    {
        // Important change from previous post is that I'm now passing
        // whole driver, not only the user. So no more ->user() part
        $user = Socialite::driver('twitter')->user();
        // OAuth Two Providers
        $token = $user->token;

        // OAuth One facebookfacebookfacebookfacebookfacebookfacebook
        $token = $user->token;
       
        //All Providers
        $user->getId();
        $user->getNickname();
        $user->getName();
        $user->getEmail();
        $user->getAvatar();
        $my_user = User::where('email','=', $user->getEmail())->first();
        if($my_user == null) {
            $newUser = new User();
            $newUser->name =$user->getName();
            $newUser->email = $user->getEmail();
            $newUser->twitter_id = $user->getId();
            $newUser->activated=1;
            $newUser->profile_image = $user->avatar_original;
            $newUser->type = "subscriber";
            Auth::login($newUser, true);
        }else {
            $my_user->profile_image=$user->avatar_original;
            $my_user->twitter_id = $user->getId();
            $my_user->activated=1;
            $my_user->save();
            Auth::login($my_user,true);
        }       

        return redirect()->to('/admin');
    }
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();

        // OAuth Two Providers
        $token = $user->token;
        $refreshToken = $user->refreshToken; // not always provided
        $expiresIn = $user->expiresIn;

        // OAuth One facebookfacebookfacebookfacebookfacebookfacebook
        $token = $user->token;

        // All Providers
        $user->getId();
        $user->getNickname();
        $user->getName();
        $user->getEmail();
        $user->getAvatar();
        
        $my_user = User::where('email','=', $user->getEmail())->first();
	    if($my_user == null) {
		    $newUser = new User();
	        $newUser->name =$user->getName();
	        $newUser->email = $user->getEmail();
	        $newUser->facebook_id = $user->getId();
            $newUser->activated=1;
	        $newUser->profile_image = $user->getAvatar();
	        $newUser->type = "subscriber";
	        Auth::login($newUser, true);
	    }else {
            $my_user->profile_image = $user->getAvatar();
	    	$my_user->facebook_id = $user->getId();
            $my_user->activated=1;
	        Auth::login($my_user,true);
	    }        
        return redirect()->to('/admin');

    }
}
