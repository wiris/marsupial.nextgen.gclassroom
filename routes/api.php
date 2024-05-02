<?php

use App\Http\Controllers\DeepLinkingController;
use App\Http\Controllers\LineitemController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OidcController;
use App\Http\Controllers\TokenController;
use App\Models\Lineitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get(
    'oidc/jwks',
    [OidcController::class, 'jwks']
)->name('oidc.jwks');

Route::get(
    'oidc/auth',
    [OidcController::class, 'auth']
)->name('oidc.auth');

Route::post(
    'token',
    TokenController::class
)->name('token');

Route::post(
    'lti/dl/return',
    [DeepLinkingController::class, 'deepLinkingReturn']
)->name('lti.dl');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('materials/{material}/lineitems/{lineitem}/scores', [LineitemController::class, 'score']);
    Route::get('materials/{material}/lineitems/{lineitem}', [LineitemController::class, 'show'])
        ->name('materials.lineitems.show');
    Route::get('materials/{material}/lineitems', [LineitemController::class, 'index'])
        ->name('materials.lineitems.index');
});
