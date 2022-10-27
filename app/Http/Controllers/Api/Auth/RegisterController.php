<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
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

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        event(new Registered($user));

        $token = $user->createToken('MyApp')->accessToken;

        return response()->json([
            'statusCode' => 200,
            'message'    => 'We send confirmation e-mail to you',
            'token'      => $token
        ], 200);
    }
}
