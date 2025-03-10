<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Session;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }


   public function sendOTP(Request $request)
   {
         $user = User::where('email', $request->email)->first();

        if (!$user) 
        {
            return response()->json(['error' => 'Incorrect email. Please enter the correct email.']);
        }

        $otp = mt_rand(100000, 999999); // Generate a random 6-digit OTP

        // Store OTP in the cache with a 15-minute expiration time
        //Cache::put('password_reset_' . $user->email, $otp, 15);

        // Store the OTP in the session with a key
        session(['password_reset_otp' => $otp]);


        // Send the OTP to the user's email using Laravel's Mail
        Mail::to($user->email)->send(new PasswordResetMail($otp)); // Replace with your mail implementation

        // Set a session variable to indicate that OTP is sent
          Session::put('otp_sent', true);
         return response()->json(['message' => 'OTP Send Successfully']);
   }



    public function ResetPasswordCheck(Request $request)
    {
      
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Handle the case where the user doesn't exist
            return redirect()->route('recoverpw')->withErrors(['status' => 'Incorrect Email. Please Check The Email!']);
        }
        
        $storedOtp = session('password_reset_otp');

        session(['email' => $request->email]);

        if ($storedOtp != $request->otp) {
            return redirect()->back()->withErrors(['status' => 'Incorrect OTP. Please Check The OTP!']);
        }

        return redirect()->route('forgetpassword');

    }

}
