<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomEmailException;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Response;
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
        $user = Auth::guard($guard)->user();

        if ($user && ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail())) {
            throw new CustomEmailException(
                Response::HTTP_FORBIDDEN,
                'Your email address is not verified.',
                'Unverified email address',
            );
        }

        // if (Auth::guard($guard)->user() && (Auth::guard($guard)->user() instanceof MustVerifyEmail && !Auth::guard($guard)->user()->hasVerifiedEmail())) {
        //     flash('Sorry, your account has not been activated 🤯')->error();

        //     return $request->expectsJson()
        //         ? abort(403, 'Your email address is not verified.')
        //         : Redirect::guest(URL::route('verification.notice'));
        // }

        if (Auth::guard($guard)->check()) {
            Auth::shouldUse($guard);
        }

        return $next($request);
    }
}
