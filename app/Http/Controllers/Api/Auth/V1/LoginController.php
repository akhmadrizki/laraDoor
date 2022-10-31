<?php

namespace App\Http\Controllers\Api\Auth\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Login
     */
    public function login(Request $request)
    {
        Validator::make($request->all(), [
            'email'    => 'required',
            'password' => 'required',
        ])->validate();

        $login = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($login)) {
            $account['token'] = Auth::user()->createToken('MyApp')->accessToken;
            $account['id']    = Auth::user()->id;
            $account['name']  = Auth::user()->name;
            $account['email'] = Auth::user()->email;
            $account['role']  = Auth::user()->role;

            return response()->json([
                'data' => $account
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'code'    => 401,
                    'title'   => 'Authentication Failed',
                    'message' => 'Unauthenticated'
                ]
            ], 401);
        }
    }
}
