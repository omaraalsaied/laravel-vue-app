<?php

use App\Http\Controllers\Api\AuthenticationController;
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

Route::group(["namespace"=> "Api","prefix"=> "v1"], function () {
    Route::post('register', [AuthenticationController::class,'register']);
    Route::post('login', [AuthenticationController::class,'login']);
    Route::post('logout', [AuthenticationController::class,'logout'])->middleware('auth:api');
});
