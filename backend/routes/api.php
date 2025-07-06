<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FoodTruckController;

// API routes for mobile app
Route::prefix('v1')->group(function () {
    Route::get('/food-trucks', [FoodTruckController::class, 'index']);
    Route::get('/food-trucks/{foodTruck}', [FoodTruckController::class, 'show']);
    Route::put('/food-trucks/{foodTruck}/location', [FoodTruckController::class, 'updateLocation']);
});

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'timestamp' => now()->toISOString(),
        'version' => '1.0.0'
    ]);
});
