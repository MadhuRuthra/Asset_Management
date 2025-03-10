<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\UserLog;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $ip = $request->ip();
        $current_date = date("Y-m-d");
        $current_time = date("Y-m-d H:i:s");

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Get the authenticated user
            $user = Auth::user();

            // Check if the user is already logged in
            $activeLog = UserLog::where('user_id', $user->id)
                                ->where('user_log_status', '=' , 'I')
                                ->whereNull('logout_time')
                                ->first();

            if ($activeLog) {
                // Log out the previous session
                $activeLog->update(['logout_time' => Carbon::now(), 'user_log_status' => 'O']);
            }

            // Log the login details
            UserLog::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'login_date' => $current_date,
                'login_time' => $current_time,
                'user_log_entry_date' => $current_time,
            ]);

            $user = User::find($user->id);

            if ($user) {
                $user->update(['updated_at' => $current_time]);
            }

        }

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {

        $user = Auth::user();
        $current_time = date("Y-m-d H:i:s");

          // Update the logout time
          UserLog::where('user_id', $user->id)
          ->whereNull('logout_time')
          ->update(['logout_time' => $current_time, 'user_log_status' => 'O']);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
