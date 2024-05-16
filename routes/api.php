<?php

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

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/forgot-password', [App\Http\Controllers\AuthController::class, 'forgotPassword']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/products', [App\Http\Controllers\API\ProductController::class, 'show']);
    Route::get('/outlets', [App\Http\Controllers\API\OutletController::class, 'outlets']);
    Route::get('/outlet/{id}', [App\Http\Controllers\API\OutletController::class, 'view']);
    Route::get('/outlet-tables/{outlet_id}', [App\Http\Controllers\API\OutletController::class, 'outlet_tables']);
    Route::get('/outlet-tables-floor/{outlet_id}', [App\Http\Controllers\API\OutletController::class, 'getFloor']);
    Route::get('/outlet-tables-floor/{outlet_id}/{floor}', [App\Http\Controllers\API\OutletController::class, 'outletTableByFloor']);
    Route::get('/table-detail/{code}', [App\Http\Controllers\API\OutletController::class, 'tableDetail']);
    Route::get('/banners', [App\Http\Controllers\API\DashboardController::class, 'banner']);
    Route::get('/my-bottles' , [App\Http\Controllers\API\DashboardController::class , 'myBottles']);

    Route::post('/rsvp-multi', [App\Http\Controllers\API\RSVPController::class, 'rsvpMulti']);

    Route::post('/order-product' , [App\Http\Controllers\API\OrderController::class , 'orderProduct']);
    Route::get('/event/{category}', [App\Http\Controllers\API\EventController::class, 'eventCategory']);
    Route::get('/event', [App\Http\Controllers\API\EventController::class, 'events']);

    Route::post('/update-profile',[App\Http\Controllers\API\DashboardController::class,'updateProfile']);
    Route::get('/profile' , [App\Http\Controllers\API\DashboardController::class , 'profile']);

    Route::get('/my-ticket' , [App\Http\Controllers\API\RSVPController::class , 'myTicket']);
    Route::get('/my-order' , [App\Http\Controllers\API\OrderController::class , 'myOrder']);

    Route::post('/redeem' , [App\Http\Controllers\API\ProductController::class , 'redeem']);
    Route::get('/redeem-history' , [App\Http\Controllers\API\DashboardController::class , 'redeemHistory']);

    Route::get('/gallery/{event_id}' , [App\Http\Controllers\API\EventController::class , 'gallery']);

});
Route::get('/product/{id}', [App\Http\Controllers\API\ProductController::class, 'view']);

Route::get('/category/{category}', [App\Http\Controllers\API\ProductController::class, 'category']);
Route::get('/send-wa', [App\Http\Controllers\API\EasywaController::class, 'sendMessage']);
Route::get('/top-spender', [App\Http\Controllers\API\DashboardController::class, 'top10spender']);
Route::get('/product-redeemables', [App\Http\Controllers\API\ProductController::class, 'productRedeemables']);
Route::get('/get-payments/{type}', [App\Http\Controllers\API\DashboardController::class, 'getPayments']);
