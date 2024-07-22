<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TripController;
use App\Http\Controllers\API\AuthController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::get('/users', [UserController::class, 'index'])->middleware('admin');
    Route::get('/users/{id}', [UserController::class, 'show'])->middleware('can:view,user');
    Route::put('/users/{id}', [UserController::class, 'update'])->middleware('can:update,user');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('admin');

    // Trip routes
    Route::post('/trips', [TripController::class, 'store']);
    Route::get('/trips', [TripController::class, 'index']);
    Route::get('/trips/{id}', [TripController::class, 'show']);
    Route::put('/trips/{id}', [TripController::class, 'update'])->middleware('can:update,trip');
    Route::delete('/trips/{id}', [TripController::class, 'destroy'])->middleware('can:delete,trip');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});