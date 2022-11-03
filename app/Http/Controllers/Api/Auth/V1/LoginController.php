<?php

namespace App\Http\Controllers\Api\Auth\V1;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:api')->except('logout');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $user = User::where('email', $request->input('email'))
            ->where('role', Role::User)
            ->first();

        if (!$user) {
            return false;
        }

        $this->guard()->setUser($user);

        return Hash::check($request->input('password'), $user->password);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('api');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        $user = $this->guard()->user();

        return response()->json([
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $user->createToken('MyApp')->accessToken
            ]
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['role' => Role::Admin]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->delete();

        return response()->json(status: 204);
    }

    /**
     * Login
     */
    // public function login(Request $request)
    // {
    //     Validator::make($request->all(), [
    //         'email'    => 'required',
    //         'password' => 'required',
    //     ])->validate();

    //     $login = [
    //         'email'    => $request->email,
    //         'password' => $request->password
    //     ];

    //     if (auth()->attempt($login)) {
    //         $account['token'] = Auth::user()->createToken('MyApp')->accessToken;
    //         $account['id']    = Auth::user()->id;
    //         $account['name']  = Auth::user()->name;
    //         $account['email'] = Auth::user()->email;
    //         $account['role']  = Auth::user()->role;

    //         return response()->json([
    //             'data' => $account
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'error' => [
    //                 'code'    => 401,
    //                 'title'   => 'Authentication Failed',
    //                 'message' => 'Unauthenticated'
    //             ]
    //         ], 401);
    //     }
    // }
}
