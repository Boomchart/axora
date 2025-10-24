<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

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

Route::middleware(['throttle:60,1'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::get('balance', [APIController::class, 'balance']);
        Route::get('countries/{return?}', [APIController::class, 'countries']);
        Route::get('cards/{country}/{card?}', [APIController::class, 'cards']);
        Route::post('quote', [APIController::class, 'quote']);
        Route::post('order', [APIController::class, 'order']);
        Route::get('transactions/{reference?}', [APIController::class, 'transactions']);
    });
});
