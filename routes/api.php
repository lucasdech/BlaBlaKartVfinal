<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TripController;
use App\Http\Controllers\API\AuthController;

// Public routes
Route::post('/api/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::get('/api/users', [UserController::class, 'index'])->middleware('admin');
    Route::get('/api/users/{id}', [UserController::class, 'show'])->middleware('can:view,user');
    Route::put('/api/users/{id}', [UserController::class, 'update'])->middleware('can:update,user');
    Route::delete('/api/users/{id}', [UserController::class, 'destroy'])->middleware('admin');

    // Trip routes
    Route::post('/api/trips', [TripController::class, 'store']);
    Route::get('api/trips', [TripController::class, 'index']);
    Route::get('api/trips/{id}', [TripController::class, 'show']);
    Route::put('api/trips/{id}', [TripController::class, 'update'])->middleware('can:update,trip');
    Route::delete('api/trips/{id}', [TripController::class, 'destroy'])->middleware('can:delete,trip');

    // Logout
    Route::post('/api/logout', [AuthController::class, 'logout']);
});