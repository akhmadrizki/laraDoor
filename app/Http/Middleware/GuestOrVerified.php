<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class GuestOrVerified
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
        if (
            Auth::guard($guard)->user() &&
            (Auth::guard($guard)->user() instanceof MustVerifyEmail &&
                !Auth::guard($guard)->user()->hasVerifiedEmail())
        ) {
            flash('Sorry, your account has not been activated 🤯')->error();

            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : Redirect::guest(URL::route('verification.notice'));
        }

        return $next($request);
    }
}
