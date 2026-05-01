<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{GlobalController, GiftcardController, AirtimeController, DataController};

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

Route::middleware(['throttle.api:60,1'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::get('balance', [GlobalController::class, 'balance']);
        Route::get('countries', [GlobalController::class, 'countries']);

        //Gift Card
        Route::get('cards/{card}', [GiftcardController::class, 'cards']);
        Route::get('cards_by_country/{country}', [GiftcardController::class, 'cardsByCountry']);
        Route::post('giftcard-quote', [GiftcardController::class, 'quote']);
        Route::post('giftcard-order', [GiftcardController::class, 'order']);
        Route::get('giftcard-transactions/{reference?}', [GiftcardController::class, 'transactions']);

        //Airtime
        Route::get('airtime/{operator}', [AirtimeController::class, 'operators']);
        Route::get('airtime_by_country/{country}', [AirtimeController::class, 'operatorsByCountry']);
        Route::post('airtime-quote', [AirtimeController::class, 'quote']);
        Route::post('airtime-order', [AirtimeController::class, 'order']);
        Route::get('airtime-transactions/{reference?}', [AirtimeController::class, 'transactions']);
        Route::post('airtime-number-lookup', [AirtimeController::class, 'numberLookup']);

        //Data
        Route::get('data/{operator}', [DataController::class, 'operators']);
        Route::get('data_by_country/{country}', [DataController::class, 'operatorsByCountry']);
        Route::post('data-quote', [DataController::class, 'quote']);
        Route::post('data-order', [DataController::class, 'order']);
        Route::get('data-transactions/{reference?}', [DataController::class, 'transactions']);
        Route::post('data-number-lookup', [DataController::class, 'numberLookup']);
    });
});
