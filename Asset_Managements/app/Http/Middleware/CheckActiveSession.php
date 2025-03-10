<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLog;

class CheckActiveSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {
            $user = Auth::user();

            // Check for an active session
            $activeLog = UserLog::where('user_id', $user->id)
                                ->where('user_log_status', '=' , 'I')
                                ->whereNull('logout_time')
                                ->first();

            if ($activeLog && $activeLog->login_time != $user->updated_at) {
                // Log out the current user
                Auth::logout();

                return redirect('/login');
            }
        }

        return $next($request);
    }
}
