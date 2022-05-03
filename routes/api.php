<?php

use App\Http\Controllers\Api\Auth\ForgotPassword;
use App\Http\Controllers\Api\Auth\Login;
use App\Http\Controllers\Api\Auth\Logout;
use App\Http\Controllers\Api\Auth\RefreshToken;
use App\Http\Controllers\Api\Auth\Register;
use App\Http\Controllers\Api\Auth\ResetPassword;
use App\Http\Controllers\Api\Auth\VerifyEmail;
use App\Http\Controllers\Api\Auth\VerifyResend;
use App\Http\Controllers\Api\Contests\GameLogs;
use App\Http\Controllers\Api\Contests\History;
use App\Http\Controllers\Api\Contests\Live;
use App\Http\Controllers\Api\Contests\Lobby;
use App\Http\Controllers\Api\Contests\Players;
use App\Http\Controllers\Api\Contests\Show;
use App\Http\Controllers\Api\Contests\Types;
use App\Http\Controllers\Api\Contests\Upcoming;
use App\Http\Controllers\Api\Leagues\Leagues;
use App\Http\Controllers\Api\Transactions\DailyBonus;
use App\Http\Controllers\Api\Users\Balance;
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
        Route::middleware('guest')->group(function (): void {
            Route::post('register', Register::class);
            Route::post('login', Login::class);
            Route::post('forgot/password', ForgotPassword::class);
            Route::post('reset/password', ResetPassword::class)->name('password.reset');
        });
        Route::middleware(['signed'])->group(function (): void {
            Route::get('/email/verify/{id}/{hash}', VerifyEmail::class)->name('verification.verify');
        });
        Route::middleware(['throttle:6,1'])->group(function (): void {
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
            Route::get('balance', Balance::class);
        });
    });

    /*
     * ######################
     * #####  CONTESTS  #####
     * ######################
     */
    Route::prefix('contests')->group(function () {
        Route::get('{id}', Show::class)->where('id', '[0-9]+');
        Route::get('types', Types::class);
        Route::get('lobby', Lobby::class);
        Route::middleware('auth:api')->group(function (): void {
            Route::get('upcoming', Upcoming::class);
            Route::get('live', Live::class);
            Route::get('history', History::class);
            Route::get('{id}/players', Players::class);
            Route::get('{id}/game-logs', GameLogs::class);
        });
    });

    /*
     * ########################
     * ##### TRANSACTIONS #####
     * ########################
     */
    Route::prefix('transactions')->group(function (): void {
        Route::middleware(['throttle:6,1', 'auth:api'])->group(function (): void {
            Route::get('daily-bonus', DailyBonus::class);
        });
    });

    /*
     * #####################
     * #####  LEAGUES  #####
     * #####################
     */
    Route::get('leagues', Leagues::class);
});
