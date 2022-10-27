<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->delete();

        return response()->json([
            'statusCode' => 200,
            'message'    => 'You have been succesfully logged out'
        ], 200);
    }
}
