<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Support\JourneyMailer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

        $user = auth()->user();
        if ($user && !$user->roles()->exists()) {
            $this->assignDefaultUserRole($user);
        }

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

        return route('user.my_list');
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

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            $this->assignDefaultUserRole($existingUser);
            Auth::login($existingUser);

            return redirect()->route('user.my_list');
        } else {
            $newUser = User::create([
                'name' => $user->name ?: 'Google User',
                'email' => $user->email,
                'password' => Hash::make(Str::random(32)),
            ]);

            $newUser->provider_id = $user->id;
            $newUser->save();
            $this->assignDefaultUserRole($newUser);
            JourneyMailer::sendWelcome($newUser);

            Auth::login($newUser);

            return redirect()
                ->route('user.user_profile', $newUser->id)
                ->with('info', 'Your Google account has been created. Please add your phone number and profile details.');
        }
    } catch (\Exception $e) {
        return redirect()->route('login')->with('google_error', 'Google sign-in failed. Please try again.');
    }
}

    private function assignDefaultUserRole(User $user): void
    {
        $role = Role::query()
            ->where('title', 'user')
            ->orWhere('id', 3)
            ->first();

        if ($role) {
            $user->roles()->syncWithoutDetaching([$role->id]);
        }
    }
}
