<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\API\VetController;
use App\Http\Controllers\API\OwnerController;
use App\Http\Controllers\API\PetController;
use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\TreatmentController;
use App\Http\Controllers\API\PrescriptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 🔓 Public routes
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// 🔐 Protected routes
Route::middleware(['auth:sanctum'])->group(function () {

    // 🔓 Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // 👑 Super Admin routes
    Route::middleware('role:super_admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'stats']);
        Route::get('/dashboard-stats', [DashboardController::class, 'index']);
        Route::apiResource('vets', VetController::class);
        Route::apiResource('owners', OwnerController::class);
        // Route::apiResource('admins', AdminController::class); // optional
    });

    // 🧑‍💼 Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'stats']);
        Route::get('/dashboard-stats', [DashboardController::class, 'index']);
        Route::apiResource('vets', VetController::class);
        Route::apiResource('owners', OwnerController::class);
    });

    // 🩺 Doctor routes
    Route::middleware('role:doctor')->group(function () {
        Route::apiResource('appointments', AppointmentController::class);
        Route::get('/appointments/upcoming', [AppointmentController::class, 'upcoming']);
        Route::post('/appointments/{id}/complete', [AppointmentController::class, 'complete']);
        Route::apiResource('treatments', TreatmentController::class);
        Route::apiResource('prescriptions', PrescriptionController::class);
    });

    // 👨‍💼 Assistant routes
    Route::middleware('role:assistant')->group(function () {
        // Add assistant-specific routes here
    });

    // 🐾 Owner routes
    Route::middleware('role:owner')->group(function () {
        Route::apiResource('pets', PetController::class);
        // Additional owner routes (like their own appointments) can go here
    });
});
