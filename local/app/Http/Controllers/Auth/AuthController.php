<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialite;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\ActivationService;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $activationService;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(ActivationService $activationService)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->activationService = $activationService;
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'profile_image' => 'required|image',
            'tagline' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    
    protected function create(array $data)
    {
      $destinationPath = 'img/users/profile/'; // upload path
      
      $extension = $data['profile_image']->getClientOriginalExtension(); // getting image extension

      $fileName = rand(11111,99999).'.'.$extension; // renameing image
      $data['profile_image']->move($destinationPath, 'profile_'.$fileName); // uploading file to given path

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'tagline' =>$data['tagline'],
            'bkash' => $data['bkash'],
            'twitter_real' => $data['twitter_real'],
            'facebook_real' => $data['facebook_real'],
            'profile_image' => $fileName ,
            'password' => bcrypt($data['password'])
        ]);
    }
        /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function showActivatedForm(){
        return view('auth.activated');
    }
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());      
        if ($validator->fails()) {
           return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = $this->create($request->all());

        $this->activationService->sendActivationMail($user);

        return redirect('/login')->with('status', 'We sent you an activation code. Check your email.'); 
    }
    public function authenticated(Request $request, $user)
    {
        if (!$user->activated) {
            $this->activationService->sendActivationMail($user);
            auth()->logout();
            return back()->with('status', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        return redirect()->intended($this->redirectPath());
    }
    public function activateUser(Request $request,$token)
    {
        if ($user = $this->activationService->activateUser($token)) {
           auth()->logout();
           return redirect('/activated');
        }
        abort(404);
    }
}
