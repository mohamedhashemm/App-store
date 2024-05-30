<?php

use App\Http\Controllers\Api\AccessTokensController;
use App\Http\Controllers\Api\productsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return Auth::guard('sanctum')->user();
});

Route::apiResource('products',productsController::class);

Route::post('auth/access_token',[AccessTokensController::class,'store'])->middleware('guest:sanctum');
Route::delete('auth/access_token/{token?}',[AccessTokensController::class,'destroy'])->middleware('guest:sanctum');
