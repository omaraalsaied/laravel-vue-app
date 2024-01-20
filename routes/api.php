<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;

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

Route::group(["namespace" => "Api", "prefix" => "v1"], function () {
    Route::post('register', [AuthenticationController::class, 'register']);
    Route::post('login', [AuthenticationController::class, 'login']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', [AuthenticationController::class, 'logout']);
        Route::get('/', [PostController::class, 'index']);

        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', [PostController::class, 'index']);
            Route::get('{id}', [PostController::class, 'show']);
            Route::post('store', [PostController::class, 'store']);
            Route::patch('update/{id}', [PostController::class, 'update']);
            Route::delete('{id}', [PostController::class, 'destroy']);
        });

    });

});
