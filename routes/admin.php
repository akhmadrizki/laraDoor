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

Route::group(['middleware' => ['guest:admin', 'PreventBackHistory']], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::group(['middleware' => ['auth:admin', 'PreventBackHistory']], function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::group([
        'as' => 'admin.',
    ], function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::delete('/post/selectDelete', [MultiplePostController::class, 'destroy'])->name('delete-selected');

        Route::controller(PostController::class)->group(function () {
            Route::delete('/post/{post}', 'destroy')->name('destroy');
            Route::post('/post/{post}/restore', 'restore')->name('restore');
        });

        Route::delete('/post/{post}/delete-image', [PostImageController::class, 'destroy'])->name('destroy-image');
    });
});
