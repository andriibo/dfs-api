<?php

use App\Http\Controllers\Api\Contests\ContestsLobbyGet;
use App\Http\Controllers\Api\Contests\ContestTypesGet;
use App\Http\Controllers\Api\Leagues\LeaguesGet;
use App\Http\Controllers\Api\Users\UserGet;
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

Route::prefix('v1')->group(function () {
    /*
     * #####################
     * #####  USERS  #####
     * #####################
     */
    Route::get('users/{id}', UserGet::class);

    /*
     * #####################
     * #####  LEAGUES  #####
     * #####################
     */
    Route::get('leagues', LeaguesGet::class);

    /*
     * #####################
     * #####  CONTESTS  #####
     * #####################
     */
    Route::get('contests/types', ContestTypesGet::class);
    Route::get('contests/lobby', ContestsLobbyGet::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
