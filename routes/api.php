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
    Route::get('/product/{id}', [App\Http\Controllers\API\ProductController::class, 'view']);
    Route::get('/outlets' , [App\Http\Controllers\API\OutletController::class , 'outlets']);
    Route::get('/outlet-tables/{outlet_id}' , [App\Http\Controllers\API\OutletController::class , 'outlet_tables']);
    Route::get('/banners', [App\Http\Controllers\API\DashboardController::class, 'banner']);

});

Route::get('/send-wa', [App\Http\Controllers\API\EasywaController::class, 'sendMessage']);