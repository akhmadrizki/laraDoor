<?php

use App\Http\Controllers\Api\Auth\V1\LoginController;
use App\Http\Controllers\Api\Auth\V1\LogoutController;
use App\Http\Controllers\Api\Auth\V1\RegisterController;
use App\Http\Controllers\Api\Auth\VerificationController;
use App\Http\Controllers\Api\User\V1\PostController;
use App\Http\Controllers\Api\User\V1\PostImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/web/v1/doc', function () {
    return view('api-doc');
});

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::delete('/logout', [LogoutController::class, 'logout'])->middleware('auth:api');

Route::get('email/verify/{user}', [VerificationController::class, 'verify']);

Route::get('/post', [PostController::class, 'index'])->name('post');
Route::get('/post/{post}', [PostController::class, 'show']);

Route::middleware('guestOrVerified:api')->group(function () {
    Route::post('/post', [PostController::class, 'store']);
    Route::put('/post/{post}', [PostController::class, 'update']);
    Route::delete('/post/{post}', [PostController::class, 'destroy']);

    Route::post('/post/{post}/image', [PostImageController::class, 'store']);
});
