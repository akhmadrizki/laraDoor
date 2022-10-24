<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GuestOrVerifiedApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle($request, Closure $next, ?string $guard = null)
    {
        if (Auth::guard($guard)->user() && (Auth::guard($guard)->user() instanceof MustVerifyEmail && !Auth::guard($guard)->user()->hasVerifiedEmail())) {
            // Auth::setUser(Auth::guard($guard)->user());
            // return 'gagal';
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : $next($request);
        }

        return $next($request);
        // return response()->json('error');
    }
}
