<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MultiplePostController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PostImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest:admin']], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::group(['middleware' => ['auth:admin']], function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::group([
        'as' => 'admin.',
    ], function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::delete('/post/multiple', [MultiplePostController::class, 'destroy'])->name('post.multiple.destroy');

        Route::controller(PostController::class)->group(function () {
            Route::delete('/post/{post}', 'destroy')->name('post.destroy');
            Route::post('/post/{post}/restore', 'restore')->name('post.restore');
        });

        Route::delete('/post/{post}/image', [PostImageController::class, 'destroy'])->name('post.image.destroy');
    });
});
