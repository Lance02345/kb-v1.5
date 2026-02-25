<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon; 
use Mail; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;
use App\Models\User; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Support\JourneyMailer;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

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

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);

        Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }
    /**
     * Write code on Method
     *
     */
    public function showResetPasswordForm($token) { 
       return view('auth.confirm', ['token' => $token]);
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

    if(!$updatePassword){{
        return redirect()->to(route('auth.email'));
    }    
    }

    DB::table('users')->where('email', $request->email)
    ->update(['password' => Hash::make($request->password)]);

    $user = User::where('email', $request->email)->first();
    if ($user) {
        JourneyMailer::sendPasswordChanged($user);
    }

    DB::table('password_resets')->where(['email'=> $request->email])->delete();

    return redirect('/')->with('message', 'Your password has been changed!');
}
}
