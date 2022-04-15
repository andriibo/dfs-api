<?php

use App\Http\Controllers\Api\Auth\ForgotPassword;
use App\Http\Controllers\Api\Auth\Login;
use App\Http\Controllers\Api\Auth\Logout;
use App\Http\Controllers\Api\Auth\RefreshToken;
use App\Http\Controllers\Api\Auth\Register;
use App\Http\Controllers\Api\Auth\ResetPassword;
use App\Http\Controllers\Api\Auth\VerifyEmail;
use App\Http\Controllers\Api\Auth\VerifyResend;
use App\Http\Controllers\Api\Contests\ContestsLobby;
use App\Http\Controllers\Api\Contests\ContestTypes;
use App\Http\Controllers\Api\Leagues\Leagues;
use App\Http\Controllers\Api\Users\Profile;
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

Route::prefix('v1')->group(function () {
    /*
     * ##################
     * #####  AUTH  #####
     * ##################
     */
    Route::prefix('auth')->group(function (): void {
        Route::post('register', Register::class);
        Route::post('login', Login::class);
        Route::post('forgot/password', ForgotPassword::class);
        Route::post('reset/password', ResetPassword::class)->name('password.reset');
        Route::middleware(['signed', 'throttle:6,1'])->group(function (): void {
            Route::get('/email/verify/{id}/{hash}', VerifyEmail::class)->name('verification.verify');
            Route::post('/email/verify/resend', VerifyResend::class)->name('verification.send');
        });
        Route::middleware('auth:api')->group(function (): void {
            Route::post('logout', Logout::class);
            Route::post('refresh/token', RefreshToken::class);
        });
    });

    /*
     * ###################
     * #####  USERS  #####
     * ###################
     */
    Route::prefix('users')->group(function (): void {
        Route::middleware('auth:api')->group(function (): void {
            Route::get('profile', Profile::class);
        });
    });

    /*
     * ######################
     * #####  CONTESTS  #####
     * ######################
     */
    Route::prefix('contests')->group(function () {
        Route::get('types', ContestTypes::class);
        Route::get('lobby', ContestsLobby::class);
    });

    /*
     * #####################
     * #####  LEAGUES  #####
     * #####################
     */
    Route::get('leagues', Leagues::class);
});
