<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon; 
use Mail;
use Illuminate\Support\Facades\DB; 
use App\Models\User; 
use Illuminate\Http\Request; 
use Illuminate\Support\Str;
use App\Support\JourneyMailer;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    public function showForgetPasswordForm()
    {
       return view('auth.email');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();
        $token = Str::random(64);

        DB::table('password_resets')->where('email', $request->email)->delete();
        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token, 'email' => $request->email], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        JourneyMailer::sendPasswordResetRequested($user);

        return back()->with('status', 'Reset link sent. Please check your email.');
    }
    /**
     * Write code on Method
     *
     */
    public function showResetPasswordForm(Request $request, $token) { 
       return view('auth.confirm', ['token' => $token, 'email' => $request->query('email')]);
    }

    /**
     * Write code on Method
     *
     */
    public function submitResetPasswordForm(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users',
        'password' => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required'
    ]);

    $updatePassword = DB::table('password_resets')
                        ->where([
                            'email' => $request->email, 
                            'token' => $request->token
                        ])
                        ->first();

    if(!$updatePassword){
        return back()->withInput()->withErrors(['email' => 'This reset link is invalid or already used.']);
    }

    $user = User::where('email', $request->email)->firstOrFail();
    $user->password = $request->password;
    $user->setRememberToken(Str::random(60));
    $user->save();

    if ($user) {
        JourneyMailer::sendPasswordChanged($user);
    }

    DB::table('password_resets')->where(['email'=> $request->email])->delete();

    return redirect()->route('user.login')->with('status', 'Your password has been changed. You can now log in.');
}
}
