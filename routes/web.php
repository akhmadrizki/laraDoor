<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/', '/post');

Route::resource('/post', PostController::class)->middleware('is.verified');

Route::post('/password-validation/{post}/{method}', [PostController::class, 'passValidation'])->name('pass.validate');

Auth::routes(['verify' => true, 'reset' => false]);

Route::get('/verify/success', [VerificationController::class, 'verified'])->name('verify.success');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
