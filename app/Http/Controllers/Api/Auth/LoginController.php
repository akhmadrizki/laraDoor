<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
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
        $login = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        $validator = Validator::make($request->all(), [
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $err = [];

        foreach ($validator->errors()->getMessages() as $key => $value) {
            $err[] = [
                'key'     => $key,
                'message' => $value[0],
            ];
        }

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'error' => [
                    'code'    => 422,
                    'title'   => 'Validation Error',
                    'message' => 'The given data was invalid.',
                    'errors'  => $err
                ]
            ], 422));
        }

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
