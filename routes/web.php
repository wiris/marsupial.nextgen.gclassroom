<?php

use App\Connectors\GoogleAuthConnector;
use App\Http\Controllers\DeepLinkingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get(
    '/',
    fn () => Auth::check() ? to_route('materials.index') : to_route('login.google')
)->name('home');

Route::get('/login/google', [LoginController::class, 'redirectToGoogleLogin'])
    ->name('login.google');

Route::get('/login/google/callback', [LoginController::class, 'login'])
    ->name('login.google.callback');

Route::get('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('materials', MaterialController::class);
    Route::resource('tools', ToolController::class);

    Route::get('users/edit', [UserController::class, 'editByEmail'])
        ->name('users.edit.byemail');
    Route::resource('users', UserController::class);

    Route::get('lti/dl/link', [DeepLinkingController::class, 'deepLinkingInit'])
        ->name('lti.dl.link');

    Route::get('admin', fn () => auth()->user()->role == 'admin' ? Inertia::render('Admin') : Inertia::render('Forbidden'))
        ->name('admin');

    Route::get(
        'google/token',
        fn () => response()->json(json_decode(auth()->user()->google_access_token_json))
    );
});

Route::get('lti/dl/success', [DeepLinkingController::class, 'deepLinkingSuccess'])
    ->name('lti.dl.success');
