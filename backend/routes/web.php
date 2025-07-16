<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Redirect root to admin dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/food-trucks/create', [AdminController::class, 'create'])->name('food-trucks.create');
    Route::post('/food-trucks', [AdminController::class, 'store'])->name('food-trucks.store');
    Route::get('/food-trucks/{foodTruck}/edit', [AdminController::class, 'edit'])->name('food-trucks.edit');
    Route::put('/food-trucks/{foodTruck}', [AdminController::class, 'update'])->name('food-trucks.update');
    Route::delete('/food-trucks/{foodTruck}', [AdminController::class, 'destroy'])->name('food-trucks.destroy');
    
    // Location reports
    Route::get('/location-reports', [AdminController::class, 'locationReports'])->name('location-reports');
    Route::post('/location-reports/{report}/approve', [AdminController::class, 'approveLocationReport'])->name('location-reports.approve');
    Route::post('/location-reports/{report}/reject', [AdminController::class, 'rejectLocationReport'])->name('location-reports.reject');
});
