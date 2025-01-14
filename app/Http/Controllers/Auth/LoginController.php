<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function redirectPath()
    {
        /**
        *if (auth()->user()->user_type == 'admin') {
        *    return route('admin.dashboard');
       * }
       * if (auth()->user()->user_type == 'user') {
        *    return route('user.dashboard');
       * } return route('index');
        */

        if (auth()->user()->is_superadmin) {
            return route('admin.dashboard');
        }
        if (auth()->user()->is_manager) {
            return route('index');
        }
        if (auth()->user()->is_admin) {
            return route('admin.dashboard');
        }
        if (auth()->user()->is_user) {
            return route('user.my_list');
        }
        if (auth()->user()->is_business) {
            return route('user.my_list');
        }

        return abort(404);
    }

    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();
        if(!$user){
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        }

        Auth::login($user);
    }

    //Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

     //Google callbacks
 public function handleGoogleCallback()
{
    try {
        $user = Socialite::driver('google')->user();

        // Check if a user with this email exists in your database
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            // If the user already exists, log them in
            Auth::login($existingUser);

            // Redirect to the home page or dashboard
 return redirect()->route('user.my_list');
        } else {
            // If the user doesn't exist, throw an error
            return redirect('/login')->with('error', 'User not found. Please sign up.');
        }
    } catch (\Exception $e) {
        // Handle any exceptions that may occur
        return redirect('/login')->with('error', 'Google login failed');
    }
}

    //Facebok login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    //Facebook callbacks
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('user.my_list');
    }


}
