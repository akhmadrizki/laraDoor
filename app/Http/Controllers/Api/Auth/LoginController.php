<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Login
     */
    public function login(Request $request)
    {
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

            return response()->json($account, 200);
        } else {
            return response()->json([
                'statusCode' => 401,
                'error'      => "Unauthorized"
            ], 401);
        }
    }
}
