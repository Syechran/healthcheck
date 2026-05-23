<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DetectionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes (rate-limited)
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');

/*
|--------------------------------------------------------------------------
| Protected routes (require a valid JWT — Authorization: Bearer <token>)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::apiResource('detections', DetectionController::class)
        ->only(['index', 'store', 'show', 'destroy']);
});
