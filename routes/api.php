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
use App\Http\Controllers\Api\Contests\Show as ContestShow;
use App\Http\Controllers\Api\Contests\Types;
use App\Http\Controllers\Api\Contests\Units as ContestUnits;
use App\Http\Controllers\Api\Contests\Upcoming;
use App\Http\Controllers\Api\ContestUsers\Opponent;
use App\Http\Controllers\Api\ContestUsers\Show as ContestUserShow;
use App\Http\Controllers\Api\Leagues\Leagues;
use App\Http\Controllers\Api\Leagues\SportConfig;
use App\Http\Controllers\Api\StaticPages\Show as StaticPageShow;
use App\Http\Controllers\Api\Transactions\DailyBonus;
use App\Http\Controllers\Api\Transactions\Transactions;
use App\Http\Controllers\Api\Users\Balance;
use App\Http\Controllers\Api\Users\ChangePassword;
use App\Http\Controllers\Api\Users\Show as Profile;
use App\Http\Controllers\Api\Users\Update as ProfileUpdate;
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
            Route::put('profile', ProfileUpdate::class);
            Route::patch('password', ChangePassword::class);
        });
    });

    /*
     * ######################
     * #####  CONTESTS  #####
     * ######################
     */
    Route::prefix('contests')->group(function () {
        Route::get('{id}', ContestShow::class)->where('id', '[0-9]+');
        Route::get('types', Types::class);
        Route::get('lobby', Lobby::class);
        Route::middleware('auth:api')->group(function (): void {
            Route::get('upcoming', Upcoming::class);
            Route::get('live', Live::class);
            Route::get('history', History::class);
            Route::get('{id}/players', Players::class)->where('id', '[0-9]+');
            Route::get('{id}/game-logs', GameLogs::class)->where('id', '[0-9]+');
            Route::post('{id}/units', ContestUnits::class)->where('id', '[0-9]+');
        });
    });

    /*
     * ###########################
     * #####  CONTEST USERS  #####
     * ###########################
     */
    Route::prefix('contest-users')->group(function () {
        Route::middleware(['auth:api', 'contest.user.access'])->group(function (): void {
            Route::get('{id}/opponent/{opponentId}', Opponent::class)
                ->where('id', '[0-9]+')
                ->where('opponentId', '[0-9]+')
            ;
            Route::get('{id}', ContestUserShow::class)->where('entryId', '[0-9]+')
            ;
        });
    });

    /*
     * ########################
     * ##### TRANSACTIONS #####
     * ########################
     */
    Route::prefix('transactions')->group(function (): void {
        Route::middleware('auth:api')->group(function (): void {
            Route::get('', Transactions::class);
            Route::middleware('throttle:6,1')->get('daily-bonus', DailyBonus::class);
        });
    });

    /*
     * #####################
     * #####  LEAGUES  #####
     * #####################
     */
    Route::prefix('leagues')->group(function (): void {
        Route::get('', Leagues::class);
        Route::get('{id}/sport-config', SportConfig::class);
    });

    /*
     * ########################
     * ##### Static Pages #####
     * ########################
     */
    Route::get('static-pages/{name}', StaticPageShow::class);
});
